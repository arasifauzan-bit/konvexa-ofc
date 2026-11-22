<?php

namespace Tests\Feature;

use App\Models\OrderTracking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_tracking_page_is_a_separate_page_linked_from_the_homepage(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('tracking.index'));

        $this->get(route('tracking.index'))
            ->assertOk()
            ->assertSee('Tracking Pesanan')
            ->assertSee('Contoh: KVX2610112')
            ->assertSee('Nama pelanggan')
            ->assertSee('oninput="this.value = this.value.toUpperCase()"', false)
            ->assertSee(route('tracking.lookup'));
    }

    public function test_customer_name_lookup_is_case_insensitive(): void
    {
        OrderTracking::query()->create([
            'order_number' => 'KVX2610112',
            'customer_name' => 'KEVIN',
            'status' => 'jahit',
        ]);

        $this->post(route('tracking.lookup'), [
            'order_number' => 'kvx2610112',
            'customer_name' => 'kEvIn',
        ])
            ->assertOk()
            ->assertSee('KVX2610112')
            ->assertSee('Jahit')
            ->assertSee('Sedang berlangsung')
            ->assertSee('Finishing');
    }

    public function test_tracking_lookup_does_not_reveal_orders_when_name_does_not_match(): void
    {
        OrderTracking::query()->create([
            'order_number' => 'KVX2610112',
            'customer_name' => 'KEVIN',
            'status' => 'jahit',
        ]);

        $this->post(route('tracking.lookup'), [
            'order_number' => 'KVX2610112',
            'customer_name' => 'RINA',
        ])
            ->assertOk()
            ->assertSee('Pesanan tidak ditemukan')
            ->assertDontSee('Progres produksi pesanan Anda');
    }

    public function test_admin_can_create_and_update_tracking_status(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->post(route('admin.tracking.store'), [
                'order_number' => ' kvx2610112 ',
                'customer_name' => 'kEvIn',
                'status' => 'antrian',
            ])
            ->assertRedirect(route('admin.tracking.index'));

        $orderTracking = OrderTracking::query()->firstOrFail();
        $this->assertSame('KVX2610112', $orderTracking->order_number);
        $this->assertSame('KEVIN', $orderTracking->customer_name);

        $this->put(route('admin.tracking.update', $orderTracking), [
            'order_number' => 'KVX2610112',
            'customer_name' => 'Kevin',
            'status' => 'pembelian_bahan',
        ])
            ->assertRedirect(route('admin.tracking.index'));

        $this->assertDatabaseHas('order_trackings', [
            'id' => $orderTracking->id,
            'customer_name' => 'KEVIN',
            'status' => 'pembelian_bahan',
        ]);
    }

    public function test_guest_cannot_manage_tracking_orders(): void
    {
        $this->get(route('admin.tracking.index'))
            ->assertRedirect(route('login'));
    }

    public function test_automatic_tracking_sync_endpoint_is_disabled(): void
    {
        $this->postJson('/api/integrations/order-tracking', [
            'order_number' => 'KVX2610112',
            'customer_name' => 'Kevin',
        ])->assertNotFound();
    }

}

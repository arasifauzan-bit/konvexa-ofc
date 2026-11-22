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
            'status' => 'produksi',
            'progress_note' => 'Bordir dulu, kemudian dijahit.',
        ]);

        $this->post(route('tracking.lookup'), [
            'order_number' => 'kvx2610112',
            'customer_name' => 'kEvIn',
        ])
            ->assertOk()
            ->assertSee('KVX2610112')
            ->assertSee('Proses Produksi (Potong, Jahit, Bordir/Sablon)')
            ->assertSee('Bordir dulu, kemudian dijahit.')
            ->assertSee('Sedang berlangsung')
            ->assertSee('Finishing')
            ->assertSee('Selesai')
            ->assertSee('Terakhir diperbarui ' . OrderTracking::query()->firstOrFail()->updated_at->format('d/m/Y'))
            ->assertDontSee(OrderTracking::query()->firstOrFail()->updated_at->format('H:i'));
    }

    public function test_tracking_lookup_does_not_reveal_orders_when_name_does_not_match(): void
    {
        OrderTracking::query()->create([
            'order_number' => 'KVX2610112',
            'customer_name' => 'KEVIN',
            'status' => 'produksi',
        ]);

        $this->post(route('tracking.lookup'), [
            'order_number' => 'KVX2610112',
            'customer_name' => 'RINA',
        ])
            ->assertOk()
            ->assertSee('Nomor pesanan sudah sesuai, tetapi nama pemesan tidak cocok.')
            ->assertSee('Coba cek kembali nama pada nota Anda.')
            ->assertDontSee('Progres produksi pesanan Anda');
    }

    public function test_tracking_lookup_tells_customer_when_order_has_not_been_added(): void
    {
        $this->post(route('tracking.lookup'), [
            'order_number' => 'KVX2610112',
            'customer_name' => 'KEVIN',
        ])
            ->assertOk()
            ->assertSee('Pesanan belum ditambahkan oleh admin.')
            ->assertSee('Silakan hubungi admin')
            ->assertDontSee('Nomor pesanan sudah sesuai');
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

        $this->put(route('admin.tracking.update', $orderTracking), [
            'order_number' => 'KVX2610112',
            'customer_name' => 'Kevin',
            'status' => 'selesai',
            'progress_note' => '',
        ])
            ->assertRedirect(route('admin.tracking.index'));

        $this->post(route('tracking.lookup'), [
            'order_number' => 'KVX2610112',
            'customer_name' => 'Kevin',
        ])
            ->assertOk()
            ->assertSee('Selesai')
            ->assertSee('Pesanan Anda telah selesai dan diserahkan.');
    }

    public function test_admin_tracking_list_shows_update_date_without_time(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $orderTracking = OrderTracking::query()->create([
            'order_number' => 'KVX2610112',
            'customer_name' => 'KEVIN',
            'status' => 'produksi',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.tracking.index'))
            ->assertOk()
            ->assertSee($orderTracking->updated_at->format('d/m/Y'))
            ->assertDontSee($orderTracking->updated_at->format('H:i'));
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

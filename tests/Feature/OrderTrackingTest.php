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

    public function test_tracking_api_returns_401_when_no_bearer_token_is_provided(): void
    {
        config(['services.konvexa_tracking.token' => 'test-tracking-token']);

        $this->postJson('/api/integrations/order-tracking', [
            'order_number' => 'KVX2610112',
            'customer_name' => 'Kevin',
        ])->assertUnauthorized();

        $this->assertDatabaseCount('order_trackings', 0);
    }

    public function test_tracking_api_returns_401_when_the_bearer_token_is_invalid(): void
    {
        config(['services.konvexa_tracking.token' => 'test-tracking-token']);

        $this->withHeaders(['Authorization' => 'Bearer wrong-token'])
            ->postJson('/api/integrations/order-tracking', [
                'order_number' => 'KVX2610112',
                'customer_name' => 'Kevin',
            ])
            ->assertUnauthorized();

        $this->assertDatabaseCount('order_trackings', 0);
    }

    public function test_valid_tracking_api_request_creates_an_antrian_record(): void
    {
        config(['services.konvexa_tracking.token' => 'test-tracking-token']);

        $this->withHeaders(['Authorization' => 'Bearer test-tracking-token'])
            ->postJson('/api/integrations/order-tracking', [
                'order_number' => ' kvx2610112 ',
                'customer_name' => 'kEvIn',
                'status' => 'dapat_diambil',
            ])
            ->assertCreated()
            ->assertJsonPath('tracking.order_number', 'KVX2610112')
            ->assertJsonPath('tracking.customer_name', 'KEVIN')
            ->assertJsonPath('tracking.status', 'antrian');

        $this->assertDatabaseHas('order_trackings', [
            'order_number' => 'KVX2610112',
            'customer_name' => 'KEVIN',
            'status' => 'antrian',
        ]);
    }

    public function test_tracking_api_rejects_order_numbers_with_invalid_characters(): void
    {
        config(['services.konvexa_tracking.token' => 'test-tracking-token']);

        $this->withHeaders(['Authorization' => 'Bearer test-tracking-token'])
            ->postJson('/api/integrations/order-tracking', [
                'order_number' => 'KVX 2610112',
                'customer_name' => 'Kevin',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['order_number']);

        $this->assertDatabaseCount('order_trackings', 0);
    }

    public function test_repeated_tracking_sync_updates_the_name_without_overwriting_admin_status(): void
    {
        config(['services.konvexa_tracking.token' => 'test-tracking-token']);
        OrderTracking::query()->create([
            'order_number' => 'KVX2610112',
            'customer_name' => 'KEVIN',
            'status' => 'jahit',
        ]);

        $this->withHeaders(['Authorization' => 'Bearer test-tracking-token'])
            ->postJson('/api/integrations/order-tracking', [
                'order_number' => 'KVX2610112',
                'customer_name' => 'Rina',
                'status' => 'antrian',
            ])
            ->assertOk()
            ->assertJsonPath('tracking.customer_name', 'RINA')
            ->assertJsonPath('tracking.status', 'jahit');

        $this->assertDatabaseCount('order_trackings', 1);
        $this->assertDatabaseHas('order_trackings', [
            'order_number' => 'KVX2610112',
            'customer_name' => 'RINA',
            'status' => 'jahit',
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_admin_login_and_is_redirected_from_dashboard(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Selamat datang kembali');

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_log_in_and_view_dashboard(): void
    {
        $admin = $this->createAdmin();

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Ringkasan katalog website');
    }

    public function test_existing_non_admin_session_can_switch_to_admin(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('login'))
            ->assertOk()
            ->assertSee('Selamat datang kembali');

        $admin = $this->createAdmin();
        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_create_a_category_with_a_generated_slug(): void
    {
        $this->actingAs($this->createAdmin())
            ->post(route('admin.categories.store'), [
                'name' => 'Kaos Custom',
                'slug' => '',
                'order' => 1,
                'is_active' => 1,
            ])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Kaos Custom',
            'slug' => 'kaos-custom',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_open_category_list_and_forms(): void
    {
        $admin = $this->createAdmin();
        $category = Category::query()->create([
            'name' => 'Kaos',
            'slug' => 'kaos',
            'order' => 0,
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('Tracking Pesanan')
            ->assertSee('Kategori katalog');

        $this->get(route('admin.categories.create'))
            ->assertOk()
            ->assertSee('Tambah kategori');

        $this->get(route('admin.categories.edit', $category))
            ->assertOk()
            ->assertSee('Edit kategori');
    }

    public function test_admin_can_update_website_settings_and_homepage_uses_them(): void
    {
        $admin = $this->createAdmin();
        $settings = [
            'hero_badge' => 'Konveksi Tim Anda',
            'hero_title' => 'Judul uji',
            'hero_highlight' => 'Seragam khusus',
            'hero_description' => 'Deskripsi hero yang telah diperbarui.',
            'about_intro' => 'Tentang Konvexa yang telah diperbarui.',
            'about_commitment' => 'Komitmen Konvexa yang telah diperbarui.',
            'location_name' => 'Workshop Konvexa',
            'location_address' => 'Jl. Uji Coba No. 10, Bantul',
            'whatsapp_phone' => '+62 811-222-333',
            'contact_email' => 'halo@konvexa.test',
            'instagram_url' => 'https://www.instagram.com/testkonvexa',
            'instagram_handle' => '@testkonvexa',
            'tiktok_url' => 'https://www.tiktok.com/@testkonvexa',
            'tiktok_handle' => '@testkonvexa',
        ];

        $this->actingAs($admin)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('Pengaturan Website');

        $this->put(route('admin.settings.update'), $settings)
            ->assertRedirect(route('admin.settings.edit'));

        $this->assertDatabaseHas('settings', [
            'key' => 'location_address',
            'value' => 'Jl. Uji Coba No. 10, Bantul',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Seragam khusus')
            ->assertSee('Jl. Uji Coba No. 10, Bantul')
            ->assertSee('https://www.instagram.com/testkonvexa')
            ->assertSee('https://wa.me/62811222333');

        $category = Category::query()->create([
            'name' => 'Kaos',
            'slug' => 'kaos',
            'order' => 0,
            'is_active' => true,
        ]);
        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Kaos Uji',
            'slug' => 'kaos-uji',
            'is_active' => true,
        ]);

        $this->get(route('produk.index'))
            ->assertOk()
            ->assertSee('https://wa.me/62811222333?text=');
    }

    public function test_guest_cannot_open_website_settings(): void
    {
        $this->get(route('admin.settings.edit'))
            ->assertRedirect(route('login'));
    }

    public function test_category_in_use_by_products_cannot_be_deleted(): void
    {
        $admin = $this->createAdmin();
        $category = Category::query()->create([
            'name' => 'Kaos',
            'slug' => 'kaos',
            'order' => 0,
            'is_active' => true,
        ]);
        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Kaos Polos',
            'slug' => 'kaos-polos',
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    private function createAdmin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}

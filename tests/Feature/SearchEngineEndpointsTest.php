<?php

namespace Tests\Feature;

use Tests\TestCase;

class SearchEngineEndpointsTest extends TestCase
{
    public function test_robots_file_points_to_the_public_sitemap(): void
    {
        $this->get(route('robots'))
            ->assertOk()
            ->assertHeader('content-type', 'text/plain; charset=UTF-8')
            ->assertSee('Allow: /')
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: ' . route('sitemap'));
    }

    public function test_sitemap_contains_the_public_pages(): void
    {
        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('content-type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false)
            ->assertSee('<loc>' . route('home') . '</loc>', false)
            ->assertSee('<loc>' . route('produk.index') . '</loc>', false);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Cara Order')
            ->assertSee('Bagaimana cara melakukan pemesanan?')
            ->assertSee('Apakah bisa menggunakan desain sendiri?')
            ->assertSee('Apakah ada jumlah minimum pesanan?')
            ->assertSee('Berapa lama waktu produksinya?')
            ->assertSee('Apakah pesanan bisa dikirim ke luar kota?');
    }
}

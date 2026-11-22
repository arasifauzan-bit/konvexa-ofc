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
            ->assertDontSee('Kebijakan Privasi', false)
            ->assertDontSee('Syarat &amp; Ketentuan', false)
            ->assertSee('Bagaimana cara melakukan pemesanan?')
            ->assertSee('Apakah bisa menggunakan desain sendiri?')
            ->assertSee('Apakah ada jumlah minimum pesanan?')
            ->assertSee('Berapa lama waktu produksinya?')
            ->assertSee('Apakah pesanan bisa dikirim ke luar kota?');

        $content = $response->getContent();
        $contactPosition = strpos($content, '<section id="kontak"');
        $faqPosition = strpos($content, '<section id="faq"');

        $this->assertNotFalse($contactPosition);
        $this->assertNotFalse($faqPosition);
        $this->assertTrue($contactPosition < $faqPosition);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    /** @test */
    public function it_encodes_a_url_and_returns_shortened_url()
    {
        $response = $this->post('/encode', ['url' => 'https://example.com']);

        $response->assertStatus(200)
                 ->assertJsonStructure(['short_url']);

        $shortUrl = $response->json('short_url');
        $this->assertStringStartsWith('http://short.est/', $shortUrl);
        $this->assertEquals(6, strlen(basename($shortUrl)));
    }

    /** @test */
    public function it_decodes_a_shortened_url_to_original_url()
    {
        // First, encode a URL
        $response = $this->post('/encode', ['url' => 'https://example.com']);
        $shortUrl = $response->json('short_url');

        // Now, decode the shortened URL
        $response = $this->post('/decode', ['short_url' => $shortUrl]);

        $response->assertStatus(200)
                 ->assertJson(['original_url' => 'https://example.com']);
    }

    /** @test */
    public function it_returns_404_if_shortened_url_does_not_exist()
    {
        $response = $this->post('/decode', ['short_url' => 'http://short.est/invalid']);

        $response->assertStatus(404)
                 ->assertJson(['error' => 'URL not found']);
    }

    /** @test */
    public function it_fails_when_invalid_url_is_provided_for_encoding()
    {
        $response = $this->postJson('/encode', ['url' => 'invalid-url']);

        // Assert status and validation error for the 'url' field
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['url']);
    }

    /** @test */
    public function it_fails_when_invalid_url_is_provided_for_decoding()
    {
        $response = $this->postJson('/decode', ['short_url' => 'invalid-url']);

        // Assert status and validation error for the 'short_url' field
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['short_url']);
    }
}
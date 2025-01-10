<?php

<<<<<<< HEAD
it('returns a successful response', function () {
    $response = $this->get('/');
    
    $response->assertStatus(200);
    
});
=======
namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
>>>>>>> ec5a1961f254aa06738af4f8dd8cb6e6de053b77

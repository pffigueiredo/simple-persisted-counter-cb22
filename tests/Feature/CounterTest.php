<?php

namespace Tests\Feature;

use App\Models\Counter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_counter_page_can_be_accessed(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Counter')
            ->has('count')
        );
    }

    public function test_counter_starts_at_zero(): void
    {
        $response = $this->get('/');
        
        $response->assertInertia(fn ($page) => $page
            ->where('count', 0)
        );
    }

    public function test_counter_can_be_incremented(): void
    {
        $this->post('/', ['action' => 'increment']);
        
        $counter = Counter::first();
        $this->assertEquals(1, $counter->count);
    }

    public function test_counter_can_be_decremented(): void
    {
        // First create a counter with some value
        Counter::create(['count' => 5]);
        
        $this->post('/', ['action' => 'decrement']);
        
        $counter = Counter::first();
        $this->assertEquals(4, $counter->count);
    }

    public function test_counter_can_go_negative(): void
    {
        $this->post('/', ['action' => 'decrement']);
        
        $counter = Counter::first();
        $this->assertEquals(-1, $counter->count);
    }

    public function test_increment_returns_updated_count(): void
    {
        $response = $this->post('/', ['action' => 'increment']);
        
        $response->assertInertia(fn ($page) => $page
            ->component('Counter')
            ->where('count', 1)
        );
    }

    public function test_decrement_returns_updated_count(): void
    {
        Counter::create(['count' => 10]);
        
        $response = $this->post('/', ['action' => 'decrement']);
        
        $response->assertInertia(fn ($page) => $page
            ->component('Counter')
            ->where('count', 9)
        );
    }

    public function test_counter_persists_between_requests(): void
    {
        // Increment counter
        $this->post('/', ['action' => 'increment']);
        $this->post('/', ['action' => 'increment']);
        $this->post('/', ['action' => 'increment']);
        
        // Check the counter value persists
        $response = $this->get('/');
        $response->assertInertia(fn ($page) => $page
            ->where('count', 3)
        );
    }

    public function test_multiple_increments_and_decrements(): void
    {
        // Start with some increments
        $this->post('/', ['action' => 'increment']);
        $this->post('/', ['action' => 'increment']);
        $this->post('/', ['action' => 'increment']);
        $this->post('/', ['action' => 'increment']);
        $this->post('/', ['action' => 'increment']);
        
        // Then some decrements
        $this->post('/', ['action' => 'decrement']);
        $this->post('/', ['action' => 'decrement']);
        
        $counter = Counter::first();
        $this->assertEquals(3, $counter->count);
    }
}
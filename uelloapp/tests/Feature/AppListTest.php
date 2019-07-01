<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAppList()
    {
        $response = $this->get('/list');

        $response->assertStatus(200);
        $response->assertSee('Nome');
    }
}

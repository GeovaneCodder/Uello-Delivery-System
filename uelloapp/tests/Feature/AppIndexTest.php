<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAppIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Arquivos');
    }
}

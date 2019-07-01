<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImportCsvTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testImportCSV()
    {
        $file = UploadedFile::fake()->create('teste.csv');
      
        $response = $this->post('/upload', [
            'csv_file' => $file,
        ]);

        $response->assertStatus(201);
    }
}

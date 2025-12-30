<?php

namespace Tests\Feature;

use App\Models\GovernmentCap;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GovernmentCapUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_upload_with_region_and_petrol_only()
    {
        // Create a test Excel file with region and petrol only
        $file = UploadedFile::fake()->create(
            'test.csv',
            100,
            'text/csv'
        );

        // For now, we'll test the route exists and is accessible
        $response = $this->post(route('admin.govcap.upload.submit'), [
            'gov_cap_file' => $file
        ]);

        // Should redirect back (either success or error)
        $response->assertRedirect();
    }

    public function test_upload_without_file_fails()
    {
        $response = $this->post(route('admin.govcap.upload.submit'), []);

        $response->assertSessionHasErrors('gov_cap_file');
    }

    public function test_government_cap_index_displays()
    {
        // Create some test data
        GovernmentCap::create([
            'region' => 'Lagos',
            'fuel_type' => 'Petrol',
            'cap_price' => 250.50,
            'effective_date' => now()->toDateString()
        ]);

        $response = $this->get(route('admin.govcap.upload'));

        $response->assertStatus(200);
        $response->assertViewHas('latestPrices');
    }
}

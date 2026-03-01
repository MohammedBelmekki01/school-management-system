<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Feature tests for the API routes.
 *
 * Verifies that public API endpoints respond correctly,
 * return proper JSON structure, and handle errors.
 *
 * @author Mohammed Belmekki
 */
class ApiTest extends TestCase
{
    /**
     * Test that the API status endpoint returns success.
     *
     * @return void
     */
    public function testApiStatusEndpoint()
    {
        $response = $this->getJson('/api/v1/status');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'version' => '1.0.0',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'version',
                'timestamp',
            ]);
    }

    /**
     * Test that student lookup returns 404 for non-existent registration.
     *
     * @return void
     */
    public function testStudentLookupNotFound()
    {
        $response = $this->getJson('/api/v1/students/lookup/INVALID-REGI-001');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    /**
     * Test that authenticated-only routes return 401 for unauthenticated users.
     *
     * @return void
     */
    public function testAuthenticatedRoutesRequireAuth()
    {
        $response = $this->getJson('/api/v1/students');
        $response->assertStatus(401);

        $response = $this->getJson('/api/v1/classes');
        $response->assertStatus(401);

        $response = $this->getJson('/api/v1/user');
        $response->assertStatus(401);
    }

    /**
     * Test that exam results return 404 for non-existent data.
     *
     * @return void
     */
    public function testExamResultsNotFound()
    {
        $response = $this->getJson('/api/v1/results/99999/class/99999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UploadFileTest extends TestCase
{
    /**
     * Post request not auth user.
     */
    public function test_upload_file_by_not_auth_user(): void 
    {
        $response = $this->post('/uploadFile');
        $response->assertStatus(401);
    }

    /**
     * Post request with no file.
     */
    public function test_upload_file_no_file_errors_show(): void 
    {
        $response = $this->actingAs(User::find(1))->post('/uploadFile');
        $response->assertSessionHasErrors(['file' => 'The file field is required.']);
    }

    /**
     * Post request with wrong extension file.
     */
    public function test_upload_wrong_extension_file_errors_show(): void 
    {    
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs(User::find(1))->post('/uploadFile', [
            'file' => $file
        ]);

        $response->assertSessionHasErrors(['file' => 'The file field must be a file of type: xlsx.']);
    }
    
    /**
     * Post request with correct extension file.
     */
    public function test_upload_correct_file(): void 
    {
        $file = UploadedFile::fake()->create('avatar.xlsx', 50);   

        $response = $this->actingAs(User::find(1))->post('/uploadFile', [
            'file' => $file
        ]);

        $response->assertSessionDoesntHaveErrors();
    }

}

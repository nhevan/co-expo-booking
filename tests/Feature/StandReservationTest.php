<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StandReservationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * a company can reserve a stand
     */
    public function a_company_can_reserve_a_stand()
    {
        $stand = factory('App\Stand')->create();
        Storage::fake('avatars');
    	$company = factory('App\Company')->make([ 'logo_file' => UploadedFile::fake()->image('avatar.jpg') ])->toArray();

        $this->post("/api/stands/{$stand->id}/reserve", $company);
        $this->assertDatabaseHas('companies', ['name' => $company['name'], 'stand_id' => $stand->id]);
    }

    /**
     * @test
     * it validates company name while reserving a stand
     */
    public function it_validates_company_name_while_reserving_a_stand()
    {
        $stand = factory('App\Stand')->create();
        $company = factory('App\Company')->make(['name' => null])->toArray();

        $this->withExceptionHandling()->post("/api/stands/{$stand->id}/reserve", $company)
             ->assertSessionHasErrors('name');
    }

    /**
     * @test
     * it validates company logo while reserving a stand
     */
    public function it_validates_company_logo_while_reserving_a_stand()
    {
        $stand = factory('App\Stand')->create();
        $company = factory('App\Company')->make(['logo_file' => null])->toArray();

        $response = $this->withExceptionHandling()->post("/api/stands/{$stand->id}/reserve", $company);

        $response->assertSessionHasErrors('logo_file');
    }

    /**
     * @test
     * it successfully uploads the company logo
     */
    public function it_successfully_uploads_the_company_logo()
    {
        Storage::fake('local');
        $fake_file = UploadedFile::fake()->image('logo.jpg');
        $stand = factory('App\Stand')->create();

        $company = factory('App\Company')->make(['logo_file' => $fake_file])->toArray();

        $this->post("/api/stands/{$stand->id}/reserve", $company);

        Storage::disk('s3')->assertExists("tmp/logos/{$fake_file->hashName()}");
        $this->assertDatabaseHas('companies', ['logo' => "http://dy01r176shqrv.cloudfront.net/tmp/logos/{$fake_file->hashName()}"]);
    }

    /**
     * @test
     * it can upload single document
     */
    public function it_can_upload_single_document()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('document1.txt');
        $document = factory('App\Document')->make(['file' => $file])->toArray();

        $company = factory('App\Company')->create();

        $this->post("/api/companies/{$company->id}/upload-document", $document);

        Storage::disk('s3')->assertExists("tmp/documents/{$file->hashName()}");
        
        $this->assertDatabaseHas('documents', [ 'company_id' => $company->id, 'file' => "http://dy01r176shqrv.cloudfront.net/tmp/documents/{$file->hashName()}"]);
    }
}
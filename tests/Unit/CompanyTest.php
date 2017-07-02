<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * a company belongs to a stand
     */
    public function a_company_belongs_to_a_stand()
    {
        $stand = factory('App\Stand')->create();
        $company = factory('App\Company')->create(['stand_id' => $stand->id]);

        $this->assertInstanceOf(BelongsTo::class, $company->stand());
        $this->assertInstanceOf('App\Stand', $company->stand);
    }

    /**
     * @test
     * a company has many documents
     */
    public function a_company_has_many_documents()
    {
        $company = factory('App\Company')->create();

        $this->assertInstanceOf(HasMany::class, $company->documents());
    }

    /**
     * @test
     * it deletes all its marketing documents before deleting itself
     */
    public function it_deletes_all_its_marketing_documents_before_deleting_itself()
    {
        $company = factory('App\Company')->create();
        $document = factory('App\Document')->create(['company_id' => $company->id]);

        $this->assertDatabaseHas('documents', ['id' => $document->id, 'company_id' => $company->id]);
        
        $company->delete();
        $this->assertDatabaseMissing('documents', ['id' => $document->id, 'company_id' => $company->id]);
    }
}

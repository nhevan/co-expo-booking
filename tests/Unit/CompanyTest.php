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
}

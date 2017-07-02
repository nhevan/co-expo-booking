<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * it belongs to a company
     */
    public function it_belongs_to_a_company()
    {
        $document = factory('App\Document')->create();
        
        $this->assertInstanceOf(BelongsTo::class, $document->owner());
        $this->assertInstanceOf('App\Company', $document->owner);
    }
}

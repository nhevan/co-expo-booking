<?php

namespace Tests\Unit;

use App\Event;
use Tests\TestCase;
use App\Mail\EventEnded;
use App\Jobs\SendEventSummaryEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventSummaryEmailTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @test
	 * it can be dispatched when an event is passed
	 */
	public function it_can_be_dispatched_when_an_event_is_passed()
	{
		$this->expectsJobs(SendEventSummaryEmails::class);
		$event = factory('App\Event')->create();

		dispatch(new SendEventSummaryEmails($event));
	}

	/**
	 * @test
	 * it send emails to booked stand admin's email address
	 */
	public function it_send_emails_to_booked_stand_admins_email_address()
	{
		$event = factory('App\Event')->create();
		$stand = factory('App\Stand')->create(['event_id' => $event->id]);
		$stand2 = factory('App\Stand')->create(['event_id' => $event->id]);
		$company = factory('App\Company')->make()->toArray();

		$stand->assignCompany($company);

		Mail::fake();
		dispatch(new SendEventSummaryEmails($event));
		
		Mail::assertSent(EventEnded::class, function ($mail) use ($company) {
            return $mail->hasTo($company['admin_email']);
        });
	}
}
<?php

use App\Jobs\SendInquiryNotification;
use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Support\Facades\Queue;

it('submits inquiry and dispatches background notification job', function () {
    Queue::fake();

    $property = Property::factory()->create(['title' => 'Luxury Penthouse']);

    $response = $this->post(route('inquiries.store', $property->slug), [
        'name' => 'Devang Shah',
        'email' => 'devang@example.com',
        'phone' => '+91 98980 11223',
        'message' => 'I would like to schedule a weekend site visit for this property.',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    expect(Inquiry::where('email', 'devang@example.com')->count())->toBe(1);

    Queue::assertPushed(SendInquiryNotification::class, function ($job) {
        return $job->inquiry->email === 'devang@example.com';
    });
});

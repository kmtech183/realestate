<?php

namespace App\Jobs;

use App\Mail\PropertyInquiryReceived;
use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInquiryNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 15;

    /**
     * Create a new job instance.
     */
    public function __construct(public Inquiry $inquiry)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Load property agent relationship
        $this->inquiry->load(['property.agent']);

        $agentEmail = $this->inquiry->property->agent->email ?? 'admin@realestate.test';

        try {
            Mail::to($agentEmail)->send(new PropertyInquiryReceived($this->inquiry));
            Log::info("Inquiry notification email sent to agent: {$agentEmail} for Property #{$this->inquiry->property_id}");
        } catch (\Throwable $e) {
            Log::error("Failed to send inquiry email: " . $e->getMessage());
            throw $e; // Triggers retry backoff
        }
    }
}

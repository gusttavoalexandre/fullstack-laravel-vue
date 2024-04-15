<?php

namespace App\Jobs;

use App\Mail\ExpenseCreated;
use App\Models\ExpenseNotification;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendExpenseNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(readonly ExpenseNotification $notification)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->notification->user)->send(
                (new ExpenseCreated($this->notification->expense))
            );
            $this->notification->update(['sent_at' => now()]);
        } catch (Exception $e) {
            Log::error("Send e-mail notifcation {$this->notification->id} error: ".$e->getMessage());
        }
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    protected $id;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct($task, $id, $user = null)
    {
        //

        $this->task = $task;
        $this->id = $id;
        $this->user = $user; //use whether the notification is for assigned user or notif login user;
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        if(!$this->user) {
            Mail::send(['html' => 'email.create_task'], $this->task, function ($message) {
                $message->to(env('ADMIN_EMAIL'))->subject('Task Created', "Richard Quinto");
            });
    
        } else {
            Mail::send(['html' => 'email.create_task'], $this->task, function ($message) {
                $message->to($this->user->email)->subject('Task Assigned', $this->user->name);
            });
        }
    }
}

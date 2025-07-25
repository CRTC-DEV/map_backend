<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmailService;

class SendAutomaticEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-automatic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automatic emails based on configured schedule';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(EmailService $emailService)
    {
        $this->info('Starting automatic email sending process...');

        // Example: Send daily report
        $recipients = ['admin@example.com']; // Replace with actual recipients
        $subject = 'Daily System Report';
        $content = 'This is your daily system report.';
        
        $emailService->sendEmail($recipients[0], $subject, $content);

        // Example: Send weekly newsletter
        if (now()->isDayOfWeek(1)) { // Send on Monday
            $newsletterRecipients = ['user1@example.com', 'user2@example.com']; // Replace with actual recipients
            $newsletterSubject = 'Weekly Newsletter';
            $newsletterContent = 'Here is your weekly newsletter content.';
            
            $emailService->sendBulkEmail($newsletterRecipients, $newsletterSubject, $newsletterContent);
        }

        $this->info('Automatic email sending process completed.');
    }
} 
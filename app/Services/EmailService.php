<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send an email to a single recipient
     *
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $content Email content
     * @param array $data Additional data for the email template
     * @return bool
     */
    public function sendEmail($to, $subject, $content, $data = [])
    {
        try {
            Mail::raw($content, function ($message) use ($to, $subject) {
                $message->to($to)
                    ->subject($subject);
            });

            Log::info("Email sent successfully to: {$to}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$to}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send an email to multiple recipients
     *
     * @param array $recipients Array of recipient email addresses
     * @param string $subject Email subject
     * @param string $content Email content
     * @param array $data Additional data for the email template
     * @return bool
     */
    public function sendBulkEmail($recipients, $subject, $content, $data = [])
    {
        try {
            foreach ($recipients as $recipient) {
                $this->sendEmail($recipient, $subject, $content, $data);
            }

            Log::info("Bulk email sent successfully to " . count($recipients) . " recipients");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send bulk email: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send an HTML email
     *
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $view View template for the email
     * @param array $data Data to be passed to the view
     * @return bool
     */
    public function sendHtmlEmail($to, $subject, $view, $data = [])
    {
        try {
            Mail::send($view, $data, function ($message) use ($to, $subject) {
                $message->to($to)
                    ->subject($subject);
            });

            Log::info("HTML email sent successfully to: {$to}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send HTML email to {$to}: " . $e->getMessage());
            return false;
        }
    }
} 
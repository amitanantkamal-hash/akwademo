<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\InteractsWithTime;
use Modules\Wpbox\Models\Message;

class RateLimited
{
    use InteractsWithTime;

    public function handle($job, $next)
    {
        // Use messageId instead of message property
        $messageId = $job->messageId ?? null;
        
        if (!$messageId) {
            // Skip rate limiting if no message ID
            return $next($job);
        }

        // Load message with necessary relationships
        $message = Message::with('campaign.company')->find($messageId);
        
        if (!$message || !$message->campaign || !$message->campaign->company) {
            // Skip rate limiting if relationships missing
            return $next($job);
        }

        $company = $message->campaign->company;
        $key = 'whatsapp_rate:'.$company->id;
        
        Redis::throttle($key)
            ->allow($company->getRateLimit())
            ->every(60)
            ->then(
                function () use ($job, $next) {
                    $next($job);
                },
                function () use ($job) {
                    $job->release(10);
                }
            );
    }
}
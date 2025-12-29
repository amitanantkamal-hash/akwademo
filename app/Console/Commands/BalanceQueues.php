<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class BalanceQueues extends Command
{
    protected $signature = 'queues:balance';
    protected $description = 'Adjust worker processes based on queue load';

    public function handle()
    {
        $queues = [
            'high_priority' => ['processes' => 8, 'max' => 16],
            'medium_priority' => ['processes' => 4, 'max' => 8],
            'low_priority' => ['processes' => 2, 'max' => 4],
        ];

        foreach ($queues as $queue => $config) {
            $backlog = Redis::llen("queues:{$queue}");
            $current = $this->getCurrentProcesses($queue);
            
            if ($backlog > 1000 && $current < $config['max']) {
                $this->scaleWorkers($queue, min($current + 2, $config['max']));
            } elseif ($backlog < 100 && $current > $config['processes']) {
                $this->scaleWorkers($queue, max($current - 1, $config['processes']));
            }
        }
    }

    private function getCurrentProcesses($queue)
    {
        $output = shell_exec("supervisorctl status | grep '{$queue}' | grep RUNNING | wc -l");
        return (int) trim($output);
    }

    private function scaleWorkers($queue, $count)
    {
        exec("supervisorctl scale {$queue}={$count}");
        \Log::info("Scaled {$queue} workers to {$count}");
    }
}
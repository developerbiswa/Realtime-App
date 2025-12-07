<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Events\MessageReceived;

class ProcessMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $messageId;

    public function __construct($messageId)
    {
        $this->messageId = $messageId;
    }

    public function handle()
    {
        $message = Message::find($this->messageId);
        if (! $message) return;

        $clean = strip_tags($message->message);
        $clean = preg_replace('/(fuck|shit)/i', '****', $clean);

        $meta = [
            'processed_at' => now()->toDateTimeString(),
            'length' => mb_strlen($clean),
        ];

        $message->update([
            'message' => $clean,
            'meta' => $meta,
        ]);
        event(new MessageReceived($message));
    }
}

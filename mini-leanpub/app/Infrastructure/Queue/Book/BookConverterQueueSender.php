<?php

namespace MiniLeanpub\Infrastructure\Queue\Book;

use App\Jobs\Book\ConvertBookJob;
use MiniLeanpub\Domain\Shared\Queue\QueueInterface;

class BookConverterQueueSender implements QueueInterface
{
    public function __construct(private string $bookCode)
    {
    }

    public function sendToQueue(): bool
    {
        ConvertBookJob::dispatch($this->bookCode);

        return true;
    }
}

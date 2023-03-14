<?php

namespace MiniLeanpub\Infrastructure\Presenter\Book;

class BookApiMessagePresenter
{
    public function __construct(private string $message)
    {
    }

    public function getResponse()
    {
        return json_encode([
            'data' => [
                'message' => $this->message
            ]
        ]);
    }
}

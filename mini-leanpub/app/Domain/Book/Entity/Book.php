<?php

namespace MiniLeanpub\Domain\Book\Entity;

class Book
{
    public function __construct(
        private ?string $bookCode,
        private ?string $title,
        private ?string $description,
        private ?float $price,
        private ?string $bookPath,
        private ?string $mimeType
    ) {
    }

    public function validate()
    {
        if (!$this->bookCode) throw new \Exception("Invalid Entity: ID");

        if (!$this->title || !$this->description) throw new \Exception("Invalid Entity: Title or Description");

        if ($this->price < 0) throw new \Exception("Invalid Entity: Price");

        if (!$this->bookPath) throw new \Exception("Invalid Entity: Path Book");

        if ($this->mimeType != 'text/markdown') throw new \Exception("Invalid Entity: MimeType");
    }
}

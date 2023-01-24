<?php 

namespace MiniLeanpub\Application\UseCases\Book\CreateBook\DTO;

use MiniLeanpub\Application\UseCases\Shared\InteractorDTO;


class BookCreateOutputDTO extends InteractorDTO
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $price = null,
        public ?string $bookPath = null,
        public ?string $mimeType = null
    ){}
}
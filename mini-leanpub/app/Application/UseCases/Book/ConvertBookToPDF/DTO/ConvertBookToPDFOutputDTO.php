<?php

namespace MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\DTO;

use MiniLeanpub\Application\UseCases\Shared\InteractorDTO;

class ConvertBookToPDFOutputDTO extends InteractorDTO
{
    public function __construct(public string $bookCode)
    {
    }
}
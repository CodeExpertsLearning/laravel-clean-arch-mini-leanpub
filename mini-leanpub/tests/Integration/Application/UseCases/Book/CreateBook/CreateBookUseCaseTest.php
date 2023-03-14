<?php

namespace Tests\MiniLeanpub\Integration\Application\UseCases\CreateBook;

use MiniLeanpub\Infrastructure\Repository\Book\BookEloquentRepository;
use Tests\MiniLeanpub\LaravelTestCase;
use App\Models\Book;
use MiniLeanpub\Application\UseCases\Book\CreateBook\DTO\BookCreateInputDTO;
use MiniLeanpub\Application\UseCases\Book\CreateBook\CreateBookUseCase;

class CreateBookUseCaseTest extends LaravelTestCase
{
    public function testCreateARealBookViaUseCase()
    {
        $repository = new BookEloquentRepository(new Book());

        $input = new BookCreateInputDTO(
            '188e831e-0335-4bc9-9deb-c4d6dba6b258',
            'My Awesome Book',
            'My Awesome Book Desc',
            25.9,
            'book_path',
            'text/markdown'
        );

        $useCase = new CreateBookUseCase($input, $repository);
        $result = $useCase->handle();
    }
}

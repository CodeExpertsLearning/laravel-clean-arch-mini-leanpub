<?php

namespace MiniLeanpub\Application\UseCases\Book\CreateBook;

use PHPUnit\Framework\TestCase;
use MiniLeanpub\Domain\Book\Entity\Book;
use MiniLeanpub\Domain\Book\Repository\BookRepositoryInterface;
use MiniLeanpub\Application\UseCases\Book\CreateBook\DTO\{BookCreateInputDTO, BookCreateOutputDTO};

class CreateBookUseCase
{
    public function __construct(private BookCreateInputDTO $input, private BookRepositoryInterface $repository)
    {
    }

    public function handle(): BookCreateOutputDTO
    {
        $data = $this->input->getData();

        $entity = new Book(
            $data['bookCode'],
            $data['title'],
            $data['description'],
            $data['price'],
            $data['bookPath'],
            $data['mimeType']
        );

        $entity->validate();

        $result = $this->repository->create($data);

        return new BookCreateOutputDTO(
            bookCode: $result->book_code,
            title: $result->title,
            price: $result->price
        );
    }
}

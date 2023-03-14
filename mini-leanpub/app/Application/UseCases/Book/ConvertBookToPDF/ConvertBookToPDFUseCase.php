<?php

namespace MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF;

use MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\DTO\ConvertBookToPDFInputDTO;
use MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\DTO\ConvertBookToPDFOutputDTO;
use MiniLeanpub\Domain\Shared\Queue\QueueInterface;
use MiniLeanpub\Domain\Book\Repository\BookRepositoryInterface;

class ConvertBookToPDFUseCase
{
    public function __construct(
        private ConvertBookToPDFInputDTO $input,
        private BookRepositoryInterface $repository,
        private QueueInterface $queue
    ) {
    }

    public function handle(): ConvertBookToPDFOutputDTO
    {
        $book = $this->repository->find($this->input->getData()['bookCode']);

        $this->queue->sendToQueue($book->book_code);

        //storage/app/books/uuid-v4/chapters/*md
        // /book.pdf

        return new ConvertBookToPDFOutputDTO(bookCode: $book->book_code);
    }
}

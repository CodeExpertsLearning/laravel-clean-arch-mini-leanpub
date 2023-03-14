<?php

namespace Tests\MiniLeanpub\Integration\Application\UseCases\ConvertBookToPDF;

use Tests\MiniLeanpub\LaravelTestCase;
use App\Models\Book;
use MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\ConvertBookToPDFUseCase;
use MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\DTO\ConvertBookToPDFInputDTO;
use MiniLeanpub\Infrastructure\Queue\Book\BookConverterQueueSender;
use MiniLeanpub\Infrastructure\Repository\Book\BookEloquentRepository;

class ConvertBookToPDFUseCaseTest extends LaravelTestCase
{
    public function testConvertBookToPDFUseCaseWithDependencies()
    {
        $repository = new BookEloquentRepository(new Book());

        $bookCode = '188e831e-0335-4bc9-9deb-c4d6dba6b258';

        $repository->create([
            'bookCode' => $bookCode,
            'title' => 'Book Test',
            'description' => 'Book Description',
            'price' => 1.99,
            'bookPath' => storage_path('app/books/' . $bookCode . '/chapters')
        ]);

        $input = new ConvertBookToPDFInputDTO($bookCode);
        $queueSender = new BookConverterQueueSender($bookCode);


        $useCase = new ConvertBookToPDFUseCase($input, $repository, $queueSender);
        $result = $useCase->handle();

        $this->assertEquals($bookCode, $result->getData()['bookCode']);
    }
}

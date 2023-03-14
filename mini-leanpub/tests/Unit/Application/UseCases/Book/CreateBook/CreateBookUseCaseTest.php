<?php

namespace Test\MiniLeanpub\Unit\Application\UseCases\Book\CreateBook;

use PHPUnit\Framework\TestCase;
use App\Models\Book;
use MiniLeanpub\Application\UseCases\Book\CreateBook\CreateBookUseCase;
use MiniLeanpub\Application\UseCases\Book\CreateBook\DTO\{BookCreateInputDTO, BookCreateOutputDTO};
use MiniLeanpub\Infrastructure\Repository\Book\BookEloquentRepository;

class CreateBookUseCaseTest extends TestCase
{
    public function testShouldCreateANewBookViaUseCase()
    {
        $repository = $this->getRepositoryMock();

        $input = new BookCreateInputDTO(
            '00f727b3-84d7-41cd-883e-de1ee634b95a',
            'My Awesome Book',
            'My Awesome Book Desc',
            25.9,
            'book_path',
            'text/markdown'
        );

        $useCase = new CreateBookUseCase($input, $repository);
        $result = $useCase->handle();

        $this->assertInstanceOf(BookCreateOutputDTO::class, $result);

        $data = $result->getData();

        $this->assertEquals('00f727b3-84d7-41cd-883e-de1ee634b95a', $data['bookCode']);
        $this->assertEquals('My Awesome Book', $data['title']);
    }

    private function getRepositoryMock()
    {
        $return = new \stdClass();
        $return->bookCode = '00f727b3-84d7-41cd-883e-de1ee634b95a';
        $return->title = 'My Awesome Book';
        $return->description = 'My Awesome Book Desc';
        $return->price = 25.9;
        $return->book_path = 'book_path';

        $model = $this->createMock(Book::class); //Eloquent Book Model...

        $mock = $this->getMockBuilder(BookEloquentRepository::class)
            ->onlyMethods(['create'])
            ->setConstructorArgs([$model])
            ->getMock();

        $mock->expects($this->once())
            ->method('create')
            ->willReturn($return);

        return $mock;
    }
}

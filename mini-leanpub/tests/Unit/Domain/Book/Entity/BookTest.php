<?php

namespace Tests\MiniLeanpub\Unit\Domain\Book\Entity;

use MiniLeanpub\Domain\Book\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testIfBookValidationThrowsExceptionToAnInvalidId()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid Entity: ID');

        $book = new Book(null, 'Titulo Livro', 'Descrição Livro', 25.9, 'path_book', 'mime_type');

        $book->validate();
    }

    public function testIfBookValidationThrowsExceptionToAnInvalidTitleOrDescription()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid Entity: Title or Description');

        $book = new Book('UUID', null, 'Descrição Livro', 25.9, 'path_book', 'text/markdown');

        $book->validate();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid Entity: Title or Description');

        $book = new Book('UUID', 'Titulo Livro', null, 25.9, 'path_book', 'text/markdown');

        $book->validate();
    }

    public function testIfBookValidationThrowsExceptionToAnInvalidPrice()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid Entity: Price');

        $book = new Book('UUID', 'Titulo Livro', 'Descrição Livro', -10, 'path_book', 'text/markdown');

        $book->validate();
    }

    public function testIfBookValidationThrowsExceptionToAnInvalidBookPath()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid Entity: Path Book');

        $book = new Book('UUID', 'Titulo Livro', 'Descrição Livro', 25.9, null, 'text/markdown');

        $book->validate();
    }

    public function testIfBookValidationThrowsExceptionToAValidBookMimeType()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid Entity: MimeType');

        $book = new Book('UUID', 'Titulo Livro', 'Descrição Livro', 25.9, 'book_path', 'application/json');

        $book->validate();
    }
}
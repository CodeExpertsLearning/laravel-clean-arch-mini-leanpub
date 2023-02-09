<?php 
namespace MiniLeanpub\Infrastructure\Repository\Book;

use MiniLeanpub\Domain\Book\Repository\BookRepositoryInterface;
use App\Models\Book;

class BookEloquentRepository implements BookRepositoryInterface
{
    public function __construct(private Book $model){}

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function find($bookCode)
    {
        return $this->model->whereBookCode($bookCode)->first();
    }
}
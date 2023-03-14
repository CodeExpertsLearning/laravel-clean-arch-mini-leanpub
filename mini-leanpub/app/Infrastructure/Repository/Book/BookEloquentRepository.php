<?php

namespace MiniLeanpub\Infrastructure\Repository\Book;

use MiniLeanpub\Domain\Book\Repository\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Support\Str;

class BookEloquentRepository implements BookRepositoryInterface
{
    public function __construct(private Book $model)
    {
    }

    public function create($data)
    {
        $data['book_code'] = $data['bookCode'];
        $data['book_path'] = $data['bookPath'];
        $data['slug']      = Str::slug($data['title']);

        unset($data['bookCode'], $data['mimeType'], $data['bookPath']);

        return $this->model->create($data);
    }

    public function find($bookCode)
    {
        return $this->model->whereBookCode($bookCode)->first();
    }
}

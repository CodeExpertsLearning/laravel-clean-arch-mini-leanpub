<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use MiniLeanpub\Application\UseCases\Book\CreateBook\CreateBookUseCase;
use MiniLeanpub\Application\UseCases\Book\CreateBook\DTO\BookCreateInputDTO;
use MiniLeanpub\Infrastructure\Repository\Book\BookEloquentRepository;
use Illuminate\Support\Str;
use MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\ConvertBookToPDFUseCase;
use MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\DTO\ConvertBookToPDFInputDTO;
use MiniLeanpub\Infrastructure\Queue\Book\BookConverterQueueSender;

class BookApiController extends Controller
{
    public function store(Request $request)
    {
        $bookCode = '188e831e-0335-4bc9-9deb-c4d6dba6b258';

        $input = new BookCreateInputDTO(
            $bookCode,
            $request->title,
            $request->description,
            $request->price,
            storage_path('app/books/' . $bookCode . '/chapters'),
            'text/markdown'
        );

        $repository = new BookEloquentRepository(new Book());

        $useCase = new CreateBookUseCase($input, $repository);
        $result = ($useCase->handle())->getData();

        return response()->json([
            'data' => [
                'message' => "Book {$result['title']} has been created successfully"
            ]
        ]);
    }

    public function convertBook($bookCode)
    {
        $repository = new BookEloquentRepository(new Book());
        $input = new ConvertBookToPDFInputDTO($bookCode);
        $queueSender = new BookConverterQueueSender($bookCode);

        $useCase = new ConvertBookToPDFUseCase($input, $repository, $queueSender);
        $result = $useCase->handle();

        return response()->json([
            'data' => [
                'message' => "Book has been sended to conversion successfully"
            ]
        ]);
    }
}

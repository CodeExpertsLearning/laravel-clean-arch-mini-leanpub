<?php

namespace Tests\Feature\Controllers\API;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MiniLeanpub\Infrastructure\Repository\Book\BookEloquentRepository;
use Tests\TestCase;

class BookApiControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostToCreateANewBookViaApiEndpoint()
    {
        $data = [
            'title' => 'Meu Livro de PHP',
            'description' => 'Descrição de Meu Livro de PHP',
            'price' => 29.9
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(200);

        $this->assertEquals('Book Meu Livro de PHP has been created successfully', $response->json()['data']['message']);
    }

    public function testPostToMadeABookPDFViaApiEndpoint()
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

        $response = $this->postJson('/api/books/' . $bookCode . '/pdf');

        $response->assertStatus(200);

        $this->assertEquals('Book has been sended to conversion successfully', $response->json()['data']['message']);
    }
}

<?php

namespace Tests\Feature;

use App\Http\Controllers\BooksController;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;



class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Victor'
        ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'amazing book title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
         $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'old title',
            'author' => 'Vector'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id ,[
            'title' => "New Title",
            'author' => "New Vector"
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Vector', Book::first()->author);
    }
}

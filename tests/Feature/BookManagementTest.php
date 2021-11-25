<?php

namespace Tests\Feature;

use App\Http\Controllers\BooksController;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;



class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        // $response->assertOk();

        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());

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
        //  $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'old title',
            'author' => 'Vector'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path() ,[
            'title' => "New Title",
            'author' => "New Vector"
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Vector', Book::first()->author);

        $response->assertRedirect($book->fresh()->path());    
    }


    /** @test */
     public function a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();

         $this->post('/books', [
            'title' => 'old title',
            'author' => 'Vector'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }


    /** @test */
    public function a_new_author_is_automatically_added(){

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'old title',
            'author' => 'Vector'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());

    }
}

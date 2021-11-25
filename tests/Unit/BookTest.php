<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_id_is_required()
    {
        Book::create([
            'title  ' => 'Coll title',
            'author_id' => 1,
        ]);

        $this->assertCount(1, Book::all()); 
    }
}

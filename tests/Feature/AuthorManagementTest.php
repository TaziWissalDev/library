<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   public function an_author_can_be_created()
   {
       $this->withoutExceptionHandling();

       $this->post('/author', [
           'name' => 'Author Name',
           'dob' => '15-11-1988'
       ]);

        $author = Author::all();

       // $response->assertOk();

       $this->assertCount(1, $author);
       $this->assertInstanceOf(Carbon::class, $author->first()->dob);
       $this->assertEquals('1988-15-11', $author->first()->dob->format('Y-d-m'));

   }
}

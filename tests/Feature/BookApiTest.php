<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // use RefreshDatabase;

    public function test_external_book(){
        $response = $this->json("GET", "api/v1/external-books");
        $this->BookCollection($response);
    }

    public function test_index_book(){
        $response = $this->json("GET", "api/v1/books");
        $this->BookCollection($response);
    }


    public function test_create_book()
    {
        // $response = $this->get('/');

        $this->withoutExceptionHandling();

        $book = $this->create('Book');

        $response = $this->json('POST', 'api/v1/books/', [
            'name'=> $book->name,
            'isbn' => $book->isbn,
            'authors'=>$book->authors,
            'country'=>$book->country,
            'number_of_pages'=>$book->number_of_pages,
            'publishers' =>$book->publishers,
            'release_date'=>$book->release_date
        ]);
        \Log::info(1, [$response->getContent()]);
        $response->assertJsonStructure([
            'status', 'data'
        ])
        ->assertExactJson([
            'status_code'=>201,
            'status'=>'success',
            'data'=>[
                'name'=> $book->name,
                'isbn' => $book->isbn,
                'authors'=>$book->authors,
                'country'=>$book->country,
                'number_of_pages'=>$book->number_of_pages,
                'publishers' =>$book->publishers,
                'release_date'=>$book->release_date,
            ]
        ])->assertStatus(201);

    }


    public function test_update_book(){
        $this->withoutExceptionHandling();

        $book = $this->create('Book');

        $response = $this->json('PUT', 'api/v1/books/'.$book->id, [
            'name'=> $book->name,
            'isbn' => $book->isbn,
            'authors'=>$book->authors,
            'country'=>$book->country,
            'number_of_pages'=>$book->number_of_pages,
            'publishers' =>$book->publishers,
            'release_date'=>$book->release_date
        ]);
        \Log::info(1, [$response->getContent()]);

        $response->assertJsonStructure([
            'status', 'data'
        ])
        ->assertExactJson([
            'status_code'=>200,
            'status'=>'success',
            'message' => 'The book ' . $book->name . ' was updated successfully',
            'data'=>[
                'name'=> $book->name,
                'isbn' => $book->isbn,
                'authors'=>$book->authors,
                'country'=>$book->country,
                'number_of_pages'=>$book->number_of_pages,
                'publishers' =>$book->publishers,
                'release_date'=>$book->release_date,
            ]
        ])->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
        ]);
    }


    public function test_show_book(){
        $this->withoutExceptionHandling();

        $book = $this->create('Book');
        // dd($book->name);

        $response = $this->json("GET", "api/v1/books/$book->id");
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200)
            ->assertExactJson([
                'status_code' => 200,
                'status'=>'success',
                'data'=>[
                    'name'=> $book->name,
                    'isbn' => $book->isbn,
                    'authors'=>$book->authors,
                    'country'=>$book->country,
                    'number_of_pages'=>$book->number_of_pages,
                    'publishers' =>$book->publishers,
                    'release_date'=>$book->release_date
                ]
            ]);

    }

    public function test_404_if_book_not_found(){
        $response = $this->json('GET', 'api/v1/books/-1');
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(404);
    }


    public function test_delete_book(){
        $book = $this->create("Book");
        $response = $this->json('DELETE', "api/v1/books/$book->id");
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(204)
            ->assertSee(null);

        $this->assertDatabaseMissing('books', ['id'=>$book->id]);
    }


    public function test_edit_book(){
        $book = $this->create('Book');
        // dd($book->name);

        $response = $this->json("GET", "api/v1/books/$book->id/edit");
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200)
            ->assertExactJson([
                'name'=> $book->name,
                'isbn' => $book->isbn,
                'authors'=>$book->authors,
                'country'=>$book->country,
                'number_of_pages'=>$book->number_of_pages,
                'publishers' =>$book->publishers,
                'release_date'=>$book->release_date
            ]);
    }

}

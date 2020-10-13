<?php

namespace Tests;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function create(string $model, array $attributes = []){
        $book = factory("App\Models\\$model")->create($attributes);
        // dd($book);
        return new BookResource($book);
    }

    public function BookCollection($response){
        $book = $this->create("Book");

        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'status', 'data'=>[
                '*' => ['name','isbn', 'authors', 'country', 'number_of_pages','publishers','release_date']
            ]
        ]);
    }




}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // 'book'=>[
            'name'=>$this->name,
            'isbn'=> $this->isbn,
            'authors' => $this->authors, //To save an array of authors in the database
            'country' => $this->country,
            'number_of_pages' => $this->number_of_pages,
            'publishers' => $this->publishers,
            'release_date' => $this->release_date
            // ]
        ];
    }
}

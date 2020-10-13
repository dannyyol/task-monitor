<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = ['id', 'name','isbn','authors','country', 'number_of_pages', 'publishers','release_date'];
    protected $guarded = ['id'];

    // protected $casts = [
    //     'authors' => 'array',
    // ];

    public function getAuthorsAttribute($value)
    {
        $array = @unserialize($value); //Check if  the value is serialize or not
        if($array){
            return unserialize($value);
        }
    }
}

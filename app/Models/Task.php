<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ['id', 'task_name','description','start_date','end_date', 'status'];
    protected $guarded = ['id'];

}
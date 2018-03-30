<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];

    
    public function article()
    {
        return $this->hasOne(\App\Models\Article::class);

    }


    //
}

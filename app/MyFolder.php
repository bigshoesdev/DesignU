<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFolder extends Model
{
    protected $table = 'my_folder';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];


    public function getFiles()
    {
        return $this->hasMany( MyFile::class, 'folder_id');
    }
}

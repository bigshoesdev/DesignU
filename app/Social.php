<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'social_login';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
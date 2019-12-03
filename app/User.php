<?php namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Cviebrock\EloquentTaggable\Taggable;


class User extends EloquentUser
{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'users';

    /**
     * The attributes to be fillable from the model.
     *
     * A dirty hack to allow fields to be fillable by calling empty fillable array
     *
     * @var array
     */
    use Taggable;

    protected $fillable = [];
    protected $guarded = ['id'];

    protected $hidden = [
        'remember_token',
        'token'
    ];

    public function social()
    {
        return $this->hasMany('App\Social');
    }

    public function getSizes()
    {
        return $this->hasMany('App\MySizeSetting')->where('status', 1);
    }

    public function getFolders()
    {
        return $this->hasMany('App\MyFolder');
    }

    public function getBrand()
    {
        return Brand::where('user_id', $this->id)->first();
    }


    public function getFiles($folderID = 0)
    {
        return MyFile::where(['user_id' => $this->id, 'folder_id' => $folderID])->get();
    }

    public function getBalance()
    {
        $balance = Balance::where('user_id', $this->id)->first();

        if (empty($balance)) {
            $balance = new Balance;
            $balance->amount = 0;
            $balance->user_id = $this->id;
            $balance->save();
        }

        return $balance;
    }

    public function isFullyFilledForPay()
    {
        $result = array();
        $result['isFilled'] = true;
        $result['type'] = '';                       //setting       //address

        if ($this->email == "") {
            $result['isFilled'] = false;
            $result['type'] = "setting";
            return $result;
        }
        if ($this->name == "") {
            $result['isFilled'] = false;
            $result['type'] = "setting";
            return $result;
        }
        if ($this->hp == "") {
            $result['isFilled'] = false;
            $result['type'] = "setting";
            return $result;
        }
        if ($this->msn == "") {
            $result['isFilled'] = false;
            $result['type'] = "setting";
            return $result;
        }

        $userAddress = UserAddress::getSelectedAddress($this);

        if ($userAddress == null) {
            $result['isFilled'] = false;
            $result['type'] = "address";
            return $result;
        }

        return $result;
    }
}

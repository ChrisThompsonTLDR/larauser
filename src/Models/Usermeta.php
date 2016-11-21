<?php

namespace Christhompsontldr\Larauser\Models;

use Illuminate\Database\Eloquent\Model;

use Image;
use Storage;

class UserMeta extends Model
{

    public function __construct()
    {
        $this->table = config('larauser.table');

        parent::__construct();
    }

    //  RELATIONSHIPS

    public function user() {
        return $this->belongsTo(config('larauser.user_model'));
    }

    //  ACCESSORS

/*    public function getAvatarAttribute($field)
    {
        if ($this->attributes['avatar']) {
            return config('larauser.avatar.path') . '/' . $this->attributes['username'] . '.png';
        }
    }

    //  MUTATORS

    public function setAvatarAttribute($value)
    {
        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            Storage::disk('larauser')->delete($this->image);

            // set null in the database column
            $this->attributes['avatar'] = false;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            $this->attributes['avatar'] = false;
            if (Storage::disk('larauser')->put($this->attributes['username'] . '.png', Image::make($value)->stream('png'))) {
                $this->attributes['avatar'] = true;
            }
        }
    }*/
}
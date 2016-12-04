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

    public function getAvatarAttribute($field)
    {
        if ($this->attributes['avatar']) {
            return config('larauser.avatar.path') . $this->attributes['avatar'] . '-150x150.png';
        }
    }


    //  MUTATORS

    public function setAvatarAttribute($value)
    {
        $disk = config('larauser.avatar.filesystem.driver');
        $destination_path = config('larauser.avatar.filesystem.root');

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            Storage::disk($disk)->delete($this->image);

            // set null in the database column
            $this->attributes['avatar'] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // 0. Make the image
            $image = Image::make($value);

            // 1. Generate a filename.
            $filename = md5($value.time());
            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path . $filename . '.png', $image->stream());

            foreach (config('larauser.avatar.sizes') as $key => $val) {
                $tmp = $image;

                $tmp->{$val[0]}($val[1], $val[2]);

                Storage::disk($disk)->put($destination_path . $filename . '-' . $key . '.png', $tmp->stream());
            }

            // 3. Save the path to the database
            $this->attributes['avatar'] = $filename;
        }
    }
}
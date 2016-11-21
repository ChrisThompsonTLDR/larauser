<?php
namespace Christhompsontldr\Larauser\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Larauser
{
    //  RELATIONSHIPS

    public function usermeta()
    {
        return $this->hasOne('\Christhompsontldr\Larauser\Models\Usermeta');
    }
}
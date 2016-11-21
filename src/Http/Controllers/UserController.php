<?php

namespace Christhompsontldr\Larauser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Artisan;

use Christhompsontldr\Larauser\Models\Usermeta;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'usermeta.username' => 'required|max:40|unique:usermeta',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $model = config('auth.providers.users.model');
        $user           = new $model;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //  save meta
        $meta = Usermeta::firstOrNew(['user_id' => Auth::id()]);
        $meta->user_id = $user->id;
        foreach ($request->input(['usermeta']) as $key => $val) {
            $meta->{$key} = $val;
        }
        $meta->save();

        if (isset($data['admin'])) {
            $role = \App\Role::whereName('admin')->first();
            $user->attachRole($role);

            /**
             * @todo Entrust is a hooker and won't flush this stuff
             */
            Artisan::call('cache:clear');
        }

        Auth::login($user);

        return redirect()->to(config('larauser.routes.login_redirect'));
    }

    public function edit()
    {
        return view('larauser::user.edit');
    }

    public function update(Request $request)
    {
        $inputs = $request->input(['usermeta']);

        $meta = Usermeta::firstOrNew(['user_id' => Auth::id()]);

        $meta->user_id = Auth::id();

        foreach ($inputs as $key => $val) {
            $meta->{$key} = $val;
        }

        $meta->save();

        dd('saved');
    }
}

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
            'usermeta.username' => ['max:40', 'required', Rule::unique('usermeta')->ignore(Auth::id(), 'user_id')],
            'email' => ['max:255', 'email', 'required', Rule::unique('users')->ignore(Auth::id())],
            'password' => 'required|min:6|confirmed',
        ]);

        $model          = config('auth.providers.users.model');
        $user           = new $model;
        $user->email    = $request->input('email');

        if (!empty($request->input('password'))) {
            Auth::user()->password = bcrypt($request->input('password'));
        }

        $user->save();

        //  save meta
        $meta = Usermeta::firstOrNew(['user_id' => Auth::id()]);
        $meta->user_id = $user->id;
        foreach ($request->input(['usermeta']) as $key => $val) {
            $meta->{$key} = $val;
        }
        $meta->save();

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

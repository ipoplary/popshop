<?php

namespace App\Http\Controllers\Admin;

use Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/home';

    protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin()
    {
        if(Auth::admin()->user())
            return redirect('/');

        return view('admin.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $remember = ($request->input('remember') === '1')? true: false;

        if( ! Auth::admin()->attempt(['name'=>$name, 'password'=>$password], $remember) ) {
            $data = [
                'err' => -1,
                'msg' => '账号或密码错误！请重新登录！'
            ];
            return view('admin.login', $data);
        }

        return redirect('/');

    }

    public function getTest()
    {
        dd(Auth::admin()->getRecaller());
    }

    public function getRegister()
    {
        // if(Auth::admin()->user())
        //     return redirect('/');

        return view('admin.register');
    }

    public function postRegister()
    {
        var_dump(234);
    }
}

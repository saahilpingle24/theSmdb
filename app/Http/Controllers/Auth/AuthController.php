<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Cloudder;
use Event;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'username' => 'required|min:3|max:10|unique:users',
            'password' => 'required|min:6|confirmed',
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
        
        if($this->validator($data)) { 
            if(!isset($data['profile_picture'])) {
                $data['profile_picture'] = 'http://res.cloudinary.com/dctgevlms/image/upload/c_scale,w_128/v1459637777/5894232_awtuue.png';
            } else {  
                if(Input::file('profile_picture')->isValid()) {
                    Cloudder::upload($data['profile_picture'], $data['username'], array("width"=>"256", "height"=>"256", "crop"=>"scale"));                    
                    $results = Cloudder::getResult();                       
                    $data['profile_picture'] = $results['url'];
                }
            }
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'profile_picture' => $data['profile_picture'],
                'registered_on' => date('Y-m-d H:i:s'),
                'password' => bcrypt($data['password']),
            ]);
        }        
        
    }
}

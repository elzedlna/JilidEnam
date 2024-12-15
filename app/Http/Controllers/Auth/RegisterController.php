<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/welcust';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'custname' => ['required', 'string', 'max:255'],
            'custemail' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'custpassword' => ['required', 'string', 'min:8', 'confirmed'],
            'custphone' => ['required', 'string', 'min:10', 'max:15'],
            'custaddress' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'custname' => $data['custname'],
            'custemail' => $data['custemail'],
            'custpassword' => Hash::make($data['custpassword']),
            'custphone' => $data['custphone'],
            'custaddress' => $data['custaddress'],
        ]);
    }
}

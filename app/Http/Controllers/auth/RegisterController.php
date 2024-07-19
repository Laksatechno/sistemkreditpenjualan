<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama hanya boleh diisi maksimal 255 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.string' => 'Email hanya kombinasi dan huruf, angka, dan simbol',
            'email.email' => 'Format penulisan email salah',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.string' => 'Password berupa kombinasi huruf, angka, dan simbol',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai dengan password',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'password_confirmation.string' => 'Konfirmasi password berupa kombinasi huruf, angka, dan simbol',
            'password_confirmation.min' => 'Konfirmasi password harus memiliki minimal 8 karakter',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->create($request->all());

        // Redirect to login page after successful registration
        return redirect($this->redirectTo)->with('success', 'Registration successful. Please log in.');
    }
}

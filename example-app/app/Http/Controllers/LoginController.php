<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private $newUser ;
    public function __construct()
    {
        $this->newUser = new LoginModel();
    }

    public function LoginUsersGet()
    {
        return view('login');
    }

    public function loginUsersPost(Request $request){
        $Users =$this->newUser;
        $name = $request['name'];
        $password = $request['password'];
        $where = $Users::all()->where('name',$name);
        $findValues = $Users::where('name',$name)->count();

        if($findValues === 0){
            return response('usuario não encontrado',401)
            ->header('Content-Type', 'text/plain');;
        }
        $hashedPassword =$where[1]->password;
        if(!Hash::check($password,$hashedPassword)){
            return response('dados invalidos',401)
            ->header('Content-Type', 'text/plain');;
        }

       return redirect('/');

    }
    public function RegisterGet()
    {
        return view('register');
    }
    public function Register(Request $request)
    {
        $Users = $this->newUser;
        $name = $request['name'];
        $password = $request['password'];

        $findValues = $Users::where('name',$name)->count();

        if($findValues >0){
            return response('usuario já cadastrado',401)
            ->header('Content-Type', 'text/plain');;
        }
        $Users::insert([
            "name"=>$name,
            "password"=>Hash::make($password),
        ]);

        return view('register');
    }

}

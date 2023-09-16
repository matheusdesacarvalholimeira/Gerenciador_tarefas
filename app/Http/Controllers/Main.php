<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Main extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Olá Laravel 10!',
            'description' => 'Aprendendo Laravel 10'
        ];

        return view('main', $data);
    }

    public function users()
    {
        // get users with raw sql
        // $users = DB::select('SELECT * FROM users');
        // dd($users);
        
        // with query builder
        // $users = DB::table('users')->get();
        // dd($users);

        // with query builder - return in array
        // $users = DB::table('users')->get()->toArray();
        // dd($users);

        // echo '<pre>';
        // print_r($users);

        // using Eloquent ORM - Using Model
        $model = new UserModel();
        $users = $model->all();

        foreach($users as $user){
            echo $user->username . '<br>';
        }
    }

    public function view()
    {
        $data = [
            'title' => 'Título da página'
        ];

        return view('home', $data);
    }
}

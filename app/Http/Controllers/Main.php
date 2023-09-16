<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}

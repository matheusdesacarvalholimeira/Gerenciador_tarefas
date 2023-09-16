<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class Main extends Controller
{
    // ======================================================
    // main page
    // ======================================================
    public function index()
    {
        $data = [
            'title' => 'Gestor de Tarefas',
            'tasks' => $this->_get_tasks()
        ];

        return view('main', $data);
    }

    // ======================================================
    // login
    // ======================================================
    public function login()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('login_frm', $data);
    }

    public function login_submit(Request $request)
    {
        // form validation
        $request->validate([
            'text_username' => 'required|min:3',
            'text_password' => 'required|min:3',
        ], [
            'text_username.required' => 'O campo é de preenchimento obrigatório.',
            'text_username.min' => 'O campo deve ter no mínimo 3 caracteres.',
            'text_password.required' => 'O campo é de preenchimento obrigatório.',
            'text_password.min' => 'O campo deve ter no mínimo 3 caracteres.',
        ]);

        // get form data
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if user exists
        $model = new UserModel();
        $user = $model->where('username', '=', $username)
                      ->whereNull('deleted_at')
                      ->first();
        if($user){

            // cherck if password is correct
            if(password_verify($password, $user->password)){

                $session_data = [
                    'id' => $user->id,
                    'username' => $user->username
                ];
                session()->put($session_data);
                return redirect()->route('index');
            }
        }

        // invalid login
        return redirect()
            ->route('login')
            ->withInput()
            ->with('login_error', 'Login inválido');
    }

    // ======================================================
    // logout
    // ======================================================
    public function logout()
    {
        session()->forget('username');
        return redirect()->route('login');
    }

    // ======================================================
    // private methods
    // ======================================================
    private function _get_tasks()
    {
        $model = new TaskModel();
        return $model->where('id_user', '=', session()->get('id'))
                     ->whereNull('deleted_at')
                     ->get();
    }
}

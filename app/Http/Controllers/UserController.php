<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user');
    }

    public function show($id)
    {
        return "The user with ID: " . $id;
    }

    public function getUsernameEmail($username, $email)
    {
        return 'The username is :' . $username . 'and email is:' . $email;
    }
}

<?php

namespace App\Controllers;

class ErrorController extends BaseController
{
    public function index(): string
    {
        return view('error');
    }
}

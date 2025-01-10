<?php

namespace App\Http\Controllers;

   

class ExampleController extends Controller
{
    public function home()
    {
        $animals = ['cat', 'dog', 'mouse'];
        return view('home',['animals' => $animals]);

        // return 'Home page';
    }
    public function about()
    {
        return view('about');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function create() {

        return view('authors.create');
    }

    public function store() {

        $data = request()->validate([
            'name' => 'required',
            'dob' => 'required',
        ]);
        $author = Author::create($data);

        // return redirect($book->path());
    }
}

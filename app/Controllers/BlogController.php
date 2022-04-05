<?php

namespace App\Controllers;


class BlogController extends controllers {

    public function index()
    {
        return $this->view('blog.index');
    }

    public function show(int $id)
    {
        return $this->view('blog.index', compact('id'));
    }
}













?>
<?php

namespace App\Controllers;


class BlogController {

    public function index()
    {
        echo 'je suis la homepage';
    }

    public function show(int $id)
    {
        echo 'Je suis le post' . $id;
    }
}













?>
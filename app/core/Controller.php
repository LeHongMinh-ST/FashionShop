<?php

class Controller
{
    public function controller($controllers)
    {
        require_once "app/controllers/" . $controllers . ".php";
        return new $controllers;
    }

    public function views($views, $data = [])
    {
        extract($data);
        require_once "./app/views/" . $views . ".php";
    }

    public function redirect($path)
    {
        header("location: $path");
    }
}
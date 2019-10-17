<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers;

use Softworx\RocXolid\UserManagement\Components\Dashboard\Main as MainDashboard;

class Controller extends AbstractController
{
    public function index()
    {
        return (new MainDashboard($this))->render();
    }
}
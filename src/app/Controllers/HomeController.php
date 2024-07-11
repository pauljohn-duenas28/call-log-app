<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\CallHeader;
use App\View;

class HomeController
{
  public function index(): View
  {

    $callHeader = new CallHeader();
    $data =  $callHeader->getAll();

    return View::make('index', ['data' => $data]);
  }
}
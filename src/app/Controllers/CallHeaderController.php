<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Models\CallHeader;
use App\View;

class CallHeaderController {

  public function create()
  {
    $it_person = $_POST['it_person'];
    $user_name = $_POST['user_name'];
    $subject = $_POST['subject'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    $it_person = htmlspecialchars(trim($it_person));
    $user_name = htmlspecialchars(trim($user_name));
    $subject = htmlspecialchars(trim($subject));
    $details = htmlspecialchars(trim($details));
    $status = htmlspecialchars(trim($status));

    $callHeader = new CallHeader();

    $id = $callHeader->create($it_person, $user_name, $subject, $details, $status);

    if($id){
      header("Location: /");
    }
  }

  public function delete()
  {
    $call_id = $_POST['caller_id'];

    $callHeader = new CallHeader();

    $id = $callHeader->delete((int)$call_id);

    if($id){
      header("Location: /");
    }
  }
  
  public function search()
  {
    $searchQuery = htmlspecialchars($_GET['search_query']);

    $callHeader = new CallHeader();

    $data = $callHeader->search($searchQuery);

    return View::make('index', ['data' => $data]);
  }

}
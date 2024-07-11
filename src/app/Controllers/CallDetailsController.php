<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\CallDetail;
use App\Models\CallHeader;
use App\View;
use DateTime;

class CallDetailsController {

  public function create(){
    // Retrieve form data
    $call_id = $_POST['caller_id'];
    $date_time = $_POST['date_time'];
    $details = $_POST['details'];
    $hours = $_POST['hours'];
    $minutes = $_POST['minutes'];

    $call_id = htmlspecialchars(trim($call_id));
    $date_time = htmlspecialchars(trim($date_time));
    $details = htmlspecialchars(trim($details));
    $hours = htmlspecialchars(trim($hours));
    $minutes = htmlspecialchars(trim($minutes));

    $date_time = DateTime::createFromFormat('m/d/Y h:i A', $date_time);
    $formattedDatetime = $date_time->format('Y-m-d H:i:s');
    
    $callDetail = new CallDetail();

    $id = $callDetail->create($call_id, $formattedDatetime, $details, $hours, $minutes);

    //update the hours and minutes
    $callHeader = new CallHeader();
    $getCurrentHourMinute = $callHeader->getHourMinute((int)$call_id);

    $totalHour = $getCurrentHourMinute['total_hours'] + $hours;
    $totalMinute = $getCurrentHourMinute['total_minutes'] + $minutes;
    $updateHourMinute = $callHeader->updateHourMinute((int)$totalHour, (int)$totalMinute, (int)$call_id );

    if($id){
      header("Location: /");
    }
  }

  public function delete()
  {
    $call_id = $_POST['caller_id'];
    $call_detail_id = $_POST['caller_details_id'];

    $callDetail = new CallDetail();
    $callHeader = new CallHeader();

    //get hours and minutes then update the total hours and minutes
    $getHourMinute = $callDetail->getHourMinute((int)$call_detail_id);
    $getCurrentHourMinute = $callHeader->getHourMinute((int)$call_id);
    $totalHour = $getCurrentHourMinute['total_hours'] - $getHourMinute['hours'];
    $totalMinute = $getCurrentHourMinute['total_minutes'] - $getHourMinute['minutes'];
    $callHeader->updateHourMinute((int)$totalHour, (int)$totalMinute, (int)$call_id );

    $id = $callDetail->delete((int)$call_detail_id);

    if($id){
      header("Location: /");
    }
  }

}
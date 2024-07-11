<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use PDO;

class CallHeader extends Model
{
  /**
   * Create new call header
   * @param string $it_person
   * @param string $user_name
   * @param string $subject
   * @param string $details
   * @param string $status
   * @return int
   */
  public function create(string $it_person, string $user_name, string $subject, string $details, string $status): int
  {
    $query = $this->db->prepare(
      '
        INSERT INTO call_headers (date, it_person, user_name, subject, details, status)
        VALUES (NOW(), ?, ?, ?, ?, ?)
      '
    );

    $query->execute([$it_person, $user_name, $subject , $details, $status]);

    return (int) $this->db->lastInsertId();
  }
  
  /**
   * Summary of getAll
   * @return array
   */
  public function getAll(): array
  {
    $query1 = $this->db->prepare(
      '
        SELECT call_id, date, it_person, user_name, subject, details, 
        total_hours, total_minutes, status
        FROM call_headers
      '
    );

    $query1->execute();

    $callHeader = $query1->fetchAll();

    $newData = [];
    foreach($callHeader as $header) {
      $call_id = $header['call_id'];

      $query2 = $this->db->prepare(
        '
        SELECT id,call_id,date,details,hours,minutes 
        FROM call_details
        WHERE call_id = "'.$call_id.'"
        '
      );

      $query2->execute();

      $callDetails = $query2->fetchAll();

      $header['caller_details'] = $callDetails;

      $newData[] = $header;
    }

    return $newData;
  }

  /**
   * Summary of search
   * @param string $search
   * @return array
   */
  public function search(string $search): array
  {
    $query1 = $this->db->prepare(
      '
        SELECT call_id, date, it_person, user_name, subject, details, 
        total_hours, total_minutes, status
        FROM call_headers
        WHERE call_id LIKE :searchQuery1
        OR user_name LIKE :searchQuery2
        OR date LIKE :searchQuery3
      '
    );
    $searchQuery = "%" . $search . "%";
    $query1->bindValue(":searchQuery1", $searchQuery, PDO::PARAM_STR);
    $query1->bindValue(":searchQuery2", $searchQuery, PDO::PARAM_STR);
    $query1->bindValue(":searchQuery3", $searchQuery, PDO::PARAM_STR);
    
    $query1->execute();

    $callHeader = $query1->fetchAll(PDO::FETCH_ASSOC);

    $newData = [];
    foreach($callHeader as $header) {
      $call_id = $header['call_id'];

      $query2 = $this->db->prepare(
        '
        SELECT id,call_id,date,details,hours,minutes 
        FROM call_details
        WHERE call_id = "'.$call_id.'"
        '
      );

      $query2->execute();

      $callDetails = $query2->fetchAll();
      

      $header['caller_details'] = $callDetails;

      $newData[] = $header;
    }

    return $newData;
  }

  /**
   * Summary of getHourMinute
   * @param int $callId
   * @return array
   */
  public function getHourMinute(int $callId): array
  {
    $query = $this->db->prepare(
      '
        SELECT total_hours, total_minutes
        FROM call_headers
        WHERE call_id = ?
      '
    );

    $query->execute([$callId]);

    return $query->fetch();
  }

  /**
   * Summary of updateHourMinute
   * @param int $totalHour
   * @param int $totalMinute
   * @param int $callId
   * @return int
   */
  public function updateHourMinute(int $totalHour, int $totalMinute, int $callId): int
  {
    $query = $this->db->prepare(
      '
        UPDATE call_headers
        SET total_hours = ?,
        total_minutes = ?
        WHERE call_id = ?
      '
    );

    $query->execute([$totalHour, $totalMinute, $callId]);

    return $query->rowCount();
  }

  /**
   * Summary of delete
   * @param int $callid
   * @return int
   */
  public function delete(int $callid): int
  {
    $query = $this->db->prepare(
      '
        DELETE FROM call_headers
        WHERE call_id = ?
      '
    );

    $query->execute([$callid]);

    return $query->rowCount();
  }
}
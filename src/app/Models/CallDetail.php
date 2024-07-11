<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use PDO;

class CallDetail extends Model
{
  /**
   * Summary of create
   * @param string $call_id
   * @param string $date_time
   * @param string $details
   * @param string $hours
   * @param string $minutes
   * @return int
   */
  public function create(string $call_id, string $date_time, string $details, string $hours, string $minutes): int
  {
    $query = $this->db->prepare(
      '
        INSERT INTO call_details (call_id, date, details, hours, minutes)
        VALUES (?, ?, ?, ?, ?)
      '
    );

    $query->execute([$call_id, $date_time, $details , $hours, $minutes]);

    return (int) $this->db->lastInsertId();
  }

  /**
   * Summary of getHourMinute
   * @param int $call_detail_id
   * @return object
   */
  public function getHourMinute(int $call_detail_id): array
  {
    $query = $this->db->prepare(
      '
        SELECT hours, minutes
        FROM call_details
        WHERE id = ?
      '
    );

    $query->execute([$call_detail_id]);

    return $query->fetch();
  }

  /**
   * Summary of delete
   * @param int $call_detail_id
   * @return int
   */
  public function delete(int $call_detail_id): int
  {
    $query = $this->db->prepare(
      '
        DELETE FROM call_details
        WHERE id = ?
      '
    );

    $query->execute([$call_detail_id]);

    return $query->rowCount();
  }
}
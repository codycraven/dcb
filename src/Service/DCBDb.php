<?php

namespace Drupal\dcb\Service;

use Drupal\Core\Database\Connection;

/**
 * Class DCBDb.
 *
 * @package Drupal\dynoblock\Service
 */
class DCBDb {

  /**
   * @var string
   */
  static $db_table = 'dcb';

  /**
   * @var Connection
   */
  private $database;

  /**
   * DCBDb constructor.
   *
   * @param Connection $database
   */
  public function __construct( Connection $database ) {
    $this->database = $database;
  }

  /**
   * @param $record
   * @return \Drupal\Core\Database\StatementInterface|int|null
   */
  public function save($record) {
    return $this->database->merge(self::$db_table)
      ->key(
        array(
          'rid' => $record['rid'],
          'bid' => $record['bid'],
        )
      )
      ->fields(
        array(
          'data' => $record['data'],
          'weight' => $record['weight'],
          'conditions' => $record['conditions'],
        )
      )
      ->execute();
  }

  /**
   * @param $record
   * @return \Drupal\Core\Database\StatementInterface|int|null
   */
  public function update($record) {
    return  $this->database->update(self::$db_table)
      ->condition('rid', $record['rid'])
      ->condition('bid', $record['bid'])
      ->fields(array('data' => $record['data'],))
      ->execute();
  }

  /**
   * @param $rid
   * @return array
   */
  public function getBlocks($rid) {
   $query = $this->database->select(self::$db_table, 'd');
   $query->fields('d', array('rid', 'bid', 'data'))
     ->orderBy('bid', 'ASC')
     ->condition('rid', $rid, '=');

   $result = $query->execute();

   $results = array();
   while ($record = $result->fetchAssoc()) {
     $record['data'] = unserialize($record['data']);
     $results[] = $record;
   }

   return $results;
  }

  /**
   * @param $rid
   * @param $bid
   * @return bool|mixed
   */
  public function getBlock($rid, $bid) {
    $query = $this->database->select(self::$db_table, 'd');
    $query->fields('d', array('rid', 'bid', 'data'))
      ->orderBy('bid', 'ASC')
      ->condition('rid', $rid, '=')
      ->condition('bid', $bid, '=');
    $result = $query->execute()->fetchAssoc();
    if (!empty($result)) {
      return unserialize($result['data']);
    }
    else {
      return FALSE;
    }
  }

  /**
   * @param $rid
   * @param $bid
   * @return int
   */
  public function remove($rid, $bid) {
    $delete = $this->database->delete(self::$db_table)
      ->condition('rid', $rid)
      ->condition('bid', $bid)
      ->execute();
    return $delete;
  }

}
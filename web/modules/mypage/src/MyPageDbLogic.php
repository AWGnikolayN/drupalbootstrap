<?php

namespace Drupal\mypage;

use Drupal\Core\Database\Connection;

/**
 * Defines a storage handler class that handles the node grants system.
 *
 * This is used to build node query access.
 *
 * @ingroup mypage
 */
class MyPageDbLogic {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a MyPageDbLogic object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  // Переменная $database придетела к нам из аргумента сервиса.
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Get all records from table mypage.
   */
  public function getAll() {
    return $this->getById();
  }

  /**
   * Get records by id from table mypage.
   */
  public function getById($id = NULL, $reset = FALSE) {
    $query = $this->database->select('mypage');
    $query->fields('mypage', array('id', 'title', 'body'));
    if ($id) {
      $query->condition('id', $id);
    }
    $result = $query->execute()->fetchAll();
    if (count($result)) {
      if ($reset) {
        $result = reset($result);
      }
      return $result;
    }
    return FALSE;
  }

  public function getAllDataPagination(){

    $headerQuery = array(
      // We make it sortable by name.
      array('data' => 'Id', 'field' => 'id', 'sort' => 'asc'),
      array('data' => 'Title', 'field' => 'title'),
      array('data' => 'Body', 'field' => 'body'),
    );

    $db = \Drupal::database();
    $query = $db->select('mypage','p');
    $query->fields('p', array('id', 'title', 'body'));

    // The actual action of sorting the rows is here.
    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')
      ->orderByHeader($headerQuery);
    // Limit the rows to 20 for each page.
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit(2);
    $result = $pager->execute();

    return $result;

  }

}

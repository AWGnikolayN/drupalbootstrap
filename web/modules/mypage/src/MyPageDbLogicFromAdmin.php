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
class MyPageDbLogicFromAdmin {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a MyPageDbLogicFromAdmin object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  // Переменная $database придетела к нам из аргумента сервиса.
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public function getAllDataPaginationFromAdmin(){

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
      ->limit(4);
    $result = $pager->execute();

    return $result;

  }

  /**
   * Add new record in table mypage.
   */
  public function add($title, $body) {
    if (empty($title) || empty($body)) {
      return FALSE;
    }
    // Пример работы с БД в Drupal 8.
    $query = $this->database->insert('mypage');
    $query->fields(array(
      'title' => $title,
      'body' => $body,
    ));
    return $query->execute();
  }

}

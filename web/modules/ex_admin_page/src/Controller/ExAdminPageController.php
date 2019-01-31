<?php

namespace Drupal\ex_admin_page\Controller;

class ExAdminPageController {

  # List
  public function ex_page_list() {
    $output = 'Data list';
    return [
      '#markup' => render($output),
    ];
  }

  # List edit
  public function ex_page_list_edit() {
    $output = 'Data list edit';
    return [
      '#markup' => render($output),
    ];
  }

  # Settings
  public function ex_page_settings() {
    $output = 'Data settings';
    return [
      '#markup' => render($output),
    ];
  }

}
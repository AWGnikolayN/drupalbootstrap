<?php

namespace Drupal\crudform\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class CrudformController.
 *
 * @package Drupal\crudform\Controller
 */
class CrudformController extends ControllerBase {

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('This page contain all inforamtion about my crud form ')
    ];
  }

}

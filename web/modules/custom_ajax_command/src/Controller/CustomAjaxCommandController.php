<?php

namespace Drupal\custom_ajax_command\Controller;

use Drupal\Core\Ajax\AjaxResponse;

use Drupal\Core\Controller\ControllerBase;
use Drupal\custom_ajax_command\Ajax\CustomAjaxCommand;

class CustomAjaxCommandController extends ControllerBase{

  public function customAjaxCommandAlert() {

    # New response
    $response = new AjaxResponse();

    # Custom Ajax command
    $message = 'Этот alert() был запущен из кастомной Ajax команды';
    $response->addCommand(new CustomAjaxCommand($message));
    # Return response
    return $response;

  }

}
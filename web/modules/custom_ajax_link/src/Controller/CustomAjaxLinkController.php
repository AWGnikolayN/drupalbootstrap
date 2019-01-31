<?php

namespace Drupal\custom_ajax_link\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;

use Drupal\Core\Controller\ControllerBase;
use Drupal\custom_ajax_command\Ajax\CustomAjaxCommand;

class CustomAjaxLinkController extends ControllerBase{

  public function customAjaxLinkAlert($name) {

    # New response
    $response = new AjaxResponse();

    # Commands Ajax
    $response->addCommand(new AlertCommand('Hello ' . $name));

    # Return response
    return $response;

  }

}
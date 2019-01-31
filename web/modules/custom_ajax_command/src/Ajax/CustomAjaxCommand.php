<?php

namespace Drupal\custom_ajax_command\Ajax;
use Drupal\Core\Ajax\CommandInterface;

class CustomAjaxCommand implements CommandInterface {

  protected $message;
  # Constructs
  public function __construct($message) {
    $this->message = $message;
  }

  # Implements Drupal\Core\Ajax\CommandInterface:render().
  public function render() {
    return array(
      'command' => 'customAjaxCommand',   // Обязательное свойство - определяет название кастомного Jquery (JS) метода, которая будет запущена
      'message' => $this->message,        // Переменные, которые будут доступны в response
    );
  }
}
<?php

/**
 * @file
 * Contains \Drupal\drupaltext\Controller\FirstPageController.
 */

namespace Drupal\drupaltext\Controller;

/**
 * Provides route responses for the DrupalText module.
 */
class FirstPageController {

    /**
     * Returns a simple page.
     *
     * @return array
     *   A simple renderable array.
     */
    public function content() {
        $element = array(
            '#markup' => 'Hello World!',
        );
        return $element;
    }

}
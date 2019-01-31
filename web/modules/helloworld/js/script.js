/**
 * @file
 * Simple JavaScript hello world file.
 */

(function ($, Drupal, settings) {

  "use strict";

  Drupal.behaviors.helloworld = {
    attach: function (context) {
      alert('Hello World!');
    }
  }

})(jQuery, Drupal, drupalSettings);
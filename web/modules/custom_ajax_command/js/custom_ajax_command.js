(function($, Drupal) {

  if(Drupal.AjaxCommands){

    // Custom Ajax command
    Drupal.AjaxCommands.prototype.customAjaxCommand = function(ajax, response, status){
      alert(response.message);
    }

  }

})(jQuery, Drupal);
$(document).ready(function () {
	
  /********Invoice View ********/
  // ---------------------------
  // init date picker
  if ($(".pickadate").length) {
    $(".pickadate").pickadate({
      format: "mm/dd/yyyy",
      container: '#expense_dd'
    });
  }

$(".picker").css("top", "70%");

});

(function(window, document, $) {
  'use strict';

  // Input, Select, Textarea validations except submit button
  $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();

})(window, document, jQuery);

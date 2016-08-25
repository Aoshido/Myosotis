// Variable to hold request
var request;

// Bind to the submit event of our form
$("#bugsplat_form").submit(function (event) {

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = $.ajax({
        url: $("#bugsplat_form").attr("action"),
        type: "post",
        data: serializedData
    });

    $("#bugsplat_report").hide();
    $("#bugsplat_loading").show();

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
        // Log a message to the console
        console.log("Hooray, it worked!" + response + textStatus);
        
        $("#bugsplat_loading").hide();
        $("#bugsplat_reported").show();
    });
 
   // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        
        $("#bugsplat_loading").hide();
        $("#bugsplat_failed").show();
        
        // Log the error to the console
        console.error(
                "The following error occurred: " +
                textStatus, errorThrown
                );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

    // Prevent default posting of form
    event.preventDefault();
});

(function ($) {
    $.fn.feedback = function (success, fail) {
        self = $(this);
        self.find('.dropdown-menu-form').on('click', function (e) {
            e.stopPropagation()
        })

        self.find('.screenshot').on('click', function () {
            self.find('.cam').removeClass('fa-camera fa-check').addClass('fa-refresh fa-spin');
            html2canvas($(document.body), {
                onrendered: function (canvas) {
                    self.find('.screen-uri').val(canvas.toDataURL("image/png"));
                    self.find('.cam').removeClass('fa-refresh fa-spin').addClass('fa-check');
                }
            });
        });

        self.find('.do-close').on('click', function () {
            self.find('.dropdown-toggle').dropdown('toggle');
            self.find('.reported, .failed').hide();
            self.find('.report').show();
            self.find('.cam').removeClass('fa-check').addClass('fa-camera');
            self.find('.screen-uri').val('');
            self.find('textarea').val('');
        });

    };
}(jQuery));

$(document).ready(function () {
    $('.feedback').feedback();
});
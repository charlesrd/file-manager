/* AMS File Manager - Jquery / Javascript code */ 

$(document).ready(function() {
	$(".alert").alert();
	$('.tooltip-overlay').tooltip({
		selector: "a[data-toggle=tooltip]"
	});
	$('noscript').remove();


    // check the session every minute
    // IF the session is expired, reload the page
    setInterval(function checkSession()
    {
        $.get('/user/check_session', function(data)
        {
            // if session was expired
            if (!data.logged_in)
            {
                location.reload();
            }
        });
    }, 60000); // every minute
});


function getCurrentRewardsPoints(dlpID)
{
	// variable to hold request
    var request;
    var rewardsPointsClass = $(".rewards-points");

    // abort any pending request
    if (request) {request.abort();}

    // fire off the request
    request = $.post(
        "http://beta.amsdti.com/tpl/getCurrentRewardsPoints.php", // the post url
        {
            dlpID: dlpID
        },
        function(response,status,xhr){
            //alert("responseText: "+response.responseText);
        });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
        console.log("Successful request");

        // print the response
        rewardsPointsClass.html(response);

     });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        // log the error to the console
        console.error(
            "The following error occured: "+
            textStatus, errorThrown
        );
    });

    // callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        console.log("A request was sent.");
    });
}

/* JQuery Functions */

// Only allow alphabet characters for certain elements
$('.alpha-only').bind('keydown blur', function() { 
    $(this).val( $(this).val().replace(/[^a-zA-Z]/g,'') ); 
});

// Only allow numbers for certain elements
$(".numbers-only").keydown(function (e) {

    // console.log("key: "+e.keyCode);

    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) || 
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
    else // the key was allowed
    {
        // enable the done button
        $('.btn-done').removeAttr('disabled');
    }
});

// Only allow decimal numbers for certain elements
$(".decimal-numbers").keydown(function (e) {

    console.log("key: "+e.keyCode);

    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) || 
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
    else // the key was allowed
    {
        // enable the done button
        $('.btn-done').removeAttr('disabled');
    }
});

// Only allow alphanumeric for certain elements (NO SPACES!)
$('.alphanumeric').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
            e.preventDefault();
        }
        else // the key was allowed
        {
            // enable the done button
            $('.btn-done').removeAttr('disabled');
        }
    }
});

// Only allow alphanumeric for certain elements (SPACES ALLOWED!)
$('.alphanumeric-spaces').keydown(function (e) {
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
            e.preventDefault();
        }
        else // the key was allowed
        {
            // enable the done button
            $('.btn-done').removeAttr('disabled');
        }
    }
});

// Limit the maximum value to the current AMS Rewards Points
$(".max-number-rewards-points").keyup(function (e) {

    // console.log("key: "+e.keyCode);

    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) || 
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
    else // the key was allowed
    {
        var total = +($("#choose-points").val());
        var rewardsPoints = +($(".rewards-points").html());

        if (total > rewardsPoints)
        {
            $("#choose-points").val($("#choose-points").val().substr(0, $("#choose-points").val().length-1));
        }

        // enable the done button
        $('.btn-done').removeAttr('disabled');
    }
});



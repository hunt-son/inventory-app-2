
$(function() {



    $('.edit3').click(function(e) {
        e.preventDefault();
        console.log('edit');
        $('.permission-slide').slideUp();
        $('#temp3').removeClass('hide');
    });
    $('.edit2').click(function(e) {
        e.preventDefault();
        console.log('edit');
        $('.email-slide').slideUp();
        $('#temp2').removeClass('hide');
    });
    $('.edit').click(function(e) {
        e.preventDefault();
        $('.password-slide').slideUp();
        $('#temp').removeClass('hide');
    });

    $('.new-password-cancel').click(function(e) {
        e.preventDefault();
        $('#temp').addClass('hide');
        $('.password-slide').show();
    });
    $('.new-email-cancel').click(function(e) {
        e.preventDefault();
        $('#temp2').addClass('hide');
        $('.email-slide').show();
    });
    $('.new-permission-cancel').click(function(e) {
        e.preventDefault();
        $('#temp3').addClass('hide');
        $('.permission-slide').show();
    });
    $('.dataTable').dataTable( {
        "order": [[ 1, "desc" ]]
    } );

    $('.collapsable').click(function() {
        $('#record_button').show();
        $('.horizontal_inventory_form').slideToggle();

    });

    $('#record_button').click(function() {
       $('#record_button').fadeOut(function() {
           $('.horizontal_inventory_form').slideToggle();
       });
    });

    $('.slidable').click(function() {
        $('.tab-content').slideToggle();
    });
    $('.slidable2').click(function() {
        $('#recordsTable_wrapper').slideToggle();
    });


    $("[data-toggle=modal]").on('show.bs.modal', function(e) {
        e.preventDefault();
    });
    $("[data-toggle=modal]").on('shown.bs.modal', function(e) {
        e.preventDefault();
    });

    $("[data-toggle=popover]").popover({
        html: true,
        content: function() {
            return $('.popover-content').html();
        }
    }).on('inserted.bs.popover', function() {
        $('.current_input').show();
        $('.change_input').on('change', function () {
           // console.log($(this).val());     ///find a way to pull the relations of the clicked select
           input_id = '#' + $(this).val();
            $(this).parents(".popover-content").find('.input-fields').children('div').removeClass('current_input').hide(); //works!!
            $(this).parents(".popover-content").find('.input-fields').find(input_id).addClass('current_input').show();
        });
    });
    $('.confirm-remove').click(function () {
        $.ajax({
            url: '/Dashboard/' + $(this).closest('.fade').attr('id'),
            method: "DELETE"
        }).always(function (response) {
            if (response == 'success') {
                $(this).parents('tr').remove();
            }
            else {
                alert('Product Failed To Delete');
            }
        });
        $.ajax({
            url: '/records',
            method: "POST"
        });
    });


    $('.record-remove').click(function () {
        $.ajax({
            url: '/records/' + $(this).attr('rel'),
            method: "DELETE"
        }).always(function (response) {
            console.log(response);
            if (response == 'success') {
                console.log('on success');
                $(this).parents('tr').remove();
                location.reload();
            }
            else {
                alert('Product Failed To Delete');
                console.log($(this));
            }
        });
    });

    $('.aForm').hide();
    $this = $('li.active-form').attr('id');
    //console.log($this);
    $('#form' + $this).show();
//HTML is styled so that all form ID's are structured with "form" + "name of Form" where "name of Form" is the same as the 'li' ID.
    $('.navbarForForms').on('click', 'li', function () {
        $('.aForm').hide();
        //find all elements with class 'active-form'
        var currentForm = document.getElementsByClassName('active-form');
        //get the id from that class
        var currentID = $(currentForm).parent('ul').find('li').attr('id');
        //hide the associated form
        $('#form' + currentID).hide();
        //remove the 'active-form' class and styling
        $(this).parent('ul').find('li').removeClass('active-form');
        //add the 'active-form' class and styling
        $(this).addClass('active-form');
        //find the id of the attribute
        var newForm = $(this).attr('id');
        //show the associated form
        $('#form' + newForm).show();

    });


    $('.products_container').hide();

    $active = $('.active').children('a').attr('href');
    $('#' + $active).fadeIn();

    $('#nav-menu').on('click', '> li', function (e) {
        e.preventDefault();
        $('#' + $('.active').children('a').attr('href')).fadeOut();
            $(this).parent('ul').find('li').removeClass('active');
            $(this).addClass('active');



        $('#' + $(this).children('a').attr('href')).fadeIn();

        formFill();
    });



});



function formFill() {
    if ($('.active').children('a').attr("href") == "availableForms") {
        console.log('no here');
        $('.tutorial-2').fadeOut(600);
        $.ajax({
            url: "/Dashboard/create",
            method: "GET"
        }).always(function (response) {
            console.log(response);
            if (response == 'success') {
                $('.notification').show();
            }
            else {
                console.log($(this));
            }
        });
    $('.submitButton').on('click', function() {
        $.ajax({
            url: "/products/store",
            method: "POST"
        }).always(function (response) {
            console.log(response);
            if (response == 'success') {
                $('.notification').show();
            }
            else {
                console.log($(this));
            }
        });

    })
    }


}

function insertParam(key, value) {
    key = escape(key); value = escape(value);

    var kvp = document.location.search.substr(1).split('&');
    if (kvp == '') {
        document.location.search = '?' + key + '=' + value;
    }
    else {

        var i = kvp.length; var x; while (i--) {
            x = kvp[i].split('=');

            if (x[0] == key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if (i < 0) { kvp[kvp.length] = [key, value].join('='); }

        //this will reload the page, it's likely better to store this until finished
        document.location.search = kvp.join('&');
    }
}
$(function() {
    $('.help-information').hide();
    $('.article').children('.description').hide();

    $('.article').click(function () {
        $('.article').removeClass('current');
        $('.description').slideUp();

        $(this).addClass('current');
        $(this).children('.description').slideDown();
    });

    $('.child-link').click(function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        $matches = url.replace(/^\D+/g, "");
        $active = $(".bs-dovs-side-nav").children('li').get($matches - 1);
        $active.className += " active-li";

        $('.articles').hide(100, function (e) {
            $('.help-information').show();
            $('.side-bar').show();
            $('html, body').animate({
                scrollTop: $('#' + $matches).offset().top
            }, 500);
        });
    });

    $('.bs-dovs-side-nav').children('li').click(function (e) {
        var url = $(this).children('a').attr('href');
        e.preventDefault();
        $('li').removeClass('active-li');
        $matches = url.replace(/^\D+/g, "");
        console.log($matches);
        $active = $(".bs-dovs-side-nav").children('li').get($matches - 1);
        $active.className += " active-li";
        $('html, body').animate({
            scrollTop: $('#' + $matches).offset().top
        }, 500);
    });

    $('.bs-dovs-side-nav').affix({
        offset: {
            top: $('.bs-dovs-side-nav').offset().top
        }
    });

    $('.bs-dovs-side-nav').affix({
        offset: {
            bottom: $('.background-bottom').outerHeight(true)
        }
    });

    $('body').scrollspy({target: '.scrollspy'});
});
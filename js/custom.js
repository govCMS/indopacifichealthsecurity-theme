(function ($, Drupal, window, document, undefined) {

    // Update responsiveSlides behaviour to support autoslide

    Drupal.behaviors.responsiveSlides = {
        attach: function(context, settings) {

            $(".view-slideshow ul:not(.contextual-links)").responsiveSlides({
                "auto": true
            });

        }
    };

})(jQuery, Drupal, this, this.document);

jQuery(document).ready(function( $){
    $(".header .menu-name-main-menu").menumaker({
        title: "Menu",
        format: "multitoggle"
    });

    var refreshShortcutPanels = function() {
        var eqPageWidth = $(window).width();
        var shortcutPanels = $(".view-id-home_tiles_shortcut .tiles-row");
        var colIndex = 1;
        var rowIndex = 1;
        var boxPadding = 82;

        if (eqPageWidth <= 450) {
            boxPadding = 22;
        }

        $(shortcutPanels).each(function() {
            $(this).removeClass("short-row-1 short-row-2 short-row-3 short-row-4");
            $(this).addClass("short-row-"+rowIndex);

            if ( (eqPageWidth <= 991 && colIndex === 2) || (eqPageWidth >= 992 && colIndex === 4) ) {
                rowIndex++;
                colIndex = 1;
            } else {
                colIndex++;
            }
        });

        for ( var i = 1, l = rowIndex; i <= l; i++ ) {
            var heights = $(".view-id-home_tiles_shortcut .tiles-row.short-row-"+i).map(function() {
                $(this).css('min-height', 'unset');
                return $(this).height();
            }).get();

            var maxHeight = Math.max.apply(null, heights);
            var panelMinHeight = maxHeight + boxPadding;

            if (panelMinHeight < 408 && eqPageWidth > 1280) {
                panelMinHeight = 408;
            }

            $(".view-id-home_tiles_shortcut .tiles-row.short-row-"+i).css('min-height', panelMinHeight + 'px');
        }
    };

    refreshShortcutPanels();

    var panelTimeout = (function(){
        var timer;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(window).resize(function() {
        panelTimeout(refreshShortcutPanels, 500);
    });

    /**Code to add accoridian effect to the menu*/
    $('.header .menu-name-main-menu li.active').addClass('open').children('ul').show();

    $('.header .menu-name-main-menu li.has-sub>.submenu-button').on('click', function(){
        // $(this).removeAttr('href');
        var element = $(this).parent('li');
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('.submenu-opened').removeClass('submenu-opened');
            element.find('li').removeClass('open');
            element.find('ul').slideUp();
        } else {
            element.addClass('open');
            element.children('ul').slideDown();
            element.siblings('li').children('ul').slideUp();
            element.siblings('li').removeClass('open');
            element.siblings('li').find('.submenu-opened').removeClass('submenu-opened');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp();
        }
    });
    /**end menu code*/

    // select2 js
    var updateSelectors = function() {

        $("select").select2({dropdownCssClass: 'custom-select2-dd',containerCssClass: 'custom-select2-container','minimumResultsForSearch': -1});

        $('select').on('select2:open', function () {
            $('.select2-results .select2-results__options').mCustomScrollbar('destroy');
            $('.select2-results .select2-results__options').mCustomScrollbar('update');
            setTimeout(function() {
                $('.select2-results .select2-results__options').mCustomScrollbar({
                    axis: 'y',
                    theme:"dark",
                    // scrollbarPosition: 'inside',
                    advanced:{
                        updateOnContentResize: true
                    },
                    live: true
                });
            }, 0);
        });

        var pageWidth = $(window).width();

        if (pageWidth > 976) {
            $(".sidebars select").select2({dropdownCssClass: 'custom-select2-dd',containerCssClass: 'custom-select2-container','minimumResultsForSearch': -1});

            $('.sidebars select').on('select2:open', function () {
                $('.select2-results .select2-results__options').mCustomScrollbar('destroy');
                $('.select2-results .select2-results__options').mCustomScrollbar('update');
                setTimeout(function() {
                    $('.select2-results .select2-results__options').mCustomScrollbar({
                        axis: 'y',
                        theme:"dark",
                        // scrollbarPosition: 'inside',
                        advanced:{
                            updateOnContentResize: true
                        },
                        live: true
                    });
                }, 0);
            });
        }
    };

    updateSelectors();

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(window).resize(function() {
        delay(updateSelectors, 500);
    });


    $(document).ajaxComplete(function(){
        updateSelectors();
    });

    $(".custom-search-icon").click(function(){
        $("#search-block-form").show();
        $("#search-block-form").animate({right: '0'});

    });

    $(document).click(function( evt ) {

        var container = $("#custom-search-section");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(evt.target) && container.has(evt.target).length === 0)
        {
            $("#search-block-form").animate({right: '-1009px'});
            $("#search-block-form").hide('slow');
        }
    });

    // our approach page read more
    $(".approach-item .link a").click(function (e) {
        e.preventDefault();
        $('.approach-item').each( function(){
            $(this).find('.maxhit').removeClass('maxhit');
            $(this).find('.link a').removeClass('active');
            $(this).find('.link a').show();
        });

        if( !$(this).hasClass('active') ) {
            $(this).parent().parent().find('.description').addClass("maxhit");
            $(this).addClass("active");
            $(this).hide();
        } else{
            $(this).parent().parent().find('.description').removeClass("maxhit");
            $(this).removeClass("active");
        }
    });

    // Health Security crops page read more
    $(".health-security-block .link-section a").click(function (e) {
        e.preventDefault();
        $('.health-security-block').each( function(){
            $(this).find('.maxhit').removeClass('maxhit');
            $(this).find('.link-section a').removeClass('active');
            $(this).find('.link-section a').show();
        });

        if( !$(this).hasClass('active') ) {
            $(this).parent().parent().find('.details-section').addClass("maxhit");
            $(this).hide();
            $(this).parent().parent().focus();
        } else{
            $(this).parent().parent().find('.details-section').removeClass("maxhit");
            $(this).removeClass("active");
        }
    });

    $(document).on('click', '#sideSprButton', function(){
        if( !$(this).hasClass('played')){
            $(this).addClass('played');
        } else{

            $(this).removeClass('played');
            sideStop();
        }
    });


    $(document).on('click', 'div.gmnoprint img:first-child',function(){
        if( !$(this).parent().hasClass( 'gmnoprint'))
            return false;

        $(".gm-style-pbc").next().addClass('map-overlay');

        setTimeout(function(){ $('.sgmpopup img').attr( 'id','map-close-btn');
            var el = document.getElementById("map-close-btn");
            el.addEventListener("click", modifyText, false);
        }, 700);
    });

    function modifyText() {
        $(".gm-style-pbc").next().removeClass('map-overlay');
    }

    $(document).on('click', '.tabnav li a', function(e){
        e.preventDefault();
        var el_id = $(this).attr('href');
        if( el_id != '' || typeof el_id !== 'undefined' ) {
            $(this).parent().parent().find('li.active').removeClass('active');
            $('.tab-content .tab-pane.active').fadeIn('slow');
            $('.tab-content .tab-pane.active').removeClass('active');


            $(this).parent().addClass('active');
            $(el_id).fadeOut('slow');
            $(el_id).addClass('active');

        }
    });

    // Profile page equalheight

    var equalheight = function(container){

        var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = new Array(),
            $el,
            topPosition = 0;
        $(container).each(function() {

            $el = $(this);
            $($el).height('auto')
            topPostion = $el.position().top;

            if (currentRowStart != topPostion) {
                for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                    rowDivs[currentDiv].height(currentTallest);
                }
                rowDivs.length = 0; // empty the array
                currentRowStart = topPostion;
                currentTallest = $el.height();
                rowDivs.push($el);
            } else {
                rowDivs.push($el);
                currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
        });
    };

    $(window).load(function() {
        equalheight('.member-profile .profiles-section');
    });


    $(window).resize(function(){
        equalheight('.member-profile .profiles-section');
    });

    // End Profile page


    document.onreadystatechange = function () {
        var state = document.readyState;
        if (state == 'interactive') {
            document.getElementById('body').style.visibility="hidden";
        } else if (state == 'complete') {
            setTimeout(function(){
                document.getElementById('interactive');
                document.getElementById('load').style.visibility="hidden";
                if (document.getElementById('body')) {
                    document.getElementById('body').style.visibility="visible";
                }
            },1500);
        }
    };

});

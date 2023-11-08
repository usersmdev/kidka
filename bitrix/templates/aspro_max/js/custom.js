
window.addEventListener('load', function () {

    function getScrollbarWidth() {
        var outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.width = '100px';
        document.body.append(outer);

        var widthNoScroll = outer.offsetWidth;

        // Force scrollbars
        outer.style.overflow = 'scroll';

        // Add innerdiv
        var inner = document.createElement('div');
        inner.style.width = '100%';
        outer.append(inner);

        var widthWithScroll = inner.offsetWidth;

        // Remove divs
        outer.remove();

        return widthNoScroll - widthWithScroll;
    }

    function setScrollbarVar(value) {
        document.body.style.setProperty('--scrollbar-width', value + 'px');
    }

    function addScrollObserver() {

        var config = {
            threshold: 1.0
        }

        var handleIntersect = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.intersectionRatio < 1) {
                    setScrollbarVar(getScrollbarWidth());
                } else {
                    setScrollbarVar(0);
                }
            });
        }

        var bodyScrollObserver = new IntersectionObserver(handleIntersect, config);

        bodyScrollObserver.observe(document.body);
    }

    addScrollObserver();
});
/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/
jQuery(function($) {
    function fixMenuInit() {
        var $inner = $('.menus-inner');
        var inited1 = $inner.is('.initied')
        var $parent = $inner.parent();
        if (inited1 && $parent.is('.menus') && !$parent.is('.initied')) {
            $parent.addClass('initied');
        }
    }
    BX.addCustomEvent("onWindowResize", fixMenuInit);
    setTimeout(fixMenuInit, 100);
    setTimeout(fixMenuInit, 500);
    setTimeout(fixMenuInit, 1000);
    setTimeout(fixMenuInit, 1500);
    setTimeout(fixMenuInit, 2000);
});
jQuery(function($) {
    if (!$(".project-video").length) {
        return;
    }
    $(".project-video").owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        loop: true,
        video: true,
        center: true,
        stagePadding: 495,
        responsiveClass: true,
        responsive: {
            0: {
                stagePadding: 0
            },
            1025: {
                stagePadding: 350
            },
            1281: {
                stagePadding: 495
            }
        }
    });
    $(document).on('click', '.project-video .item-video', function (event) {
        location.assign($(this).data('detail-url'));
    });
    $(document).on('click', '.project-video .owl-next', function (event) {
        if ($('.project-video_title.active').is(':last-child')) {
            $('.project-video_title.active').removeClass('active');
            $('.project-video_title:first-child').addClass('active');
        } else {
            $('.project-video_title.active').removeClass('active').next().addClass('active');
        }
    });

    $(document).on('click', '.project-video .owl-prev', function (event) {
        if ($('.project-video_title.active').is(':first-child')) {
            $('.project-video_title.active').removeClass('active');
            $('.project-video_title:last-child').addClass('active');
        } else {
            $('.project-video_title.active').removeClass('active').prev().addClass('active');
        }
    });
});
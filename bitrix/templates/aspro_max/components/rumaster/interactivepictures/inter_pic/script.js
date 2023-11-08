
$(function () {

    if($(".slider-inter-big div.inter-box-img").length > 0) {
        $(".slider-inter-big div.inter-box-img").each(function (index, element) {
            initInteractivepictures('#' + element.id, JSON.parse(element.dataset.settings));
            // $('#'+element.id).imageMapPro(JSON.parse(element.dataset.settings));
        })
    }

    $('.slider-inter-big').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-inter-tmb'
    });
    $('.slider-inter-tmb').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-inter-big',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        arrows: true,
    });
})
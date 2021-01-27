$('.owl-carousel').owlCarousel({
    loop:true,
    nav:true,
    items: 1,
    navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
})


// var tableOffset = $("#table-1").offset().top;
// var $header = $("#table-1 > thead").clone();
// var $fixedHeader = $("#header-fixed").append($header);
//
// $(window).bind("scroll", function() {
//     var offset = $(this).scrollTop();
//
//     if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
//         $fixedHeader.show();
//     }
//     else if (offset < tableOffset) {
//         $fixedHeader.hide();
//     }
// });
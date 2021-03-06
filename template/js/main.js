$(function() {
    
	'use strict';
    
	$(".preloader").fadeOut();
	
    $('.sidebar').sideNav({
        edge: 'left'
    });
    
	$('.sidebar-search').sideNav({
        edge: 'right'
    });
    
	$('.sidebar-cart').sideNav({
        edge: 'right'
    });
    
	$(window).on('scroll', function() {
        if ($(document).scrollTop() > 50) {
            $(".navbar").css({
                "box-shadow": "rgba(0, 0, 0, .13) 0px 0px 13px"
            });
        } else {
            $(".navbar").css({
                "box-shadow": "none"
            });
        }
    });
    $(".slide-show").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true,
        margin: 10,
        autoplay: true
    });
    $(".product-slide").owlCarousel({
        stagePadding: 20,
        loop: false,
        margin: 10,
        items: 2,
        dots: false
    });
    $(".product-slide-two").owlCarousel({
        stagePadding: 20,
        loop: false,
        margin: 10,
        items: 2,
        dots: false
    });
    $(".product-d-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        loop: false,
        margin: 10,
    });
    $('ul.tabs').tabs();
    $('.collapsible').collapsible();
    $(".testimonial").owlCarousel({
        items: 1,
        loop: false
    })
});
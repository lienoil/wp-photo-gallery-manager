jQuery(document).ready(function ($) {
	console.log(_photogal.perSlide);
	$(document).find("[data-toggle=owl-carousel]").owlCarousel({
		items: (typeof _photogal != 'undefined') ? _photogal.perSlide : 5,
	    autoPlay : true,
	    stopOnHover : true,
	    autoHeight : true,
	});

    $(".photo-lightgallery").lightGallery({
        thumbnail: (typeof _photogal != 'undefined') ? _photogal.showThumbnail : true,
        selector:'.image-selector',
        mode: 'lg-zoom-out',
        download: false,
        mousewheel: true,
    });
    // alert('asdasd');
});
jQuery(document).ready(function ($) {
	console.log(_photogal.perSlide);
	$(document).find(".owl-carousel").owlCarousel({
		items: (typeof _photogal != 'undefined') ? _photogal.perSlide : 5,
	    autoPlay : true,
	    stopOnHover : true,
	    autoHeight : true,
	});

    $(document).find(".photogal").lightGallery({
        thumbnail: true,
        selector:'.image-selector',
        mode: 'lg-zoom-out',
        download: false,
        mousewheel: true,
    });
    // alert('asdasd');
});
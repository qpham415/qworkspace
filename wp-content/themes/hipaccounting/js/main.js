jQuery(document).ready(function($) {

   'use strict';

   //ON-DEMAND STICKY HEADER
	var options = {
		offset: 92,
		classes: {
			clone:   'banner--clone',
			stick:   'banner--stick',
			unstick: 'banner--unstick'
		}
	};

	// Initialise with options
	var banner = new Headhesive('.banner', options);

	// Headhesive destroy
	// banner.destroy();


	//REV SLIDER
	var revapi;

    revapi = jQuery('.tp-banner').revolution(
	{
		delay:9000,
		startwidth:1170,
		startheight:500,
		hideThumbs:10,
		fullWidth:"on",
		forceFullWidth:"on"

	});


	//SMOOTH SCROLL
	smoothScroll.init({
		speed: 500, // How fast to complete the scroll in milliseconds
		easing: 'easeInOutCubic', // Easing pattern to use
		updateURL: false, // Boolean. Whether or not to update the URL with the anchor hash on scroll
		callbackBefore: function ( toggle, anchor ) {}, // Function to run before scrolling
		callbackAfter: function ( toggle, anchor ) {} // Function to run after scrolling
	 });





//	//MAGNIFIC POPUP IMAGE
	$('.image-link').magnificPopup({
		type:'image',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},

	});

	//MAGNIFIC POPUP AJAX CONTENT
	$('.register').magnificPopup({type: 'ajax'});

	//OWLCAROUSEL GALLERY
	var owl = $(".gallery");

    owl.owlCarousel({
		  itemsCustom : [
			[0, 1],
			[450, 1],
			[600, 2],
			[700, 2],
			[1000, 3],
			[1200, 3],
			[1600, 3]
		  ],
		  pagination : true,
		  navigation : false,
		  navigationText : ['<i class="fa fa-4x fa-chevron-circle-left"></i>','<i class="fa fa-4x  fa-chevron-circle-right"></i>'],
	  });

	  //OWLCAROUSEL PRICING
	var owl = $(".pricing");

    owl.owlCarousel({
		  itemsCustom : [
			[0, 1],
			[450, 1],
			[600, 2],
			[700, 2],
			[1000, 4],
			[1200, 4],
			[1600, 4]
		  ],
		  pagination : true,
		  navigation : false,
		  navigationText : ['<i class="fa fa-4x fa-chevron-circle-left"></i>','<i class="fa fa-4x  fa-chevron-circle-right"></i>'],
	  });

	// PARTNERS SLIDER
	var owl = $(".clients");

	  owl.owlCarousel({
		  itemsCustom : [
			[0, 1],
			[450, 1],
			[600, 2],
			[700, 3],
			[1000, 6],
			[1200, 6],
			[1600, 6]
		  ],
		  pagination : true,
		  navigation : false,
		  navigationText : ['<i class="fa fa-4x fa-chevron-circle-left"></i>','<i class="fa fa-4x  fa-chevron-circle-right"></i>'],
	  });

	//FIX HOVER EFFECT ON IOS DEVICES
	document.addEventListener("touchstart", function(){}, true);

  //Relink login
  function SetUrlParams() {
    $("#menu-hip-nav > li > a").each(function(){
       this.href = "MyURLOfChoice";
    });
  }​

});


$(window).load(function(){


	//PARALLAX BACKGROUND
	$(window).stellar({
		horizontalScrolling: false,
	});


});

$(document).ready(function(){

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

  //SMOOTH SCROLL
  smoothScroll.init({
    speed: 500, // How fast to complete the scroll in milliseconds
    easing: 'easeInOutCubic', // Easing pattern to use
    updateURL: false, // Boolean. Whether or not to update the URL with the anchor hash on scroll
    callbackBefore: function ( toggle, anchor ) {}, // Function to run before scrolling
    callbackAfter: function ( toggle, anchor ) {} // Function to run after scrolling
  });

  //Resize navigation clone
  function reBanner(){
  var bannerHead = document.getElementsByClassName("banner--clone")[0];
  var navBar = bannerHead.getElementsByTagName('nav')[0];
  navBar.setAttribute( "class", "navbar navbar-custom navbar-slim" );;
  }
  reBanner();


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

});

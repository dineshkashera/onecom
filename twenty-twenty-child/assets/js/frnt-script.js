/**
 * Frontend js for header
 */
var siteurl = CALLF.siteurl;//siteurl
var ajaxurl = CALLF.ajaxurl;//ajaxurl
var is_home = CALLF.is_home;

jQuery(document).ready(function(){

	//show slick slider on home page only
	if(is_home){
		jQuery('div#featured_slider').slick({
		  dots: true,
		  infinite: true,
		  speed: 300,
		  arrows: false,
		  customPaging: function (slider, i) {
	        console.log(slider);
	        return '';
	     },
		  autoplay: true,
		  autoplaySpeed: 3000,
		  fade: true,
	      fadeSpeed: 1000,
		  slidesToShow: 1
		});
	}
});
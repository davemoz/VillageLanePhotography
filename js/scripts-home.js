( function() {
	
	/* Flickity - Homepage Slider */
	var homepageVidSlider = document.querySelector('.wp-block-gallery');
	homepageVidSlider.classList.remove('is-hidden');
	homepageVidSlider.offsetHeight;
	var homepageVidFlkty = new Flickity( homepageVidSlider, {
		// options
		autoPlay: 5000,
		draggable: true,
		pageDots: false,
		wrapAround: true,
		prevNextButtons: true,
		cellAlign: 'center',
		imagesLoaded: true,
	});
	homepageVidSlider.addEventListener('mouseleave', function(e) { homepageVidFlkty.playPlayer() });

} )();
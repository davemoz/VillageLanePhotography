(function () {

	/* Flickity - Homepage Slider */
	var homepageSlider = document.querySelector('.blocks-gallery-grid');
	homepageSlider.classList.remove('is-hidden');
	homepageSlider.offsetHeight;
	var homepageFlkty = new Flickity(homepageSlider, {
		// options
		autoPlay: 5000,
		draggable: true,
		pageDots: false,
		wrapAround: true,
		prevNextButtons: true,
		cellAlign: 'center',
		imagesLoaded: true,
		lazyLoad: true,
	});
	homepageSlider.addEventListener('mouseleave', function (e) { homepageFlkty.playPlayer() });

})();
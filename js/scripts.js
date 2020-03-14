( function() {

/*
 * Masonry Init
 */

// external js: masonry.pkgd.js, imagesloaded.pkgd.js
// init Masonry
var grid = document.querySelector('.gallery');
var sizingDiv = document.createElement('div');
sizingDiv.classList.add('grid-sizer');
if(grid){
	grid.appendChild(sizingDiv);
}

var gutterDiv = document.createElement('div');
gutterDiv.classList.add('gutter-sizer');
if(grid){
	grid.appendChild(gutterDiv);
}

if(grid){
	var msnry = new Masonry( grid, {
	  itemSelector: '.gallery-item',
	  columnWidth: '.grid-sizer',
	  gutter: '.gutter-sizer',
	  percentPosition: true
	});

	imagesLoaded( grid ).on( 'progress', function() {
	  // layout Masonry after each image loads
	  msnry.layout();
	});
}

/*
 * Limit form checkbox selection to 2
 */
jQuery('.limit-three input[type="checkbox"]').on('change', function() {
   if(jQuery('.limit-three input[type="checkbox"]:checked').length > 2) {
       this.checked = false;
   }
});


} )();
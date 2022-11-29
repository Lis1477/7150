$(document).ready(function(){

	// *******************************************************
	console.log('линк категории в товарном блоке');

	$('.js-parent-cat-link').click(function(e){
		// отменяем действие по умолчанию
		e.preventDefault();

		// определяем линк
		var link = $(this).data('link');

		// редиректим
		window.location.href = link;
	});

});

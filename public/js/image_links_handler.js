$(document).ready(function(){
	console.log('обработчик линков изображений');
	$('.item-element_image-link').hover(function(){
		var id_1c = $(this).data('id-1c');
		var i = $(this).data('i');
		$('.js-img-link-' + id_1c).removeClass('active');
		$(this).addClass('active');

		$('.item-element_images-block.item-' + id_1c + ' img').removeClass('active');
		$('.item-element_images-block.item-' + id_1c + ' img.js-img-' + i).addClass('active');
	}, function(){
		var id_1c = $(this).data('id-1c');
		$('.js-img-link-' + id_1c).removeClass('active');
		$('.js-img-link-' + id_1c + '.first').addClass('active');

		$('.item-element_images-block.item-' + id_1c + ' img').removeClass('active');
		$('.item-element_images-block.item-' + id_1c + ' img.js-img-1').addClass('active');
	});
});
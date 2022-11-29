$(document).ready(function(){

	console.log('меняем ссылки на абсолютные');

	// собираем изображения
	var images = $('.js-news-content').find('img');
	var replaced;

	// если есть
	if(images.length) {
		// переписываем линки
		images.each(function(){
			replaced = $(this).attr('src').replace('/storage', 'https://alfastok.by/storage');
			$(this).attr('src', replaced);
		});
	}

});
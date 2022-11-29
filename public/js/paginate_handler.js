$(document).ready(function(){

	console.log('выпадашка Показывать по ...');

	// показываем/прячем выпадашку
	$('.js-select-but').click(function(){
		$(this).next('.js-select-block').fadeToggle();
	});

	// прячем выпадашку при нажатии в любом месте
	$(document).click(function(e){
		if(!$(e.target).closest($('.js-select-block')).length) {
			if(!$(e.target).closest($('.js-select-but')).length) {
				$('.js-select-block').fadeOut();
			}
	        e.stopPropagation();
		}
	});

	// предотвращаем переход по ссылке
	$('.js-paginate-link').click(function(e){
		// берем текущее значение paginate_num
		var paginate_num = $(this).parent('.js-select-block').data('paginate');
		// берем переключаемое значение paginate_num
		var paginate_select = $(this).html();
		// если равны, предотвращаем переход
		if(paginate_num == paginate_select) {
			e.preventDefault();
		}
	});


});
$(document).ready(function(){

	console.log('выпадашка сортировки');

	// показываем/прячем выпадашку
	$('.js-sort-but').click(function(){
		$(this).next('.js-sort-block').fadeToggle();
	});

	// прячем выпадашку при нажатии в любом месте
	$(document).click(function(e){
		if(!$(e.target).closest($('.js-sort-block')).length) {
			if(!$(e.target).closest($('.js-sort-but')).length) {
				$('.js-sort-block').fadeOut();
			}
	        e.stopPropagation();
		}
	});

	// предотвращаем переход по ссылке
	$('.js-sort-link').click(function(e){
		// берем текущее значение sort_str
		var sort_str = $(this).parent('.js-sort-block').data('sort');
		// берем переключаемое значение 
		var sort_select = $(this).html();
		// если равны, предотвращаем переход
		if(sort_str == sort_select) {
			e.preventDefault();
		}
	});


});
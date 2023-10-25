	$('.status').each(function() {
		if($(this).text() == 'Остановлен')
			$(this).css('color', 'red');
		else if($(this).text() == 'Ошибка')
			$(this).css('color', 'yellow');
	});
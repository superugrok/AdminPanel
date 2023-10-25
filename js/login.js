	$('button[name="sendAuth"]').remove();
	$('.login').css('height', '435px');
	$('input').css('pointer-events', 'none');
	$("#reCaptcha").submit(function(e){
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "./functions/recaptcha_send.php",
				data: $("#reCaptcha").serialize(),
				success: function(data){
				    if(data == true) {
				    	document.cookie = "f=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
				    	setTimeout( 'location="https://evionrp.ru/evi-admin/index.php";', 10 );
				    }
				    else
				    	alert('Капча не пройдена!');
				}
			});
	});
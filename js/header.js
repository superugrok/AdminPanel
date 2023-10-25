	function checkAvatarErrors() {
		if($('p[name="avatarError"]').text() != '') {
			$('p[name="avatarError"]').show();
			alert('Изображение некорректно. Поддерживаемые форматы: jpeg, jpg, png, а максимальный размер 2 мб.');
		}
	}
	function menuSwitch() {
		let menuCurrentCss = $('.menu').css("margin-left");
		let menuWidth = $('.menu').width();
		let contentWidth = $('aside').width();
		let needenWidth = contentWidth - menuWidth;
		let browserWidth = $(window).width();
		if(menuCurrentCss == '-380px' || menuCurrentCss == '-1000px' && browserWidth >= '727') {
			$( ".menu" ).animate({
				  marginLeft: "0"
				}, 1000);
				$( "aside" ).animate({
				  marginLeft: "380px",
				  width: needenWidth
				}, 1000);
		}
		else if(menuCurrentCss == "0px" && browserWidth >= '727') {
			$( ".menu" ).animate({
				  marginLeft: "-380px",
				  width: "380px"
				}, 1000);
				$( "aside" ).animate({
				  marginLeft: "0",
				  width: "100%"
				}, 1000);
		}
		else if(menuCurrentCss == '-1000px' || menuCurrentCss == '-380px' && browserWidth <= '727') {
			$( ".menu" ).animate({
				  marginLeft: "0",
				  /*width: "100%"*/
				}, 1000);
				$( "aside" ).animate({
				  width: "0"
				}, 1000);
				$(".promote").hide();
				$(".demote").hide();
				$(".remove").hide();
		}
		else if(menuCurrentCss == "0px" && browserWidth <= '727') {
			$( ".menu" ).animate({
				  marginLeft: "-1000px",
				  /*width: "380px"*/
				}, 1000);
				$( "aside" ).animate({
				  marginLeft: "0",
				  width: "100%"
				}, 1000);
				$(".promote").show();
				$(".demote").show();
				$(".remove").show();
		}
	}
	function profileSwitch() {
		let browserWidth = $(window).width();
		let currentPage = document.title;
		let currentStatus = $('.user_bar').css("display");
		if(currentStatus == 'none') {
			$('.user_bar').show(1000);
			$('.welcome_right').hide(1000);
			if(browserWidth <= '1600' && currentPage == 'Evion Web Admin - Главная') {
				$(".promote").hide();
					$(".demote").hide();
					$(".remove").hide();
			}
			else if(browserWidth <= '1310' && currentPage == 'Evion Web Admin - Управление') {
				$(".promote").hide();
					$(".demote").hide();
					$(".remove").hide();
			}
		}
		else if(currentStatus != 'none') {
			$('.user_bar').hide(1000);
			$('.welcome_right').show(1000);
			$(".promote").show();
			$(".demote").show();
			$(".remove").show();
		}
	}
	function menuActive() {
		let currentPage = document.title;
		if(currentPage == 'Evion Web Admin - Главная') {
			$('.menu_main').css('background-image', 'url("assets/menu/main_onload.png")');
		}
		else if(currentPage == 'Evion Web Admin - Игроки') {
			$('.menu_players').css('background-image', 'url("assets/menu/players_onload.png")');
		}
		else if(currentPage == 'Evion Web Admin - Сервисы') {
			$('.menu_service').css('background-image', 'url("assets/menu/service_onload.png")');
		}
		else if(currentPage == 'Evion Web Admin - Сервер') {
			$('.menu_server').css('background-image', 'url("assets/menu/server_onload.png")');
		}
		else if(currentPage == 'Evion Web Admin - Управление') {
			$('.menu_access').css('background-image', 'url("assets/menu/access_onload.png")');
		}
	}
	function validEmail(email, oldEmail) {
		let emailSyntax = /[0-9a-z_-]+@[0-9a-z_-]+\.[a-z]{2,5}/i;
		if(emailSyntax.test(email) == false)
			alert('Введённый Email некорректен!');
		else
			newEmail(oldEmail);
	}
	function newEmail(oldEmail) {
		$.post("./functions/profile_changes.php", {oldEmail: oldEmail}, function(data) { 
			if(data == true) {
				$('input[name="new_email"]').hide();
				$('input[name="code_email"]').show();
				$('button[name="email_save"]').hide();
				$('button[name="email_code"]').show();
				$('p[name="email_send"]').show();
			}
			else
				alert('Ошибка Backend');
		});
	}
	function newEmailCode(code, newEmail, user) {
		$.post("./functions/profile_changes.php", {code: code, newEmail: newEmail, user: user}, function(data) { 
			if(data == true) {
				$('input[name="new_email"]').show();
				$('input[name="code_email"]').hide();
				$('button[name="email_save"]').show();
				$('button[name="email_code"]').hide();
				$('p[name="email_send"]').hide();
				$('p[name="invalid_email_code"]').hide();
				$('p[name="email_changed"]').show();
			}
			else if(data == false) {
				$('p[name="email_send"]').hide();
				$('p[name="invalid_email_code"]').show();
			}
			else
				alert('Ошибка Backend');
		});
	}
	function validPassword(oldPassword, newPassword, email, user) {
		if(newPassword.length >= 20 || newPassword.length <= 6) {
			alert('Некорректная длина пароля. Максимум символов - 19, минимум - 7');
		}
		else {
			$.post("./functions/profile_changes.php", {oldPassword: oldPassword, user: user}, function(data) { 
				if(data == true) {
					newPassword(email);
				}
				else if(data == false)
					$('p[name="invalid_password_old"]').show();
				else
					alert('Ошибка Backend');
			});
		}
	}
	function newPassword(email) {
		$.post("./functions/profile_changes.php", {email: email}, function(data) { 
			if(data == true) {
				$('input[name="oldPass"]').hide();
				$('input[name="newPass"]').hide();
				$('input[name="code_password"]').show();
				$('button[name="pass_save"]').hide();
				$('button[name="pass_save_code"]').show();
				$('p[name="password_send"]').show();
				$('p[name="invalid_password_old"]').hide();
			}
			else
				alert('Ошибка Backend');
		});
	}
	function newPasswordCode(code, user, newPassword) {
		$.post("./functions/profile_changes.php", {code: code, newPassword: newPassword, user: user}, function(data) { 
			if(data == true) {
				$('input[name="oldPass"]').show();
				$('input[name="newPass"]').show();
				$('input[name="code_password"]').hide();
				$('button[name="pass_save"]').show();
				$('button[name="pass_save_code"]').hide();
				$('p[name="password_send"]').hide();
				$('p[name="invalid_password_code"]').hide();
				$('p[name="password_changed"]').show();
			}
			else if(data == false) {
				$('p[name="password_send"]').hide();
				$('p[name="invalid_password_code"]').show();
			}
			else
				alert('Ошибка Backend');
		});
	}
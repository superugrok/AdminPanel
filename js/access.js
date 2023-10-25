	function removeCode(element) {
		let codeId = element.getAttribute('id');
		$.post("./functions/access_func.php", {codeId: codeId}, function(data) {
			if(data == true)
				$('tr[id="'+codeId+'"]').hide(300);
			else
				alert('Неизвестная ошибка!');
		});
	}
	function removeAdmin(element) {
		let adminId = element.getAttribute('id');
		$.post("./functions/access_func.php", {adminId: adminId}, function(data) {
			if(data == true)
				$('tr[id="'+adminId+'"]').hide(300);
			else
				alert('Неизвестная ошибка!');
		});
	}
	function promoteAdmin(element) {
		let adminPromoteId = element.getAttribute('id');
		$.post("./functions/access_func.php", {adminPromoteId: adminPromoteId}, function(data) {
			if(data == true) {
				$('td[name="'+adminPromoteId+'"]').text('Руководитель');
				$('td[class="demote"][id="'+adminPromoteId+'"]').show();
				$('td[class="promote"][id="'+adminPromoteId+'"]').hide();
			}
			else
				alert('Неизвестная ошибка!');
		});
	}
	function demoteAdmin(element) {
		let adminDemoteId = element.getAttribute('id');
		$.post("./functions/access_func.php", {adminDemoteId: adminDemoteId}, function(data) {
			if(data == true) {
				$('td[name="'+adminDemoteId+'"]').text('Администратор');
				$('td[class="promote"][id="'+adminDemoteId+'"]').show();
				$('td[class="demote"][id="'+adminDemoteId+'"]').hide();
			}
			else
				alert('Неизвестная ошибка!');
		});
	}
	$('td[class="promote"]').each(function() {
		let elementId = this.getAttribute('id');
		let adminRang = $('td[name="'+elementId+'"').text();
		if(adminRang == 'Руководитель')
			$(this).hide();
	});
	$('td[class="demote"]').each(function() {
		let elementId = this.getAttribute('id');
		let adminRang = $('td[name="'+elementId+'"').text();
		if(adminRang == 'Администратор')
			$(this).hide();
	});
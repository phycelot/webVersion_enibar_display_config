$(document).ready(function() {
	if (users_level > 0) {
		document.getElementById("send_message").disabled = false;
	}
})

$('#send_message').click(function() {
	text = '<div class="mdl-textfield mdl-js-textfield"><textarea class="mdl-textfield__input" type="text" rows= "3" id="message" ></textarea><label class="mdl-textfield__label" for="message">your message...</label></div>';
	showDialog({
		title: 'send message',
		text: text,
		negative: {
			title: 'abort'
		},
		positive: {
			title: 'send',
			onClick: function() {
				message = document.getElementById("message").value;
				if (message.length > 0) {
					url_ = "api_ajax?action=send_message&message=" + message;
					$.ajax({
						type: "GET",
						url: url_,
						success: function(data) {
							notification.MaterialSnackbar.showSnackbar({
								message: "message send successefully"
							});
						}
					})
				} else {
					notification.MaterialSnackbar.showSnackbar({
						message: "no text"
					});
				}

			}
		}
	});
})

$('#reboot').click(function() {
	$.ajax({
		type: "GET",
		url: "api_ajax?action=reboot",
		success: function(data) {
			notification.MaterialSnackbar.showSnackbar({
				message: "forced reboot successefully asked"
			});
		}
	})
})

$('#bug_report').click(function() {
	text = '<div class="mdl-textfield mdl-js-textfield"><input class="mdl-textfield__input" type="text" id="bug_report_dialog_title"><label class="mdl-textfield__label" for="bug_report_dialog_title">Titre</label></div>\<br><div class="mdl-textfield mdl-js-textfield"><textarea class="mdl-textfield__input" type="text" rows= "2" id="bug_report_dialog_text" ></textarea><label class="mdl-textfield__label" for="bug_report_dialog_text">Description (la plus precise possible)</label></div>';
	showDialog({
		title: 'bug report',
		text: text,
		negative: {
			title: 'abort'
		},
		positive: {
			title: 'send',
			onClick: function() {
				url_ = 'api_ajax?action=bug_report&title=' + $('#bug_report_dialog_title').val() + '&text=' + $('#bug_report_dialog_text').val() + '';
				console.log(url_);
				$.ajax({
					type: "GET",
					url: url_,
					dataType: "html",
					success: function(response) {
						json_response = JSON.parse(response);
						console.log(json_response);
						if (json_response.result == "true") {
							message = "sucess";
							notification.MaterialSnackbar.showSnackbar({
								message: message
							});
						} else {
							console.log($('#bug_report_dialog_text').val());
							message = "fail (text dans la console)";
							notification.MaterialSnackbar.showSnackbar({
								message: message
							});
						}
					},
					error: function(response) {
						console.error(response);
					}
				});
			}
		}
	});
})

$('#disconnect').click(function() {
	$.ajax({
		type: "GET",
		url: "api_ajax?action=disconnect",
		success: function(data) {
			location.reload();
		}
	})
})
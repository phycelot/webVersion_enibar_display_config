var notification = document.querySelector('.mdl-js-snackbar');
var eventEditID;
var eventAdd = {};
eventAdd.bouffe = [];
eventAdd.boisson = [];
var eventEdit = {};
eventEdit.bouffe = [];
eventEdit.boisson = [];

$('#config-event').click(function() {
	showEventList();
})

function maj_edit_default_length(id) {
	$.ajax({
		type: "GET",
		url: "api_ajax?action=edit_default_length_info&id=" + id,
		dataType: "html",
		success: function(response) {
			json = JSON.parse(response)[0];
			text = '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">default length <input value=' + json.type_default_length + ' class="mdl-textfield__input" type="number" id="number_type_default_length"></div>' +
				'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">default length extended<input value=' + json.type_default_length_extended + ' class="mdl-textfield__input" type="number" id="number_type_default_length_extended"></div>';
			showDialog({
				title: 'set default length',
				text: text,
				negative: {
					title: 'abord'
				},
				positive: {
					title: 'yes',
					onClick: function() {
						url_ = "api_ajax?action=set_default_length_info&id=" + id + "&default_length=" + $("#number_type_default_length").val() + '&default_length_extended=' + $("#number_type_default_length_extended").val();
						$.ajax({
							type: "GET",
							url: url_,
							dataType: "html",
							success: function(response) {
								json_response = JSON.parse(response);
								message = json_response.message;
								notification.MaterialSnackbar.showSnackbar({
									message: message
								});
								show_edit_default_length_in();
							},
							error: function(response) {
								console.error(response);
							}

						});
					}
				}
			});
		},
		error: function(response) {
			console.error(response);
		}
	});
}

function show_edit_default_length_in(){
	$.ajax({
				type: "GET",
				url: "api_ajax?action=edit_default_length_info",
				dataType: "html",
				success: function(response) {
					json = JSON.parse(response);
					toShow = '(click for detail)<div class="table_input_default_time"><table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"><thead><tr><th>Type</th><th class="in_input_default_time">default(h)</th><th class="in_input_default_time">extended(h)</th></tr></thead><tbody>';
					for (var index = 0; index < json.length; index++) {
						var element = json[index];
						toShow += '<tr onclick="maj_edit_default_length(' + element.type_id + ')"><td class="mdl-data-table__cell--non-numeric">' + element.type_showName + '</td>' +
							'<td class="">' + element.type_default_length + '</td>' +
							'<td class="">' + element.type_default_length_extended + '</div></td></tr>';
					}
					toShow += '</tbody></table></div>';
					$('#edit_default_length_in').html(toShow);

				},
				error: function(response) {
					console.error(response);
				}
			});
}

function updateByUsersLevel(level) {
	if (level == 1) {
		// do smth
	} else if (level => 2) {
		document.getElementById("show-settings").disabled = false;
		$("#settings_event_in").html('<button id="clean_events" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect"><i class="material-icons">keyboard_arrow_right</i> clean events</button></br>' +
			'<button id="edit_default_length" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect"><i class="material-icons">keyboard_arrow_right</i> edit default length</button>' +
			'<div id="edit_default_length_in"></div>' +
			'</br><button id="" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" disabled><i class="material-icons">keyboard_arrow_right</i>Add new event</button></br>');
		$('#edit_default_length').click(function() {
			$("#edit_default_length_in").toggle();
			show_edit_default_length_in();
		})
		$('#clean_events').click(function() {
			showDialog({
				title: 'DELETE ALL EVENTS',
				negative: {
					title: 'NO'
				},
				positive: {
					title: 'YES',
					onClick: function() {
						$.ajax({
							type: "GET",
							url: "api_ajax?action=clean_events",
							dataType: "html",
							success: function(response) {
								notification.MaterialSnackbar.showSnackbar({
									message: "success clean_events"
								});
							},
							error: function(response) {
								notification.MaterialSnackbar.showSnackbar({
									message: "fail clean_events"
								});
								console.error("fail clean_events");
							}
						});
					}
				}
			});
		});
	}
}

updateByUsersLevel(users_level);

$("#eventlist_search").on("change keyup paste", function() {
	show_list();
})

$('#eventlist_searchDate').change(function() {
	show_list();
});

$('#eventlist_searchType').change(function() {
	show_list();
});

function showEventAdd() {
	// 	console.log(eventAdd);
}

$(document).ready(function() {
	updateEventSelector();
	$("#edit_default_length_in").toggle();
});

function showEventList() {
	showLoading();
	$.ajax({ //create an ajax request to load_page.php
		type: "GET",
		url: "api_ajax?action=main_list_event",
		dataType: "html", //expect html to be returned                
		success: function(response) {
			$("#list-near-event-list").html(response);
		},
		error: function() {
			$("#list-event-list").html('<p>fail to load the main list</p><button onClick="" class="mdl-button mdl-js-button mdl-js-ripple-effect">refresh<button>');
			console.error("fail to load the main load");
			//wip
		}

	});
	hideLoading();
}

function updateBouffeList_addon(item, index, arr) {
	$('#event-add-bouffe-list-tbody').append('<tr><td>' + arr[index].type + '</td><td><button class="mdl-button mdl-js-button mdl-button--icon" id="event-add-bouffe-info-' + index + '"><i class="material-icons">info</i></button><ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="event-add-bouffe-info-' + index + '"><p class="mdl-menu__item">unit: ' + arr[index].unit_price + '€</p><p class="mdl-menu__item">double: ' + arr[index].double_price + '€</p></ul><button class="mdl-button mdl-js-button mdl-button--icon" id="event-add-bouffe-edit-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">mode_edit</i></button><button class="mdl-button mdl-js-button mdl-button--icon" id="event-add-bouffe-delete-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">delete</i></button></td></tr>');
}

function updateBouffeList() {
	$('#event-add-bouffe-list-tbody').html("");
	eventAdd.bouffe.forEach(updateBouffeList_addon);
}

$('#event-add-bouffe-add').click(function() {
	text = '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' +
		'<input class="mdl-textfield__input" type="text" id="event-add-bouffe-type">' +
		'<label class="mdl-textfield__label" for="event-add-bouffe-type">type</label></div>' +
		'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' +
		'<input class="mdl-textfield__input" type="number" id="event-add-bouffe-unit_price">' +
		'<label class="mdl-textfield__label" for="event-add-bouffe-unit_price">unit price</label></div>' +
		'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' +
		'<input class="mdl-textfield__input" type="number" id="event-add-bouffe-double_price">' +
		'<label class="mdl-textfield__label" for="event-add-bouffe-double_price">double price (null if not)</label></div>';
	showDialog({
		title: 'chose bouffe',
		text: text,
		negative: {
			title: 'cancel'
		},
		positive: {
			title: 'add',
			onClick: function() {
				count = Object.keys(eventAdd.bouffe).length;
				double_price = document.getElementById("event-add-bouffe-double_price").value;
				if (double_price === "") {
					double_price = 0;
				}
				eventAdd.bouffe[count] = {
					'type': document.getElementById("event-add-bouffe-type").value,
					"unit_price": document.getElementById("event-add-bouffe-unit_price").value,
					"double_price": double_price
				};
				updateBouffeList();
			}
		}
	});
});

function updateBoissonList_addon(item, index, arr) {
	$('#event-add-boisson-list-tbody').append('<tr><td>' + arr[index].type + '</td><td><button class="mdl-button mdl-js-button mdl-button--icon" id="event-add-boisson-info-' + index + '"><i class="material-icons">info</i></button><ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="event-add-boisson-info-' + index + '"><p class="mdl-menu__item">unit: ' + arr[index].unit_price + '€</p><p class="mdl-menu__item">double: ' + arr[index].double_price + '€</p></ul><button class="mdl-button mdl-js-button mdl-button--icon" id="event-add-boisson-edit-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">mode_edit</i></button><button class="mdl-button mdl-js-button mdl-button--icon" id="event-add-boisson-delete-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">delete</i></button></td></tr>');
}

function updateBoissonList() {
	$('#event-add-boisson-list-tbody').html("");
	eventAdd.boisson.forEach(updateBoissonList_addon);
}

$('#event-add-boisson-add').click(function() {
	text = '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="event-add-boisson-type"><label class="mdl-textfield__label" for="event-add-boisson-type">type</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" id="event-add-boisson-unit_price"><label class="mdl-textfield__label" for="event-add-boisson-unit_price">unit price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" id="event-add-boisson-double_price"><label class="mdl-textfield__label" for="event-add-boisson-double_price">double price (null if not)</label></div>';
	showDialog({
		title: 'chose boisson',
		text: text,
		negative: {
			title: 'cancel'
		},
		positive: {
			title: 'add',
			onClick: function() {
				count = Object.keys(eventAdd.boisson).length;
				double_price2 = document.getElementById("event-add-boisson-double_price").value;
				if (double_price2 === "") {
					double_price2 = 0;
				}
				eventAdd.boisson[count] = {
					'type': document.getElementById("event-add-boisson-type").value,
					"unit_price": document.getElementById("event-add-boisson-unit_price").value,
					"double_price": double_price2
				};
				updateBoissonList();
			}
		}
	});
});

function updateEditBouffeList_addon(item, index, arr) {
	$('#event-edit-bouffe-list-tbody').append('<tr><td>' + arr[index].type + '</td><td><button class="mdl-button mdl-js-button mdl-button--icon" id="event-edit-bouffe-info-' + index + '"><i class="material-icons">info</i></button><ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="event-edit-bouffe-info-' + index + '"><p class="mdl-menu__item">unit: ' + arr[index].unit_price + '€</p><p class="mdl-menu__item">double: ' + arr[index].double_price + '€</p></ul><button class="mdl-button mdl-js-button mdl-button--icon" id="event-edit-bouffe-edit-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">mode_edit</i></button><button class="mdl-button mdl-js-button mdl-button--icon" id="event-edit-bouffe-delete-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">delete</i></button></td></tr>');
}

function updateEditBouffeList() {
	$('#event-edit-bouffe-list-tbody').html("");
	if (eventEdit.bouffe == null) {

	} else {
		eventEdit.bouffe.forEach(updateEditBouffeList_addon);
	}
}

$('#event-edit-bouffe-add').click(function() {
	text = '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' +
		'<input class="mdl-textfield__input" type="text" id="event-edit-bouffe-type">' +
		'<label class="mdl-textfield__label" for="event-edit-bouffe-type">type</label></div>' +
		'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' +
		'<input class="mdl-textfield__input" type="number" id="event-edit-bouffe-unit_price">' +
		'<label class="mdl-textfield__label" for="event-edit-bouffe-unit_price">unit price</label></div>' +
		'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">' +
		'<input class="mdl-textfield__input" type="number" id="event-edit-bouffe-double_price">' +
		'<label class="mdl-textfield__label" for="event-edit-bouffe-double_price">double price (null if not)</label></div>';
	showDialog({
		title: 'chose bouffe',
		text: text,
		negative: {
			title: 'cancel'
		},
		positive: {
			title: 'add',
			onClick: function() {
				double_price = document.getElementById("event-edit-bouffe-double_price").value;
				if (double_price === "") {
					double_price = 0;
				}
				count = Object.keys(eventEdit.bouffe).length;
				eventEdit.bouffe[count] = {
					'type': document.getElementById("event-edit-bouffe-type").value,
					"unit_price": document.getElementById("event-edit-bouffe-unit_price").value,
					"double_price": double_price
				}
				updateEditBouffeList();
			}
		}
	});
});

function updateEditBoissonList_addon(item, index, arr) {
	$('#event-edit-boisson-list-tbody').append('<tr><td>' + arr[index].type + '</td><td><button class="mdl-button mdl-js-button mdl-button--icon" id="event-edit-boisson-info-' + index + '"><i class="material-icons">info</i></button><ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="event-edit-boisson-info-' + index + '"><p class="mdl-menu__item">unit: ' + arr[index].unit_price + '€</p><p class="mdl-menu__item">double: ' + arr[index].double_price + '€</p></ul><button class="mdl-button mdl-js-button mdl-button--icon" id="event-edit-boisson-edit-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">mode_edit</i></button><button class="mdl-button mdl-js-button mdl-button--icon" id="event-edit-boisson-delete-' + index + '" onClick="updateShow(this.id);"><i class="material-icons">delete</i></button></td></tr>');
}

function updateEditBoissonList() {
	$('#event-edit-boisson-list-tbody').html("");
	if (eventEdit.boisson == null) {

	} else {
		eventEdit.boisson.forEach(updateEditBoissonList_addon);
	}
}

$('#event-edit-boisson-add').click(function() {
	text = '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="event-edit-boisson-type"><label class="mdl-textfield__label" for="event-edit-boisson-type">type</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" id="event-edit-boisson-unit_price"><label class="mdl-textfield__label" for="event-edit-boisson-unit_price">unit price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" id="event-edit-boisson-double_price"><label class="mdl-textfield__label" for="event-edit-boisson-double_price">double price (null if not)</label></div>';
	showDialog({
		title: 'chose boisson',
		text: text,
		negative: {
			title: 'cancel'
		},
		positive: {
			title: 'add',
			onClick: function() {
				count = Object.keys(eventEdit.boisson).length;
				double_price2 = document.getElementById("event-edit-boisson-double_price").value;
				if (double_price2 === "") {
					double_price2 = 0;
				}
				eventEdit.boisson[count] = {
					'type': document.getElementById("event-edit-boisson-type").value,
					"unit_price": document.getElementById("event-edit-boisson-unit_price").value,
					"double_price": double_price2
				};
				updateEditBoissonList();
			}
		}
	});
});

function show_list() {
	showLoading();
	eventTypeID = document.getElementById("eventlist_searchType").value;
	search = document.getElementById("eventlist_search").value;
	date = document.getElementById("eventlist_searchDate").value;
	_url = "api_ajax?action=update_list";
	if (eventTypeID > 0) {
		_url += "&typeID=" + eventTypeID;
	}
	if (search.length > 0) {
		_url += "&search=" + search;
	}
	if (date.length > 0) {
		_url += "&date=" + date;
	}
	$("#list-event-list").html("<p>Loading</p>");
	$.ajax({ //create an ajax request to load_page.php
		type: "GET",
		url: _url,
		dataType: "html", //expect html to be returned                
		success: function(response) {
			$("#list-event-list").html(response);
			win = 1;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$("#list-event-list").html('<p>fail to load the main list</p><button onClick="show_list();" class="mdl-button mdl-js-button mdl-js-ripple-effect">refresh<button>');
			message = 'fail to acces show_list, try to refresh your page';
			notification.MaterialSnackbar.showSnackbar({
				message: message
			});
		}
	});
	hideLoading();
}

$("#show-list").click(function() {
	show_list();
});

$('#event-add-raz').click(function() {
	clear('clearAddEvent');
});

$('#event-edit-raz').click(function() {
	clear('clearEditEvent');
});

function event_save_add() {
	type_event = document.getElementById("event-type-selector-add").value;
	theme = document.getElementById("event-theme-add").value;
	date = document.getElementById("event-date-add").value;
	detail = document.getElementById("event-detail-add").value;
	isBeerPong = document.getElementById("checkbox-beer-pong-add").checked;
	isExtension = document.getElementById("checkbox-extension-add").checked;
	isVisible = document.getElementById("checkbox-visible-add").checked;
	if (type_event < 0) {
		notification.MaterialSnackbar.showSnackbar({
			message: 'pas de type d\'event'
		});
	} else if (!date) {
		notification.MaterialSnackbar.showSnackbar({
			message: 'pas de date'
		});
	} else {
		url_ = "api_ajax?action=new_event&type_event=" + type_event + "&date=" + date;
		if (theme) {
			url_ += "&theme=" + theme;
		}
		if (detail) {
			url_ += "&detail=" + detail;
		}
		if (isBeerPong) {
			url_ += "&isBeerPong=" + isBeerPong;
		}
		if (isExtension) {
			url_ += "&isExtension=" + isExtension;
		}
		if (isVisible) {
			url_ += "&isVisible=" + isVisible;
		}
		url_ += "&json=" + JSON.stringify(eventAdd);
		$.ajax({
			url: url_,
			type: 'GET',
			success: function() {
				notification.MaterialSnackbar.showSnackbar({
					message: 'success'
				});
			},
			error: function(jqXHR, textStatus, errorThrown) {
				notification.MaterialSnackbar.showSnackbar({
					message: 'fail'
				});
			},
			datatype: 'html'
		});

	}
}

$("#event-save-add").click(function() {
	event_save_add();
});

$("#event-save-add2").click(function() {
	event_save_add();
});

function event_save_edit() {
	type_event = document.getElementById("event-type-selector-edit").value;
	theme = document.getElementById("event-theme-edit").value;
	date = document.getElementById("event-date-edit").value;
	detail = document.getElementById("event-detail-edit").value;
	isBeerPong = document.getElementById("checkbox-beer-pong-edit").checked;
	isExtension = document.getElementById("checkbox-extension-edit").checked;
	isVisible = document.getElementById("checkbox-visible-edit").checked;
	if (type_event < 0) {
		notification.MaterialSnackbar.showSnackbar({
			message: 'pas de type d\'event'
		});
	} else if (!date) {
		notification.MaterialSnackbar.showSnackbar({
			message: 'pas de date'
		});
	} else {
		url_ = "api_ajax?action=edit_event&type_event=" + type_event + "&date=" + date;
		if (theme) {
			url_ += "&theme=" + theme;
		}
		if (detail) {
			url_ += "&detail=" + detail;
		}
		if (isBeerPong) {
			url_ += "&isBeerPong=" + isBeerPong;
		}
		if (isExtension) {
			url_ += "&isExtension=" + isExtension;
		}
		if (isVisible) {
			url_ += "&isExtension=" + isVisible;
		}
		url_ += "&event_id=" + eventEditID;
		url_ += "&json=" + JSON.stringify(eventEdit);
// 		console.log(url_);
		$.ajax({
			url: url_,
			type: 'GET',
			success: function(response) {
// 				console.log(response);
				notification.MaterialSnackbar.showSnackbar({
					message: 'success'
				});
				// clear les div au dessus et revenir au menu, et actualiser les listes affiché
			},
			error: function(jqXHR, textStatus, errorThrown) {
				notification.MaterialSnackbar.showSnackbar({
					message: 'fail'
				});
				console.log(textStatus, errorThrown);
			},
			datatype: 'html'
		});
	}
}

$("#event-save-edit").click(function(e) {
	event_save_edit();
});

$("#event-save-edit2").click(function(e) {
	event_save_edit();
});

function updateEventSelector() {
	$.ajax({
		type: "GET",
		url: "api_ajax?action=update_type_list",
		dataType: "html", //expect html to be returned                
		success: function(response) {
			$("#event-type-selector-add").html(response);
			$("#event-type-selector-edit").html(response);
			$("#eventlist_searchType").html(response);
		}

	});
}

function updateEventEdit(event_id) {
	eventEditID = event_id;
	url_ = "api_ajax?action=get_event_edit_info&event_id=" + event_id;
	$.ajax({
		type: "GET",
		url: url_,
		dataType: "html",
		success: function(response) {
			jsonResponse = JSON.parse(response);
			type_id = jsonResponse.type_id;
			theme = jsonResponse.theme;
			date = jsonResponse.date;
			detail = jsonResponse.detail;
			extension = jsonResponse.extension;
			beerPong = jsonResponse.beerPong;
			visible = jsonResponse.visible;
			if (jsonResponse.bouffe == null) {
				eventEdit.bouffe = [];
			} else {
				eventEdit.bouffe = jsonResponse.bouffe;
			}
			if (jsonResponse.boisson == null) {
				eventEdit.boisson = [];
			} else {
				eventEdit.boisson = jsonResponse.boisson;
			}
			updateEditBouffeList();
			updateEditBoissonList();
			document.getElementById("event-type-selector-edit").value = type_id;
			if (theme !== null) {
				$("#event-theme-edit").val(theme).parent().addClass('is-focused');
			}
			document.getElementById("event-date-edit").value = date;
			if (detail !== null) {
				$("#event-detail-edit").val(detail).parent().addClass('is-focused');
			}
			if (beerPong == 1) {
				$('.edit-event-checkbox-beer-pong').each(function(index, element) {
					element.MaterialCheckbox.check();
				});
			} else {
				$('.edit-event-checkbox-beer-pong').each(function(index, element) {
					element.MaterialCheckbox.uncheck();
				});
			}
			if (extension == 1) {
				$('.edit-event-checkbox-extension').each(function(index, element) {
					element.MaterialCheckbox.check();
				});
			} else {
				$('.edit-event-checkbox-extension').each(function(index, element) {
					element.MaterialCheckbox.uncheck();
				});
				}
			if (visible == 1) {
				$('.edit-event-checkbox-visible').each(function(index, element) {
					element.MaterialCheckbox.check();
				});
			} else {
				$('.edit-event-checkbox-visible').each(function(index, element) {
					element.MaterialCheckbox.uncheck();
				});
			}
		}
	});
}

function updateShow(id) {
	if (!id.search('event-add-bouffe-delete-')) {
		bouffeToDelete = id.slice(24);
		delete eventAdd.bouffe[bouffeToDelete];
		updateBouffeList();
	} else
	if (!id.search('event-edit-bouffe-delete-')) {
		bouffeToDelete = id.slice(25);
		delete eventEdit.bouffe[bouffeToDelete];
		updateEditBouffeList();
	} else
	if (!id.search('event-add-bouffe-edit-')) {
		bouffeToEdit = id.slice(22);
		//wip
		updateBouffeList();
	} else
	if (!id.search('event-add-boisson-delete-')) {
		boissonToDelete = id.slice(25);
		delete eventAdd.boisson[boissonToDelete];
		updateBoissonList();
	} else
	if (!id.search('event-edit-boisson-delete-')) {
		boissonToDelete = id.slice(26);
		delete eventEdit.boisson[boissonToDelete];
		updateEditBoissonList();
	} else
	if (!id.search('event-add-boisson-edit-')) {
		boissonToEdit = id.slice(22);
		//wip
		updateBoissonList();
	} else if (!id.search('list-event')) {
		event_id = id.slice(11);
		url_ = "api_ajax?action=detail_event_return_text&id=" + event_id;
		$.ajax({
			type: "GET",
			url: url_,
			dataType: "html",             
			success: function(response) {
				$(document).ready(function() {
					showDialog({
						title: 'Detail event',
						text: response,
						neutral: {
							title: 'ok'
						},
						negative: {
							title: 'delete',
							onClick: function() {
								url_='api_ajax?action=delete_event&event_id='+event_id;
								$.ajax({
									type: "GET",
									url: url_,
									dataType: "html",
									success: function(response) {
										json_response = JSON.parse(response);
										message = json_response.message;
										notification.MaterialSnackbar.showSnackbar({
											message: message
										});
										if (json_response.result == "true") {
											showEventList();
											show_list();
										}
									},
									error: function(response) {
										console.error(response);
									}
								});
							}
						},
						positive: {
							title: 'edit',
							onClick: function() {
								document.getElementById("edit-event").classList.remove('close');
								document.getElementById("save_edit_button").classList.remove('close');
								document.getElementById("list-near-event").classList.add('close');
								document.getElementById("list-event").classList.add('close');
								clear('clearEditEvent');
								updateEventEdit(event_id);
							}
						}
					});

				});
			},
			error: function(jqXHR, textStatus, errorThrown) {
				notification.MaterialSnackbar.showSnackbar({
					message: 'fail get event detail on click'
				});
				console.error(textStatus, errorThrown);
			}

		});

	} else if (!id.search('show')) {
		show_id = id.slice(5);
		if (show_id == "info") {} else {
			to_show_id = show_id + "-event";
			document.getElementById(to_show_id).classList.remove('close');
			document.getElementById("list-near-event").classList.add('close');
			if (show_id == "add") {
				document.getElementById("save_add_button").classList.remove('close');
			}
		}
	} else if (!id.search("cancel")) {
		unshow_id = id.slice(7);
		if (unshow_id == "info") {} else {

			to_unshow_id = unshow_id + "-event";
			if ((unshow_id == "edit") || (unshow_id == "add")) {
				clear(to_unshow_id);
			}
			if (unshow_id == "add") {
				document.getElementById("save_add_button").classList.add('close')
			}
			if (unshow_id == "edit") {
				document.getElementById("save_edit_button").classList.add('close')
			}
			document.getElementById(to_unshow_id).classList.add('close');
			document.getElementById("list-near-event").classList.remove('close');
			showEventList();
		}
	}
}

function clear(clearOption) { //wip manque le refresh des input text
	if (clearOption == 'clearAddEvent') {
		document.getElementById("event-type-selector-add").value = -1;
		document.getElementById("event-theme-add").value = '';
		document.getElementById("event-date-add").value = '';
		document.getElementById("event-detail-add").value = '';
		$("#checkbox-beer-pong-add").prop("checked", false);
		$("#checkbox-extension-add").prop("checked", false);
		eventAdd.boisson = [];
		eventAdd.bouffe = [];
		updateBouffeList();
		updateBoissonList();
		$('.add-event-checkbox').each(function(index, element) {
			element.MaterialCheckbox.uncheck();
		});
	} else if (clearOption == 'clearEditEvent') {
		document.getElementById("event-type-selector-edit").value = -1;
		document.getElementById("event-theme-edit").value = '';
		document.getElementById("event-date-edit").value = '';
		document.getElementById("event-detail-edit").value = '';
		eventEdit.boisson = [];
		eventEdit.bouffe = [];
		updateEditBouffeList();
		updateEditBoissonList();
		$('.edit-event-checkbox').each(function(index, element) {
			element.MaterialCheckbox.uncheck();
		});
	} else if (clearOption == ' ') {

	} else if (clearOption == ' ') {

	} else if (clearOption == ' ') {

	} else if (clearOption == ' ') {

	}
}

$('#show-info').click(function() {
	showDialog({
		title: 'Info',
		text: "Cette fenetre permet d'acceder aux events, de les modifier ou d'en ajouter.\nEt oui y'a pas d'aide, c'est simple à comprendre",
		negative: {
			title: 'Close'
		}
	});
});
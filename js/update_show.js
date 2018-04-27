window.onload = function() {
	var date = new Date();
	pageLoadTime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();

	function reboot() {
		window.location.reload(false)
	}

	function isRebootAsked() {
		url_ = 'api_ajax?action=isRebootAsked&pageLoadTime="' + pageLoadTime + '"';
		$.ajax({
			type: "GET",
			url: url_,
			dataType: "html",
			success: function(response) {
				array = JSON.parse(response);
				if (array.result == 'true') {
					hidePage();
					setTimeout(reboot, 600);

				}
			},
			error: function(response) {
				console.error(response);
			}
		});
	}

	var actualMeteo, infoMeteo, API, current_condition_key;

	function updateMeteoData(argument) {
		API = 'http://www.prevision-meteo.ch/services/json/Plouzan%C3%A9';
		$.getJSON(API, function(jsonMeteo) {
			if (current_condition_key != jsonMeteo.current_condition.condition_key) {
				current_condition_key = jsonMeteo.current_condition.condition_key;
				actualMeteo = jsonMeteo.current_condition.condition + " " + jsonMeteo.current_condition.tmp + "°C";
				infoMeteo = "Aujourd'hui : " + jsonMeteo.fcst_day_0.condition + ", min : " + jsonMeteo.fcst_day_0.tmin + "°C, max : " + jsonMeteo.fcst_day_0.tmax + "°C </br>Demain : " + jsonMeteo.fcst_day_1.condition + ", min : " + jsonMeteo.fcst_day_1.tmin + "°C, max : " + jsonMeteo.fcst_day_1.tmax + "°C";
				document.getElementById('actualMeteo').innerHTML = actualMeteo;
				document.getElementById('infoMeteo').innerHTML = infoMeteo;
			}

		});
	}

	function updateMeteoIcon(argument) {
		$.getJSON('./json/lien-meteo-png.json', function(jsonLinkWeatherIcon) {
			for (var i in jsonLinkWeatherIcon.meteo_image) {
				if (jsonLinkWeatherIcon.meteo_image[i].key == current_condition_key) {
					document.getElementById("meteo-icon-card").style.backgroundImage = 'url(image/meteo/' + jsonLinkWeatherIcon.meteo_image[i].image_code + '.png)';
				}
			}
		});
	}

	function updateMeteo() {
		updateMeteoIcon();
		updateMeteoData();

	}

	var numday, month, numyear, numhours, numminutes, numseconds, nowtoday;

	function initdate() {
		var now = new Date();

		numday = now.getDate();
		nummonth = now.getMonth();
		month = nummonth + 1;
		numyear = now.getFullYear();
		numhours = now.getHours();
		numminutes = now.getMinutes();
		numseconds = now.getSeconds();
		if (numday < 10) {
			numday = "0" + numday;
		}
		if (month < 10) {
			month = "0" + month;
		}
		if (numhours < 10) {
			numhours = "0" + numhours;
		}
		if (numminutes < 10) {
			numminutes = "0" + numminutes;
		}
		if (numseconds < 10) {
			numseconds = "0" + numseconds;
		}
	}

	function parsedate() {
		numseconds++;
		if (numseconds < 10) {
			numseconds = "0" + numseconds;
		}
		if (numseconds >= 60) {
			numseconds = "00";
			numminutes++;
			if (numminutes < 10) {
				numminutes = "0" + numminutes;
			}
		}
		if (numminutes >= 60) {
			numminutes = "00";
			numhours++;
			if (numhours < 10) {
				numhours = "0" + numhours;
			}
		}
		if (numhours >= 24) {
			numhours = "00";
			initdate();
		}
		// AFFICHAGE DU COUPLE DATE/HEURE
		nowtoday = "" + numhours + ":" + numminutes + ":" + numseconds + "";
		nowtoday =
			nowtoday += " -- ";
		nowtoday += numday + "/" + month + "/" + numyear + "";
		document.getElementById('datetime').innerHTML = nowtoday;
	}


	var refreshTime = 0;
	function get_affichage() {

		url_ = 'api_ajax?action=get_config_affichage&actual';
		$.ajax({
			type: "GET",
			url: url_,
			dataType: "html",
			success: function(response) {
// 				console.log(response);
				json_response = JSON.parse(response);
				update_show_screen_conso(json_response.affichageConfig);
			},
			error: function(response) {
				console.error(response);
			}
		});
		url_ = 'api_ajax?action=get_event_list_affichage';
		$.ajax({
			type: "GET",
			url: url_,
			dataType: "html",
			success: function(response) {
// 				console.log(response);
				json_response = JSON.parse(response);
// 				console.log(json_response);
				update_show_screen_event(json_response);
			},
			error: function(response) {
				console.error(response);
			}
		});
	}

	function globalInit() {
		initdate();
		parsedate();
		get_affichage();
		updateMeteo();
	}
	globalInit();

	function updateFunction() {
		updateMeteo();
		++refreshTime;
		parsedate();
		isRebootAsked();
		if ((refreshTime % 60) === 0) { //toutes les minutes
						get_affichage();
		}
		if ((refreshTime % 2) === 0) { //toutes les 2 secondes
		}
		if (refreshTime > 600) { //toutes les 6 minutes
			initdate();
			refreshTime = 0;
		}
	}
	window.setInterval(updateFunction, 1000);
}
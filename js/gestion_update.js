window.onload = function() {
	var actualMeteo, infoMeteo, API, current_condition_key;

	function updateMeteoData(argument) {
		API = 'http://www.prevision-meteo.ch/services/json/Plouzan%C3%A9';
		$.getJSON(API, function(jsonMeteo) {
			console.log("lecture meteo");
			current_condition_key = jsonMeteo.current_condition.condition_key;
			actualMeteo = jsonMeteo.current_condition.condition + " " + jsonMeteo.current_condition.tmp + "°C";
			infoMeteo = "Today : " + jsonMeteo.fcst_day_0.condition + ", min : " + jsonMeteo.fcst_day_0.tmin + "°C, max : " + jsonMeteo.fcst_day_0.tmax + "°C </br>Tomorrow : " + jsonMeteo.fcst_day_1.condition + ", min : " + jsonMeteo.fcst_day_1.tmin + "°C, max : " + jsonMeteo.fcst_day_1.tmax + "°C";
			document.getElementById('actualMeteo').innerHTML = actualMeteo;
			document.getElementById('infoMeteo').innerHTML = infoMeteo;
		});
	}

	function updateMeteoIcon(argument) {
		console.log("updateMeteoIcon");
		$.getJSON('./json/lien-meteo-png.json', function(jsonLinkWeatherIcon) {
			console.log("lecture lien-meteo-png");
			for (var i in jsonLinkWeatherIcon.meteo_image) {

				if (jsonLinkWeatherIcon.meteo_image[i].key == current_condition_key) {
					console.log(jsonLinkWeatherIcon.meteo_image[i].key + "=" + current_condition_key);
					console.log(jsonLinkWeatherIcon.meteo_image[i].image_code);

					document.getElementById("meteo-card").style.backgroundImage = 'url(image/meteo/' + jsonLinkWeatherIcon.meteo_image[i].image_code + '.png)';
				}
			}
			console.log("end-lien-meteo-png")
		})
		;
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
		nowtoday = "" + numday + "/" + month + "/" + numyear;
		nowtoday += " -- ";
		nowtoday += numhours + ":" + numminutes + ":" + numseconds + "";
		document.getElementById('dateheure').innerHTML = nowtoday;
	}
	initdate();
	parsedate();
	var refreshMeteoTime = 0;

	function updateFunction() {
		++refreshMeteoTime;
		parsedate();
		console.log(refreshMeteoTime);
		if (refreshMeteoTime > 6) {
			updateMeteo();
			refreshMeteoTime = 0;
		}
	}
	window.setInterval(updateFunction, 1000); //auto-refresh la meteo
	updateMeteo();
	updateFunction();
}
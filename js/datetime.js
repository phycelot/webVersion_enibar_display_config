window.onload = function() {
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
		//console.log("parsedate");
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
		console.log(nowtoday);
		document.getElementById('datetime').innerHTML = nowtoday;
	}


	var refreshTime = 0;

	function updateFunction() {
		// console.log("updateFunction");
		++refreshTime;
		parsedate();
		// console.log(refreshTime);
		if ((refreshTime % 60) === 0) { //toutes les minutes

		}
		if ((refreshTime % 2) === 0) { //toutes les 2 secondes
		}
		if (refreshTime > 600) { //toutes les 6 minutes
			initdate();
			refreshTime = 0;
		}
	}

	function globalInit() {
		initdate();
		parsedate();
	}
	globalInit();
	window.setInterval(updateFunction, 1000); //auto-refresh des fonctions séléctionnées

}
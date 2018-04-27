<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <title>Afficheur cafet alpha 1.0</title>
  <link rel="stylesheet" href=".css/show_loader.css">
  <link rel="stylesheet" href=".css/show.css">
  <link rel="stylesheet" href=".css/snackbar.css">
  <link rel="icon" href=".image/enibar.png" />
</head>

<body>
  <div id="theater1" class="theater1"></div>
  <div id="theater2" class="theater2"></div>
  <div class='datetime_card'>
    <div id="datetime" class='datetime'></div>
  </div>
  <div id="info" class='info'>
    <div id='info_text' class="info_text">BAROMETRE</div>
  </div>
  <div id='meteo-card' class='meteo-card'>
<!--     <div class='meteo-icon-card' style="background-image: url('image/enibar.png');"></div> -->
    <div class='meteo-icon-card' style=""></div>
    <div id='meteo-icon-card' class='meteo-icon-card'></div>
    <div id='meteo_text' class='meteo_text'>
      <div id='actualMeteo' class=''></div>
      <div id='infoMeteo' class=''></div>
    </div>
  </div>
  <div id="page_body" class='page_body'>
    <div id='events' class='events'>
    </div>
    <div id='consos' class='consos'></div>
  </div>
  <div id='down-band' class='down_band scroll-right'>
    <p id="scrolling_band_text">Soirée à thème Pirates le 16 décembre</p>
  </div>
  <div id='snackbar' class='snackbar'></div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="./js/update_show_screen.js"></script>
<script src="./js/show_loader.js"></script>
<script src="./js/update_show.js"></script>
<script src="./js/snackbar.js"></script>
<!-- <div id='' class=''></div> -->
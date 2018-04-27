<!doctype html>
  <?php 
  date_default_timezone_set('Europe/Paris'); setlocale(LC_TIME, "fr_FR.UTF8");// pour forcer l'affichage heure française

  //recuperation de la meteo
  $info_meteo = file_get_contents('http://www.prevision-meteo.ch/services/json/Plouzan%C3%A9');
  $info_meteo = json_decode($info_meteo);

  //recuperation du json
  $jsonString = file_get_contents('./json/info.json');
  $data = json_decode($jsonString, true);
  $mode = $data["settings"]["mode"];

  ?>

  <html lang="fr">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>barometre</title>

      <!-- Material Design Lite CSS -->
      <script src="https://storage.googleapis.com/code.getmdl.io/1.0.2/material.min.js"></script>
      <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css" /> 
      <!-- Font Awesome CSS -->
      <!--link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"-->

      <!-- Page styles -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=fr">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.min.css">
      <!-- <link rel="stylesheet" href=".css/snackbar.css"> -->
      <link rel="stylesheet" href=".css/styles.css">
      <link rel="stylesheet" href=".css/style_heure.css">
      <link rel="stylesheet" href=".css/cards.css">
      <link rel="icon" href=".image/enibar.png" /> 
    </head>
    <body>
      <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

        <div class="mdl-layout__header mdl-layout__header--waterfall">
          <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">ENIBAR
            </span>
            <!-- Add spacer, to align navigation to the right in desktop -->
            <div class="mdl-layout-spacer"></div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width">
            </div>
            <!-- Navigation -->
            <div class="">
              <nav class="">
                <div id="dateheure" class="date_heure_up">42</div>
                
              </nav>
            </div>
          </div>
        </div>
        <div class="drawer mdl-layout__drawer">
          <span class="mdl-layout-title">Settings
          </span>
          <nav class="mdl-navigation">
          <form id="formulaire">
          <div class="drawer-separator2"></div>
            <div class="mdl-navigation__link" href="">Mode</div>
            <span a class="mdl-navigation__link" href="">
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="normal">
                <input type="radio" id="normal" class="mdl-radio__button" name="options" value="0" onChange="testUpdate('normal');" <?php if($mode==0){echo "checked";} ?> >
                <span class="mdl-radio__label">Normal</span>
              </label>
            </span>
            <span class="mdl-navigation__link" href="">
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="apero">
                <input type="radio" id="apero" class="mdl-radio__button" name="options" value="1" onChange="testUpdate('apero');" <?php if($mode==1){echo "checked";} ?>>
                <span class="mdl-radio__label">Apero</span>
              </label>
            </span>
            <span class="mdl-navigation__link" href="">
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="nolimit">
                <input type="radio" id="nolimit" class="mdl-radio__button" name="options" value="2" onChange="testUpdate('nolimit');" <?php if($mode==2){echo "checked";} ?>>
                <span class="mdl-radio__label">No-Limit</span>
              </label>
            </span>
            
            <div class="drawer-separator2"></div>
            <span class="mdl-navigation__link" href="">Details</span>
            <!-- -->
            <div <?php if($mode==0){echo "class='ferme'";} ?> id="theme">
            <span class="mdl-navigation__link" href="">
              <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="themeSwitch">
                <input type="checkbox" id="themeSwitch" class="mdl-switch__input" name="themeSwitch" onChange="updateShow();" <?php if($data["settings"]["switch"]["theme"]['value']==1){echo "checked";} ?>>
                <span class="mdl-switch__label">Thème</span>
              </label>
              <div <?php if ($data["settings"]["switch"]["theme"]["value"]==0) {echo 'class="ferme"';} ?> id="themeStuff">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="nomtheme" name="nomtheme" value=<?php echo $data["settings"]["switch"]["theme"]['text'];?>>
                  <label class="mdl-textfield__label" for="nomtheme">Nom</label>
                </div>
              </div>
            </span>
            </div>
            <!-- -->
            <div <?php if($mode==0){echo "class='ferme'";} ?> id="bouffe">
            <div class="drawer-separator"></div>
            <span class="mdl-navigation__link" href="">
              <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="bouffeSwitch">
                <input type="checkbox" id="bouffeSwitch" class="mdl-switch__input" name="bouffeSwitch" onChange="updateShow();" <?php if($data["settings"]["switch"]["bouffe"]['value']==1){echo "checked";} ?>>
                <span class="mdl-switch__label">Bouffe</span>
              </label>
              <div <?php if ($data["settings"]["switch"]["bouffe"]["value"]==0) {echo 'class="ferme"';} ?> id="bouffeStuff">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="bouffeType" name="bouffeType" value=<?php echo $data["settings"]["switch"]["bouffe"]['type'];?>>
                  <label class="mdl-textfield__label" for="bouffeType">type</label>
                </div>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="bouffeIsPromoFor2">
                  <input type="checkbox" id="bouffeIsPromoFor2" class="mdl-checkbox__input" name="bouffeIsPromoFor2" <?php if($data["settings"]["switch"]["bouffe"]['diffpour2']==1){echo "checked";} ?>>
                  <span class="mdl-checkbox__label">Promo pour 2 ?</span>
                </label>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="number" step="0.01" id="bouffePriceUnit" name="bouffePriceUnit" value=<?php echo $data["settings"]["switch"]["bouffe"]['price'];?>>
                  <label class="mdl-textfield__label" for="bouffePriceUnit">Prix unitaire</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="number" step="0.01" id="bouffePriceFor2" name="bouffePriceFor2" value=<?php echo $data["settings"]["switch"]["bouffe"]['pricefor2'];?>>
                  <label class="mdl-textfield__label" for="bouffePriceFor2">Prix pour 2</label>
                </div>
              </div>
            </span>
            </div>
            
            <!-- -->
            <div <?php if($mode==0){echo "class='ferme'";} ?> id="boisson">
            <div class="drawer-separator"></div>
            <span class="mdl-navigation__link" href="">
              <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="boissonSwitch">
                <input type="checkbox" id="boissonSwitch" class="mdl-switch__input" name="boissonSwitch" onChange="updateShow();" <?php if($data["settings"]["switch"]["boisson"]['value']==1){echo "checked";} ?>>
                <span class="mdl-switch__label">Boisson</span>
              </label>
              <div <?php if ($data["settings"]["switch"]["boisson"]["value"]==0) {echo 'class="ferme"';} ?> id="boissonStuff">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="boissonType" name="boissonType" value=<?php echo $data["settings"]["switch"]["boisson"]['type'];?>>
                <label class="mdl-textfield__label" for="boissonType">type</label>
              </div>
              <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="boissonIsPromoFor2">
                <input type="checkbox" id="boissonIsPromoFor2" class="mdl-checkbox__input" name="boissonIsPromoFor2" <?php if($data["settings"]["switch"]["boisson"]['diffpour2']==1){echo "checked";} ?>>
                <span class="mdl-checkbox__label">Promo pour 2 ?</span>
              </label>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="number" step="0.01" id="boissonPriceUnit" name="boissonPriceUnit" value=<?php echo $data["settings"]["switch"]["boisson"]['price'];?>>
                <label class="mdl-textfield__label" for="boissonPriceUnit">Prix unitaire</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="number" step="0.01" id="boissonPriceFor2" name="boissonPriceFor2" value=<?php echo $data["settings"]["switch"]["boisson"]['pricefor2'];?>>
                <label class="mdl-textfield__label" for="boissonPriceFor2">Prix pour 2</label>
              </div>
              </div>
            </span>
            </div>
            <!-- -->
            <div class="drawer-separator2"></div>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
            Save
            </button>
            </form>
          </nav>
        </div>
        <div class="mdl-layout__content">
          <a name="top"></a>
          <div name="cards">
          <!-- meteo -->
			<div class="meteo" id="meteo">
			<!-- Image card -->
				<div class="meteo-card-image mdl-card mdl-shadow--2dp" id="meteo-card">
					<div class="mdl-card__title mdl-card--expand"></div>
				</div>
				<!-- Text card -->
				<div class="meteo-card-text mdl-card mdl-shadow--2dp">
					<div class="mdl-card__title">
						<h1 class="mdl-card__title-text">
							<div name="actualMeteo" id="actualMeteo"></div>
						</h1>
					</div>
					<div class="mdl-card__actions mdl-card--border">
						<div class="infoMeteo" name="infoMeteo" id="infoMeteo"></div>
					</div>
				</div>
			<!-- fin meteo -->
			</div>

            <!-- events -->
          <!-- <div class="event-card card-format mdl-card mdl-shadow">
            <div class="mdl-card__title">
              <h2 class="mdl-card__title-text">

              </h2>
            </div>
            <div class="mdl-card__supporting-text">

            </div>
          </div> -->
            <!-- fin events -->
            <!-- consos -->
         <!--  <div class="conso-card card-format mdl-card mdl-shadow">
            <div class="mdl-card__title">
              <h2 class="mdl-card__title-text">

              </h2>
            </div>
            <div class="mdl-card__supporting-text">

            </div>
          </div> -->
            <!-- fin consos -->
          </div>

        </div>
      </div>
      <div id="toast" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
      </div>
    </body>
  </html>
  <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  
  <script src="./js/menu.js"></script>
  <script src="./js/menu_deroulement.js"></script>
  <script src="./js/form_menu.js"></script>
  <script src="./js/gestion_update.js"></script>
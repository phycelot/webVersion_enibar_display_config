<?php
session_start();
if (isset($_SESSION['users_id'])){
	header("Refresh:0; url=config");
	exit();
};

include('dbconnection.php');
include('functions.php');
$ip=get_ip();
$req='SELECT COUNT(`connection_ip`) as howManyConnection FROM `connection` WHERE `connection_datetime` > DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND `connection_success`=0 AND `connection_ip`="'.$ip.'"';
$result=mysqli_query($connect, $req);
$row = mysqli_fetch_assoc($result);
if ($row['howManyConnection']>10) {
	header("Refresh:0; url=spameur");
	exit();
}
?>
  <!doctype html>
  <html lang="fr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <!-- Page styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=fr">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.min.css">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.red-deep_orange.min.css" />
    <link rel="stylesheet" href="./dialog/mdl-jquery-modal-dialog.css">
    <link rel="stylesheet" href=".css/login.css">
    <link rel="icon" href=".image/enibar.png" />
  </head>

  <body>
    <div class="login-card mdl-card mdl-shadow--2dp" id="login_password">
      <div class="mdl-card__title">
        <h1 class="login_title mdl-card__title-text">Login</h1>
      </div>
      <div class="mdl-card__menu">
        <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="login_pin">
              <i class="material-icons">fiber_pin</i>
            </button>
        <div class="mdl-tooltip" for="login_pin">code pin</div>
        <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="login_info">
              <i class="material-icons">info</i>
            </button>
        <div class="mdl-tooltip" for="login_info">info</div>
        <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="login_cancel" disabled>
              <i class="material-icons">cancel</i>
            </button>
        <div class="mdl-tooltip" for="login_cancel">cancel</div>
      </div>
      <div class="mdl-card__supporting-text">
        <!--             <form id="login"> -->
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="text" id="pseudo">
          <label class="mdl-textfield__label" for="pseudo">pseudo</label>
        </div>
        </br>
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="password" id="password">
          <label class="mdl-textfield__label" for="password">password</label>
        </div>
      </div>
      <div class="login_button_card mdl-card__actions mdl-card--border">
        <button class="login-button mdl-button mdl-js-button mdl-js-ripple-effect" type="submit" id="login_password_button">
               LOG <i class="material-icons">exit_to_app</i>
            </button>
      </div>
      <!--       </form> -->
    </div>
    <div class="close login-card mdl-card mdl-shadow--2dp" id="login_digicode">
      <div class="mdl-card__title">
        <h1 class="login_title mdl-card__title-text">Login</h1>
      </div>
      <div class="mdl-card__menu">
        <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="login_cancel_pin">
              <i class="material-icons">cancel</i>
            </button>
        <div class="mdl-tooltip" for="login_cancel_pin">cancel</div>
      </div>
      <div class="login_digit_zone mdl-card__supporting-text">
        <input class="code_input mdl-textfield__input" id="login_digit_text" value="" disabled>
        </br>
        <button id="login_digit_A" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              1
            </button>
        <button id="login_digit_B" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              2
            </button>
        <button id="login_digit_C" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              3
            </button>
        </br>
        <button id="login_digit_D" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              4
            </button>
        <button id="login_digit_E" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              5
            </button>
        <button id="login_digit_F" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              6
            </button>
        </br>
        <button id="login_digit_G" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              7
            </button>
        <button id="login_digit_H" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              8
            </button>
        <button id="login_digit_I" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              9
            </button>
        </br>
        <button id="login_digit_cancel" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect">
              <i class="material-icons">close</i>
            </button>
        <button id="login_digit_J" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect" onclick="loginDigitClick(this.id);">
              0
            </button>
        <button id="login_digit_validate" class="login_digit_button mdl-button mdl-js-button mdl-js-ripple-effect">
              <i class="material-icons">done</i>
            </button>
        </br>
      </div>
    </div>
    <!-- snackbar -->
    <div id="toast" class="mdl-js-snackbar mdl-snackbar">
      <div class="mdl-snackbar__text"></div>
      <button class="mdl-snackbar__action" type="button"></button>
    </div>
  </body>

  </html>
  <script src="./dialog/mdl-jquery-modal-dialog.js"></script>
  <script src="https://storage.googleapis.com/code.getmdl.io/1.0.2/material.min.js"></script>
  <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="./js/login.js"></script>
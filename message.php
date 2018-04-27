<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>dedibar</title>

    <!-- Material Design Lite CSS -->
    <script src="https://storage.googleapis.com/code.getmdl.io/1.0.2/material.min.js"></script>
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css" /> 
    <!-- Font Awesome CSS -->
    <!--link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"-->

    <!-- Page styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=fr">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.min.css">
    <!-- <link rel="stylesheet" href=".css/styles.css"> -->
    <link rel="icon" href=".image/enibar.png" /> 
  </head>
  <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

      <div class="mdl-layout__header mdl-layout__header--waterfall">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">DEDIBAR
          </span>
          <!-- Add spacer, to align navigation to the right in desktop -->
          <div class="mdl-layout-spacer"></div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width">
          </div>
          <!-- Navigation -->
        </div>
      </div>
      <style type="text/css">
        .dedi-card {
          display: flex;
          margin-top: 10%;
          margin-left: 10%;
          margin-right: 10%;
          width: 80%;
        }

        .dedi-text {
          margin-right: 5%;
          margin-left: 5%;
        }

        .dedi-button {
          color :#3f51b5;
        }
      </style>
      <div class="mdl-layout__content">
      <form id="send_message">
        <div class="dedi-card mdl-card mdl-shadow--2dp" id="dedi-card">
          <div class="mdl-card__title">
   
            <div class="up text"><h4>Votre message :</h4><div id="message_maxlength"></div> </div>
            </div>
            <div class="dedi-text mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="pseudo" name="pseudo" minlength="1" maxlength="20" required>
              <label class="mdl-textfield__label" for="pseudo">pseudo (max 20)</label>
            </div>
            <div class="dedi-text mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="message" name="message" minlength="1" maxlength="29" required>
              <label class="mdl-textfield__label" for="messsage">text(max 29)</label>
            </div>
            <button class="dedi-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button" type="submit">
              <i class="material-icons">send</i>
            </button>
          
        </div>
        </form>
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
<script src="./js/send_messages.js"></script>
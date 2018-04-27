<?php
mb_internal_encoding('UTF-8_general_ci');
session_start();
if (!isset($_SESSION['users_id'])){
	header('Location: login');
	exit();
}
date_default_timezone_set('Europe/Paris'); setlocale(LC_TIME, "fr_FR.UTF8");// pour forcer l'affichage heure française
?>
<!doctype html>
	<script type="text/javascript">
		var users_level = <?php echo $_SESSION["users_level"]; ?>;
	</script>

	<html lang="fr">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="config">
		<meta name="keywords" content="" />
		<meta name="author" content="enibar-team" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#3f51b5">
		<title>config</title>
		<!-- Page styles -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=fr">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.min.css">
		<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-blue.min.css" />
		<link rel="stylesheet" href="./dialog/mdl-jquery-modal-dialog.css">
		<link rel="stylesheet" href=".css/config.css">
		<link rel="stylesheet" href=".css/config_autre.css">
		<link rel="stylesheet" href=".css/config_affichage.css">
		<link rel="stylesheet" href=".css/config_up_button.css">
		<link rel="stylesheet" href=".css/loader.css">
		<link rel="icon" href=".image/enibar.png" />
	</head>

	<body onload="loader();" style="margin:0;">
		<div id="main" class="close mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">

			<header class="mdl-layout__header mdl-layout__header--scroll">
				<div class="mdl-layout__header-row">
					<!-- Title -->
					<span class="mdl-layout-title">config</span>
					<!-- Add spacer, to align navigation to the right -->
					<div class="mdl-layout-spacer"></div>
					<!-- Navigation -->
					<nav class="mdl-navigation">
						<button class="up_option_button mdl-navigation__link mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" id="bug_report">
              <i class="material-icons">bug_report</i>
            </button>
						<div class="mdl-tooltip" for="report_bug">bug report</div>
						<button class="up_option_button mdl-navigation__link mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" id="send_message" disabled>
              <i class="material-icons">message</i>
            </button>
						<button class="up_option_button mdl-navigation__link mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" id="reboot">
              <i class="material-icons">autorenew</i>
            </button>
						<button class="up_option_button mdl-navigation__link mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" id="disconnect">
              <i class="material-icons">exit_to_app</i>
            </button>
					</nav>
				</div>
				<!-- Tabs -->
				<div class="mdl-layout__tab-bar mdl-js-ripple-effect">
					<a id="config-event" href="#config-event" id='config_event' class="mdl-layout__tab">events</a>
					<a href="#config-affichage" id='config_affichage' class="mdl-layout__tab is-active">affichage</a>
					<a href="#config-autre" id='config_autre' class="mdl-layout__tab">autre</a>
				</div>
			</header>
			<main class="mdl-layout__content">
				<!-- config-event -->
				<section class="mdl-layout__tab-panel" id="config-event">
					<div class="page-content">
						<!-- list near event -->
						<div class="event-modif-card mdl-card mdl-shadow--2dp" id='list-near-event'>
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">Near Events</h2>
							</div>
							<div class="mdl-card__supporting-text" id="list-near-event-list">
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="show-settings" onClick="updateShow(this.id);" disabled>
									<i class="material-icons">settings</i>
								</button>
								<div class="mdl-tooltip" for="show-settings">settings</div>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="show-info" onClick="updateShow(this.id);">
									<i class="material-icons">info</i>
								</button>
								<div class="mdl-tooltip" for="show-info">info</div>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="show-add" onClick="updateShow(this.id);">
                        <i class="material-icons">add</i>
                      </button>
								<div class="mdl-tooltip" for="show-add">add</div>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="show-list" onClick="updateShow(this.id);">
                        <i class="material-icons">list</i>
                      </button>
								<div class="mdl-tooltip" for="show-list">list</div>
							</div>
						</div>
						<!-- add event -->
						<div class="close mdl-card-modified event-add-card mdl-card mdl-shadow--2dp" id="add-event">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">add events</h2>
							</div>
							<div class="grid-modif mdl-grid">
								<div class="event-add-card-add mdl-cell mdl-card mdl-shadow--2dp" id="add">
									<div class="mdl-card__supporting-text">
										<div>
											Event
											<select id="event-type-selector-add" onClick="updateShow(this.id);">
                      </select>
										</div>
										<div>
											Datetime
											<input type="datetime-local" name="event_time" id="event-date-add" onClick="updateShow(this.id);">
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" id="event-theme-add">
											<label class="mdl-textfield__label" for="event-theme-add">Theme</label>
										</div>
									</div>
								</div>
								<div class="event-add-card-add mdl-cell mdl-card mdl-shadow--2dp" id="">
									<div class="mdl-card__supporting-text">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" id="event-detail-add">
											<span class="mdl-textfield__label">Détail</span>
										</div>
										<label class="add-event-checkbox mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-beer-pong-add">
        							<input type="checkbox" id="checkbox-beer-pong-add" class="mdl-checkbox__input">
        							<span class="mdl-checkbox__label">Beer Pong</span>
        						</label>
										<label class="add-event-checkbox mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-extension-add">
        							<input type="checkbox" id="checkbox-extension-add" class="mdl-checkbox__input">
        							<label class="mdl-checkbox__label" for="checkbox-extension-add">Extension</label>
										</label>
										<label class="add-event-checkbox mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-visible-add">
        							<input type="checkbox" id="checkbox-visible-add" class="mdl-checkbox__input">
        							<label class="mdl-checkbox__label" for="checkbox-visible-add">is visible</label>
										</label>
									</div>
								</div>
								<div class="mdl-card-modified event-add-card-add mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col-phone" id="">
									<div class="mdl-card-modified mdl-card__supporting-text">
										Bouffe
										<div id="event-add-bouffe-list">
											<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" align="center">
												<thead>
													<tr>
														<th>type</th>
														<th>
															<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" id="event-add-bouffe-add" onClick="updateShow(this.id);">
                          <i class="material-icons">add</i>
                        </button>
														</th>
													</tr>
												</thead>
												<tbody id="event-add-bouffe-list-tbody">
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="mdl-card-modified event-add-card-add mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col-phone" id="">
									<div class="mdl-card-modified mdl-card__supporting-text">
										Boisson
										<div id="event-add-boisson-list">
											<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" align="center">
												<thead>
													<tr>
														<th>type</th>
														<th>
															<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" id="event-add-boisson-add" onClick="updateShow(this.id);">
                          <i class="material-icons">add</i>
                        </button>
														</th>
													</tr>
												</thead>
												<tbody id="event-add-boisson-list-tbody">
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="mdl-card__actions mdl-card--border">
									<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="event-save-add" onClick="updateShow(this.id);">
                  save
                </button>
								</div>
								<div class="mdl-card__menu">
									<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="event-add-raz">
                  <i class="material-icons">delete</i>
                </button>
									<div class="mdl-tooltip" for="event-add-raz">raz</div>
									<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="cancel-add" onClick="updateShow(this.id);">
                  <i class="material-icons">cancel</i>
                </button>
									<div class="mdl-tooltip" for="cancel-add">close</div>
								</div>
							</div>
						</div>
						<!-- edit event -->
						<div class="close event-edit-card mdl-card mdl-shadow--2dp" id="edit-event">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">edit events</h2>
							</div>
							<div class="grid-modif mdl-grid">
								<div class="event-edit-card-edit mdl-cell mdl-card mdl-shadow--2dp" id="edit">
									<div class="mdl-card__supporting-text">
										<div>
											Event
											<select id="event-type-selector-edit" onClick="updateShow(this.id);">
                      </select>
										</div>
										<div>
											Datetime
											<input type="datetime-local" name="event_time" id="event-date-edit" onClick="updateShow(this.id);">
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" id="event-theme-edit">
											<label class="mdl-textfield__label" for="event-theme-edit">Theme</label>
										</div>
									</div>
								</div>
								<div class="event-edit-card-edit mdl-cell mdl-card mdl-shadow--2dp" id="">
									<div class="mdl-card__supporting-text">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" id="event-detail-edit">
											<span class="mdl-textfield__label">Détail</span>
										</div>
										<label class="edit-event-checkbox edit-event-checkbox-beer-pong mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-beer-pong-edit">
        							<input type="checkbox" id="checkbox-beer-pong-edit" class="mdl-checkbox__input">
        							<span class="mdl-checkbox__label">Beer Pong</span>
        						</label>
										<label class="edit-event-checkbox edit-event-checkbox-extension mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-extension-edit">
        							<input type="checkbox" id="checkbox-extension-edit" class="mdl-checkbox__input">
        							<label class="mdl-checkbox__label" for="checkbox-extension-edit">Extension</label>
										</label>
										<label class="edit-event-checkbox edit-event-checkbox-visible mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-visible-edit">
        							<input type="checkbox" id="checkbox-visible-edit" class="mdl-checkbox__input">
        							<label class="mdl-checkbox__label" for="checkbox-visible-edit">visible</label>
										</label>
									</div>
								</div>
								<div class="mdl-card-modified event-edit-card-add mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col-phone" id="">
									<div class="mdl-card-modified mdl-card__supporting-text">
										Bouffe
										<div id="event-edit-bouffe-list">
											<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" align="center">
												<thead>
													<tr>
														<th>type</th>
														<th>
															<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" id="event-edit-bouffe-add" onClick="updateShow(this.id);">
            <i class="material-icons">add</i>
          </button>
														</th>
													</tr>
												</thead>
												<tbody id="event-edit-bouffe-list-tbody">
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="mdl-card-modified event-edit-card-add mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col-phone" id="">
									<div class="mdl-card-modified mdl-card__supporting-text">
										Boisson
										<div id="event-edit-boisson-list">
											<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" align="center">
												<thead>
													<tr>
														<th>type</th>
														<th>
															<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" id="event-edit-boisson-add" onClick="updateShow(this.id);">
            <i class="material-icons">add</i>
          </button>
														</th>
													</tr>
												</thead>
												<tbody id="event-edit-boisson-list-tbody">
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="mdl-card__actions mdl-card--border">
									<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="event-save-edit" onClick="updateShow(this.id);">
                  save
                </button>
								</div>
								<div class="mdl-card__menu">
									<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="event-edit-raz">
                  <i class="material-icons">delete</i>
                </button>
									<div class="mdl-tooltip" for="event-edit-raz">raz</div>
									<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="cancel-edit" onClick="updateShow(this.id);">
                  <i class="material-icons">cancel</i>
                </button>
									<div class="mdl-tooltip" for="cancel-edit">close</div>
								</div>
							</div>
						</div>
						<!-- settings event -->
						<div class="close event-settings-card mdl-card mdl-shadow--2dp" id="settings-event">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">settings</h2>
							</div>
							<div class="center mdl-card__supporting-text" id="settings_event_in">
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="cancel-settings" onClick="updateShow(this.id);">
                        <i class="material-icons">cancel</i>
                      </button>
								<div class="mdl-tooltip" for="cancel-settings">close</div>
							</div>
						</div>
						<!-- list event -->
						<div class="close event-list-card mdl-card mdl-shadow--2dp" id="list-event">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">list</h2>
							</div>
							<div class="mdl-card__supporting-text" id="list-event-list">
							</div>
							<div class="mdl-card__menu">
								<div>
									<select id="eventlist_searchType">
                        </select>
								</div>
								<div>
									<input type="date" name="" id="eventlist_searchDate">
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
									<label class="mdl-button mdl-js-button mdl-button--icon" for="eventlist_search">
                          <i class="material-icons">search</i>
                        </label>
									<div class="mdl-textfield__expandable-holder">
										<input class="mdl-textfield__input" type="text" id="eventlist_search" onchange="show_list();">
										<label class="mdl-textfield__label" for="sample-expandable">Expandable Input</label>
									</div>
								</div>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="cancel-list" onClick="updateShow(this.id);">
                        <i class="material-icons">cancel</i>
                      </button>
								<div class="mdl-tooltip" for="cancel-list">close and reset</div>
							</div>
						</div>
					</div>
				</section>
				<!-- config-affichage -->
				<section class="mdl-layout__tab-panel is-active" id="config-affichage">
					<div class="page-content">
						<div id="affichage_main_edit" class="affichage_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text" id='affichage_main_edit_title'>config actual</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_main_text">
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_actual_affichage">
                  save
                </button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="settings_affichage" disabled>
									<i class="material-icons">settings</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="add_category">
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_main_edit">
									<i class="material-icons">cancel</i>
								</button>
								<div class="mdl-tooltip" for="close_affichage_main">close</div>
							</div>
						</div>
						<div id="affichage_new_category" class="affichage_div2 mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">ajouter une categorie</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_new_category_text">
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="add_category" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_new_category">
									<i class="material-icons">cancel</i>
								</button>
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_affichage_new_category">
                  save
                </button>
							</div>
						</div>
						<div id="affichage_new_product" class="affichage_div2 mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">ajouter un produit</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_new_product_text">
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_affichage_new_product">
                  save
                </button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_new_product">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_add_category" class="affichage_div2 mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">add a category</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_add_category_text">
								<div class="mdl-textfield mdl-js-textfield">
									<input class="mdl-textfield__input" type="text" id="name_add_category">
									<label class="mdl-textfield__label" for="name_add_category">Nom de la categorie</label>
								</div>
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_affichage_add_category">
                  save
                </button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_add_category">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_add_product" class="affichage_div2 mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">add a product</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_add_product_text">
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_affichage_add_product">
                  save
                </button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_add_product">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_edit_category" class="affichage_div2 mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">edit a category</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_edit_category_text">
								<div class="mdl-textfield mdl-js-textfield">
									<input class="mdl-textfield__input" type="text" id="name_edit_category">
									<label class="mdl-textfield__label" for="name_edit_category">Nom de la categorie</label>
								</div>
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_affichage_edit_category">
                  save
                </button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_edit_category">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_edit_product" class="affichage_div2 mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">edit a product</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_edit_product_text">
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_affichage_edit_product">
                  save
                </button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_edit_product">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_config_category" class="affichage_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">config category</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_config_category_text">
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="button_affichage_add_category">
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_config_category">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_config_product" class="affichage_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">config product</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_config_product_text">
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="button_affichage_add_product">
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_config_product">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_category_settings" class="affichage_div2 mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">category settings</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_category_settings_text">
								<label class="affichage_category_settings_isVisible mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="affichage_category_settings_isVisible">
									<input type="checkbox" id="affichage_category_settings_isVisible" class="mdl-checkbox__input">
									<span class="mdl-checkbox__label">visible ?</span>
								</label>
							</div>
							<div class="alignRight mdl-card__actions mdl-card--border">
								<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="save_affichage_category_settings">
                  save
                </button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_category_settings">
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
						<div id="affichage_general_settings" class="affichage_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">general settings</h2>
							</div>
							<div class="mdl-grid mdl-card__supporting-text" id="affichage_general_settings_text">
								<button id="affichage_actual_config" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
									<i class="material-icons">keyboard_arrow_right</i> actual config
								</button>
								</br>
								<button id="affichage_load_config" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" disabled>
									<i class="material-icons">keyboard_arrow_right</i> load config
								</button>
								</br>
								<button id="affichage_category" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
									<i class="material-icons">keyboard_arrow_right</i> category
								</button>
								</br>
								<button id="affichage_product" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
									<i class="material-icons">keyboard_arrow_right</i> product
								</button>
								</br>
								<button id="affichage_add_preconfig_for_event" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" disabled>
									<i class="material-icons">keyboard_arrow_right</i> preconfig
								</button>
								</br>
								<button id="affichage_add_default_config_for_event" class="settings_button mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" disabled>
									<i class="material-icons">keyboard_arrow_right</i> default config for event
								</button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="" disabled>
									<i class="material-icons">add_circle</i>
								</button>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_affichage_general_settings" disabled>
									<i class="material-icons">cancel</i>
								</button>
							</div>
						</div>
					</div>
				</section>
				<!-- config-autre -->
				<section class="mdl-layout__tab-panel" id="config-autre">
					<div class="page-content">
						<div id="autre_main" class="autre_div mdl-card mdl-shadow--2dp">
							<div class="separation"></div>
							<div>
								<button id="users_config" class="autre_button mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" disabled>
									<i class="material-icons">keyboard_arrow_right</i> gerer les utilisateurs <i class="material-icons">supervisor_account</i>
								</button>
							</div>
							<div>
								<button id="temporary_users_config" class="autre_button mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" disabled>
									<i class="material-icons">keyboard_arrow_right</i> temporary users config <i class="material-icons">supervisor_account</i>
								</button>
							</div>
							<div>
								<button id="users_password_change" class="autre_button mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" disabled>
									<i class="material-icons">keyboard_arrow_right</i> changer de mot de passe <i class="material-icons">account_circle</i>
								</button>
							</div>
							<div class="expandable">
								<button id="title_message" class="expand_button autre_button mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
									<i class="material-icons">keyboard_arrow_right</i> liste des messages <i class="material-icons">expand_more</i>
								</button>
								<div id="text_message" class="expand_text">

									<div id="nbr_message_selector_div" class="nbr_selector mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="number" id="nbr_message_selector">
										<label class="mdl-textfield__label" for="nbr_message_selector">limit</label>
									</div>
									<div id="list_message" class="list_expand">

									</div>
								</div>
							</div>
							<div class="expandable">
								<button id="title_connection" class="expand_button autre_button mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
									<i class="material-icons">keyboard_arrow_right</i> liste des connexions <i class="material-icons">expand_more</i>
								</button>
								<div id="text_connection" class="expand_text">
									<div id="nbr_connection_selector_div" class="nbr_selector mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="number" id="nbr_connection_selector">
										<label class="mdl-textfield__label" for="nbr_connection_selector">limit</label>
									</div>
									<div id="list_connection" class="list_expand">
									</div>
								</div>
							</div>

						</div>
						<div id="autre_users_config" class="autre_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">Users config</h2>
							</div>
							<div class="mdl-card__supporting-text" id="">
								<i class="material-icons">search</i>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="text" id="users_search">
									<label class="mdl-textfield__label" for="users_search">search</label>
								</div>
								<div id="users_list">
								</div>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="add_users_config">
									<i class="material-icons">add_circle</i>
								</button>
								<div class="mdl-tooltip" for="add_users_config">add user</div>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_users_config">
									<i class="material-icons">cancel</i>
								</button>
								<div class="mdl-tooltip" for="close_users_config">close</div>
							</div>
						</div>
						<div id="autre_temporary_users_config" class="autre_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">temporary Users config</h2>
							</div>
							<div class="mdl-card__supporting-text" id="">
								<i class="material-icons">search</i>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="text" id="temporary_users_search">
									<label class="mdl-textfield__label" for="temporary_users_search">search</label>
								</div>
								<div id="temporary_users_list">
								</div>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="add_temporary_users_config">
									<i class="material-icons">add_circle</i>
								</button>
								<div class="mdl-tooltip" for="add_temporary_users_config">add user</div>
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_temporary_users_config">
									<i class="material-icons">cancel</i>
								</button>
								<div class="mdl-tooltip" for="close_temporary_users_config">close</div>
							</div>
						</div>
						<div id="autre_change_password" class="autre_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">Change password</h2>
							</div>
							<div class="mdl-card__supporting-text" id="">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="password" id="users_old_password">
									<label class="mdl-textfield__label" for="users_old_password">old password</label>
								</div>
								</br>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="password" id="users_new_password" pattern=".{7,}">
									<label class="mdl-textfield__label" for="users_new_password">new password(min 7)</label>
									<span class="mdl-textfield__error">at least 7 or more characters</span>
								</div>
								</br>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="password" id="users_new_password_verif">
									<label class="mdl-textfield__label" for="users_new_password_verif">new password verif</label>
								</div>
								</br>
								<button id="users_password_change_valid" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
									<i class="material-icons">done</i>alid
								</button>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_change_password">
									<i class="material-icons">cancel</i>
								</button>
								<div class="mdl-tooltip" for="close_change_password">close</div>
							</div>
						</div>
						<div id="autre_new_account" class="autre_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">new account</h2>
							</div>

							<div class="mdl-card__supporting-text" id="">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="text" id="new_users_pseudo" pattern=".{7,}">
									<label class="mdl-textfield__label" for="new_users_pseudo">pseudo(min 7)</label>
									<span class="mdl-textfield__error">at least 7 or more characters</span>
								</div>
								</br>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="password" id="new_users_password" pattern=".{7,}">
									<label class="mdl-textfield__label" for="new_users_password">password(min 7)</label>
									<span class="mdl-textfield__error">at least 7 or more characters</span>
								</div>
								</br>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="password" id="new_users_password_verif">
									<label class="mdl-textfield__label" for="new_users_password_verif">password verif</label>
								</div>
								</br>
								<button id="new_users_valid" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
										<i class="material-icons">done</i>alid
									</button>
							</div>

							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_new_users">
									<i class="material-icons">cancel</i>
								</button>
								<div class="mdl-tooltip" for="close_new_users">close</div>
							</div>
						</div>
						<div id="autre_new_temporary_account" class="autre_div mdl-card mdl-shadow--2dp">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">new temporary account</h2>
							</div>
							<div class="mdl-card__supporting-text" id="">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="number" id="new_temporary_users_code" pattern=".{7,}">
									<label class="mdl-textfield__label" for="new_temporary_users_code">code(min 7)</label>
									<span class="mdl-textfield__error">at least 7 or more number</span>
								</div>
								</br>
								<div>
									StartTime
									<input type="datetime-local" name="StartTime" id="new_temporary_users_startTime">
								</div>
								</br>
								<div>
									EndTime
									<input type="datetime-local" name="EndTime" id="new_temporary_users_endTime">
								</div>
								</br>
								<button id="new_temporary_users_code_valid" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
										<i class="material-icons">done</i>alid
									</button>
							</div>

							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="close_new_temporary_users">
									<i class="material-icons">cancel</i>
								</button>
								<div class="mdl-tooltip" for="close_new_temporary_users">close</div>
							</div>
						</div>
				</section>
			</main>
			</div>
			<!-- snackbar -->
			<div id="toast" class="mdl-js-snackbar mdl-snackbar">
				<div class="mdl-snackbar__text"></div>
				<button class="mdl-snackbar__action" type="button"></button>
			</div>
			<!-- 	loader		 -->
			<div id="loader" class="loader"></div>
			<!-- 	save add button	 -->
			<div id="save_add_button" class="close">
				<button id="event-save-add2" onClick="updateShow(this.id);" class="fixed_button_save mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"><i class="material-icons">save</i></button>
			</div>
			<!-- 	save edit button	 -->
			<div id="save_edit_button" class="close">
				<button id="event-save-edit2" onClick="updateShow(this.id);" class="fixed_button_save mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"><i class="material-icons">save</i></button>
			</div>
	</body>

	</html>
	<script src="./dialog/mdl-jquery-modal-dialog.js"></script>
	<script src="https://storage.googleapis.com/code.getmdl.io/1.0.2/material.min.js"></script>
	<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="./js/config_event.js"></script>
	<script src="./js/config_autre.js"></script>
	<script src="./js/config_affichage.js"></script>
	<script src="./js/config_up_button.js"></script>
	<script src="./js/loader.js"></script>
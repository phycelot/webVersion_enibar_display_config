$(document).ready(function() {
  $(".expand_text").each(function() {
    $("#" + this.id).hide();
  });
  $("#autre_users_config").hide();
  $("#autre_temporary_users_config").hide();
  $("#autre_change_password").hide();
  $("#autre_new_account").hide();
  $("#autre_new_temporary_account").hide();
  if (users_level > 0) {
    document.getElementById("users_password_change").disabled = false;
    document.getElementById("temporary_users_config").disabled = false;
    if (users_level > 1) {
      document.getElementById("users_config").disabled = false;
    }
  }
  getLastMessage();
  getLastConnection();
  getUsersList();
  getTemporaryUsersList();
})

$('#config_autre').click(function() {
  $("#autre_users_config").hide();
  $("#autre_temporary_users_config").hide();
  $("#autre_change_password").hide();
  $("#autre_new_account").hide();
  $("#autre_new_temporary_account").hide();
  $("#autre_main").show();
})

$('#new_temporary_users_code_valid').click(function() {
  var message = "";
  if ($("#new_temporary_users_code").val().length >= 7) {
    if ($("#new_temporary_users_startTime").val().length >0) {
      if ($("#new_temporary_users_endTime").val().length>0) {
        url_ = "api_ajax?action=newTemporaryCode&code="+$("#new_temporary_users_code").val()+'&startTime='+document.getElementById("new_temporary_users_startTime").value+'&endTime='+$("#new_temporary_users_endTime").val();
//         console.log(url_);
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
              console.log("reboot"); //wip maj affichage
            }
          },
          error: function(response) {
            console.error(response);
          }
        });
      } else {
        message = "no end date";
        notification.MaterialSnackbar.showSnackbar({
          message: message
        });
      }
    } else {
      message = "no start date";
      notification.MaterialSnackbar.showSnackbar({
        message: message
      });
    }
  } else {
    message = "code too short";
    notification.MaterialSnackbar.showSnackbar({
      message: message
    });
  }
})

$('#users_password_change_valid').click(function() {
  var message = "";
  if ($("#users_old_password").val().length >= 7) {
    if ($("#users_new_password").val().length >= 7) {
      if ($("#users_new_password_verif").val() == $("#users_new_password").val()) {
        url_ = "api_ajax?action=changePassword&oldPassword=" + $("#users_old_password").val() + "&newPassword=" + $("#users_new_password").val();
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
              console.log("reboot"); //wip maj affichage
            }
          },
          error: function(response) {
            console.error(response);
          }
        });
      } else {
        message = "not the same password";
        notification.MaterialSnackbar.showSnackbar({
          message: message
        });
      }
    } else {
      message = "new password too short";
      notification.MaterialSnackbar.showSnackbar({
        message: message
      });
    }
  } else {
    message = "new password too short";
    notification.MaterialSnackbar.showSnackbar({
      message: message
    });
  }
})

$('#new_users_valid').click(function() {
  var message = "";
  if ($("#new_users_pseudo").val().length >= 7) {
    if ($("#new_users_password").val().length >= 7) {
      if ($("#new_users_password_verif").val() == $("#new_users_password").val()) {
        url_ = "api_ajax?action=newUsers&pseudo=" + $("#new_users_pseudo").val() + "&password=" + $("#new_users_password").val();
        $.ajax({
          type: "GET",
          url: url_,
          dataType: "html",
          success: function(response) {
            json_response = JSON.parse(response);
//             console.log(json_response);
            message = json_response.message;
            notification.MaterialSnackbar.showSnackbar({
              message: message
            });
            if (json_response.result == "true") {
              console.log("reboot"); //wip maj affichage
            }
          },
          error: function(response) {
            console.error(response);
          }
        });
      } else {
        message = "not the same password";
        notification.MaterialSnackbar.showSnackbar({
          message: message
        });
      }
    } else {
      message = "password too short";
      notification.MaterialSnackbar.showSnackbar({
        message: message
      });
    }
  } else {
    message = "pseudo too short";
    notification.MaterialSnackbar.showSnackbar({
      message: message
    });
  }

})

function getTemporaryUsersList() {
  url_ = "api_ajax?action=getTemporaryUsersList"
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      json_response = JSON.parse(response);
      showTemporaryUsersList(json_response);
    },
    error: function(response) {
      console.error(response);
    }
  });
}

function showTemporaryUsersList(json) {
  if (json) {
    toShow = '<ul class="mdl-list">';
    for (var index = 0; index < json.length; index++) {
      var element = json[index];
      toShow += '<li class="mdl-list__item mdl-list__item--three-line"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-avatar">person</i>';
      toShow += '<span>' + element.users_code + '</span><span class="mdl-list__item-text-body">';
      toShow +=  element.users_temporary_startTime +'</br>'+ element.users_temporary_endTime +'</span></span>';
      toShow += '<span class="mdl-list__item-secondary-content"><button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" onClick="editTemporaryUsers(' + element.users_id + ');" id="edit_user_' + element.users_id + '"><i class="material-icons">edit</i></button></span>';
      toShow += '</li>';
    }
    toShow += '</ul>';
  } else {
    toShow = "no result";
  }
  $("#temporary_users_list").html(toShow);
}

function getUsersList(who, level) {
  url_ = "api_ajax?action=getUsersList"
  if (who) {
    url_ += "&query=" + who
  }
  if (level) {
    url_ += "&level=" + level
  }
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      json_response = JSON.parse(response);
      showUsersList(json_response);
    },
    error: function(response) {
      console.error(response);
    }
  });
}

function showUsersList(json) {
  if (json) {
    toShow = '<ul class="mdl-list">';
    for (var index = 0; index < json.length; index++) {
      var element = json[index];
      toShow += '<li class="mdl-list__item mdl-list__item--two-line"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-avatar mdl-badge mdl-badge--overlap" data-badge="' + element.users_level + '">person</i>';
      toShow += ' <span>' + element.users_name + '</span></span><span class="mdl-list__item-secondary-content">';
      toShow += '<button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" onClick="editUsers(' + element.users_id + ');" id="edit_user_' + element.users_id + '"><i class="material-icons">edit</i></button></span></li>';
    }
    toShow += '</ul>';
  } else {
    toShow = "no result";
  }
  $("#users_list").html(toShow);
}

function editUsers(id) {
  $.ajax({
    type: "GET",
    url: "api_ajax?action=editUsersAllow&users_id=" + id,
    dataType: "html",
    success: function(response) {
      if (response == 1) {
        showDialog({
          title: 'Edit users',
          positive: {
            title: 'delete',
            onClick: function() {
              $.ajax({
                type: "GET",
                url: "api_ajax?action=editUsers&users_id=" + id + "&do=delete",
                dataType: "html",
                success: function(response) {
                  notification.MaterialSnackbar.showSnackbar({
                    message: response
                  });
                  getUsersList();
                },
                error: function(response) {
                  console.error(response);
                }
              });
            }
          },
          negative: {
            title: 'change level',
            onClick: function() {
              $.ajax({
                type: "GET",
                url: "api_ajax?action=getUsersLevelList",
                dataType: "html",
                success: function(response) {
//                   json = JSON.parse(response);
                  json = [{'users_level':0},{'users_level':1},{'users_level':2}];
                  var toShow = "</br>";
                  for (var index = 0; index < json.length; index++) {
                    var element = json[index];
                    toShow += '</br><label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="level-' + element.users_level + '">';
                    toShow += '<input type="radio" id="level-' + element.users_level + '" class="mdl-radio__button" name="level" value="' + element.users_level + '">';
                    toShow += '<span class="mdl-radio__label">' + element.users_level + '</span>';
                    toShow += '</label></br>';
                  }
                  showDialog({
                    title: 'Edit users',
                    text: toShow,
                    positive: {
                      title: 'set',
                      onClick: function() {
//                         console.log($("input:radio[name='level']:checked").val());
                        $.ajax({
                          type: "GET",
                          url: "api_ajax?action=editUsers&level=" + $("input:radio[name='level']:checked").val() + "&users_id=" + id + "&do=changeLevel",
                          dataType: "html",
                          success: function(response) {
                            notification.MaterialSnackbar.showSnackbar({
                              message: response
                            });
                            getUsersList();
                          },
                          error: function(response) {
                            console.error(response);
                          }
                        });
                      }
                    },
                    negative: {
                      title: 'abord',
                    }
                  });
                },
                error: function(response) {
                  console.error(response);
                }
              });
            }
          },
          neutral: {
            title: "ok"
          }
        });
      } else {
        notification.MaterialSnackbar.showSnackbar({
          message: "you're not allow to edit this user"
        });
      }
    },
    error: function(response) {
      console.error(response);
    }
  });


}

function editTemporaryUsers(id) {
  showDialog({
    title: 'Temporary users',
    positive: {
      title: 'delete',
      onClick: function() {
        $.ajax({
          type: "GET",
          url: "api_ajax?action=deleteTemporaryUsers&users_id=" + id,
          dataType: "html",
          success: function(response) {
            json_response = JSON.parse(response);
            message = json_response.message;
            notification.MaterialSnackbar.showSnackbar({
              message: message
            });
            getTemporaryUsersList();
          },
          error: function(response) {
            console.error(response);
          }
        });
      }
    },
    negative: {
      title: 'abord',
    }
  });
}

$("#users_search").on("change keyup paste", function() { //wip ajouter le selector de level
  getUsersList(document.getElementById("users_search").value);
})

$("#nbr_message_selector").on("change keyup paste", function() {
  getLastMessage(document.getElementById("nbr_message_selector").value);
})

function getLastMessage(howMany) {
  if (!howMany) {
    howMany = 5
  }
  $.ajax({
    type: "GET",
    url: "api_ajax?action=get_last_message&limit=" + howMany,
    dataType: "html",
    success: function(response) {
      json_response = JSON.parse(response);
      showLastMessage(json_response);
    },
    error: function(response) {
      console.error(response);
    }
  });
}

function showLastMessage(json) {
  var toShow = '<ul class="mdl-list">';
  for (var index = 0; index < json.length; index++) {
    var element = json[index];
    toShow += '<li class="mdl-list__item mdl-list__item--three-line"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">send</i><span>' + element.users_name;
    toShow += '</span><span class="mdl-list__item-text-body">' + element.message_text + '</span></span></li>';
  }
  toShow += '</ul>';
  $("#list_message").html(toShow);
}

$("#nbr_connection_selector").on("change keyup paste", function() {
  getLastConnection(document.getElementById("nbr_connection_selector").value);
})

function getLastConnection(howMany) {
  if (!howMany) {
    howMany = 5
  }
  $.ajax({
    type: "GET",
    url: "api_ajax?action=get_last_connection&limit=" + howMany,
    dataType: "html",
    success: function(response) {
      json_response = JSON.parse(response);
      showLastConnection(json_response);
    },
    error: function(response) {
      console.error(response);
    }
  });
}

function showLastConnection(json) {
  var toShow = '<ul class="mdl-list">';
  for (var index = 0; index < json.length; index++) {
    var element = json[index];
    toShow += '<li class="mdl-list__item"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">compare_arrows</i>' + element.connection_ip;
    toShow += '</span></li>';
  }
  toShow += '</ul>';
  $("#list_connection").html(toShow);
}

$('.expand_button').click(function() {
  id = "#text_" + this.id.slice(6);
  if ($(id).is(":visible")) {
    $(id).hide("slow");
  } else {
    $(id).show(("slow"));
  }
})

$('#title_message').click(function() {
  etLastMessage();
})

$('#add_temporary_users_config').click(function() {
  $("#autre_new_temporary_account").show();
  $("#autre_temporary_users_config").hide();
})

$('#users_config').click(function() {
    getUsersList();
  $("#autre_users_config").show();
  $("#autre_main").hide();
})

$('#close_users_config').click(function() {
  $("#autre_users_config").hide();
  $("#autre_main").show();
})

$('#temporary_users_config').click(function() {
  getTemporaryUsersList();
  $("#autre_temporary_users_config").show();
  $("#autre_main").hide();
})

$('#close_temporary_users_config').click(function() {
  $("#autre_temporary_users_config").hide();
  $("#autre_main").show();
})

$('#users_password_change').click(function() {
  $("#autre_change_password").show();
  $("#autre_main").hide();
})

$('#close_change_password').click(function() {
  $("#autre_change_password").hide();
  $("#autre_main").show();
})

$('#add_users_config').click(function() {
  $("#autre_new_account").show();
  $("#autre_users_config").hide();
})

$('#close_new_temporary_users').click(function() {
  $("#autre_new_temporary_account").hide();
  $("#autre_main").show();
})

$('#close_new_users').click(function() {
  $("#autre_new_account").hide();
  $("#autre_main").show();
})
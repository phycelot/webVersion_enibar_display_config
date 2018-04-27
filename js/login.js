var notification = document.querySelector('.mdl-js-snackbar');
var pin = [
  ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"],
  []
];
var login_code = "";
$(document).ready(function() {
  loginDigitUpdate();
  testNbrCo();
});

function testNbrCo() {
  $.ajax({
      type: "POST",
      url: "api_ajax?action=testNbrCo",
      success: function(data) {
        if (data>10) {
          location.reload();
        } else if (data>0) {
          message=data+" tentative(s) de connection échoué depuis 15mins";
          notification.MaterialSnackbar.showSnackbar({
            message: message
          }); 
        }       
      }
    });
}

function loginDigitUpdate() {
  for (step = 0; step < 10; step++) {
    tmp = Math.floor(Math.random() * 10);
    while (pin[1].indexOf(tmp) > -1) {
      tmp = Math.floor(Math.random() * 10);
    }
    pin[1][step] = tmp;
  }
  for (i = 0; i < 10; i++) {
    id = "login_digit_" + pin[0][i];
    document.getElementById(id).innerHTML = pin[1][i];
  }
}

function loginDigitClick(id) {
  login_code += pin[1][pin[0].indexOf(id.slice(12))];
  $("#login_digit_text").val(login_code);

}
$('#login_digit_cancel').click(function() {
  login_code = "";
  $("#login_digit_text").val(login_code);
});
$('#login_pin').click(function() {
  //   loginDigitUpdate();
  document.getElementById("login_digicode").classList.remove('close');
  document.getElementById("login_password").classList.add('close');
});
$('#login_cancel_pin').click(function() {
  document.getElementById("login_password").classList.remove('close');
  document.getElementById("login_digicode").classList.add('close');
});
$('#login_info').click(function() {
  showDialog({
    title: 'info',
    text: 'Page de connection pour acceder aux options de l\'afficheur de l\'enibar, si vous n\'avez pas de compte ou pour tout problème merci de contacter l\'équipe du bar à cafeteria@enib.fr',
    positive: {
      title: 'ok'
    }
  })
});
$("#login_password_button").click(function() {
  pseudo = document.getElementById("pseudo").value;
  password = (document.getElementById("password").value);
  if (pseudo.length > 0 && password.length > 0) {
    notification.MaterialSnackbar.showSnackbar({
      message: "try to connect"
    });
    url_="api_ajax?action=connect&how=password&pseudo=" + pseudo + "&password=" + password;
//     console.log(url_);
    $.ajax({
      type: "POST",
      url: url_,
      success: function(data) {
//         console.log(data);
        if (data !== '0') {
          notification.MaterialSnackbar.showSnackbar({
            message: "success"
          });
          location.reload();
        } else {
          testNbrCo();
          notification.MaterialSnackbar.showSnackbar({
            message: "fail"
          });
        }
      }
    });
  } else {
    notification.MaterialSnackbar.showSnackbar({
      message: "problem with the login or/and the password"
    });
  }
});
$("#login_digit_validate").click(function() {
  if (login_code.length > 0) {
    notification.MaterialSnackbar.showSnackbar({
      message: "try to connect"
    });
    $.ajax({
      type: "POST",
      url: "api_ajax?action=connect&how=digit&code=" + login_code,
      success: function(data) {
//         console.log(data);
        if (data !== '0') {
          notification.MaterialSnackbar.showSnackbar({
            message: "success"
          });
          location.reload();
        } else {
          testNbrCo();
          notification.MaterialSnackbar.showSnackbar({
            message: "fail"
          });
        }
      }
    });
  } else {
    notification.MaterialSnackbar.showSnackbar({
      message: "no code you suck"
    });
  }
});
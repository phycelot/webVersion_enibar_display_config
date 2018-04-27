window.onload = function() {
  var date = new Date();
  pageLoadTime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
  function isRebootAsked() {
    url_ = 'api_ajax?action=isRebootAsked&pageLoadTime="' + pageLoadTime +'"';
//     console.log(url_);
    $.ajax({
      type: "GET",
      url: url_,
      dataType: "html",
      success: function(response) {
        array = JSON.parse(response);
//         console.log(array);
        if (array.result=='true'){
          hidePage();
          setTimeout(window.location.reload(false), 1000);
//           window.location.reload(false);
        }
      },
      error: function(response) {
        console.error(response);
      }
    });
  }

  function updateFunction() {
    isRebootAsked();
  }
  window.setInterval(updateFunction, 1000); //auto-refresh des fonctions séléctionnées toutes les secondes
}
window.onload=function() {
    function updateFunction(){
      url_ = 'api_ajax?action=get_config_affichage&actual';
      $.ajax({
          type: "GET",
          url: url_,
          dataType: "html",
          success: function(response) {
            json_response = JSON.parse(response);
            console.log(json_response);
          },
          error: function(response) {
            console.error(response);
          }
        });
    }
    function globalInit() {
       updateFunction();
    }
    globalInit();
	window.setInterval(updateFunction, 1000);//auto-refresh des fonctions séléctionnées
    
}
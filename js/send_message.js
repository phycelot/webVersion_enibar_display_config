$("#send_message").submit(function(e){ // On sélectionne le formulaire par son identifiant
    e.preventDefault(); // Le navigateur ne peut pas envoyer le formulaire

    var donnees = $(this).serialize(); // On créer une variable content le formulaire sérialisé
    var notification = document.querySelector('.mdl-js-snackbar'); 

    $.ajax({
        url : "send_message.php",
        type : 'POST',
        data : donnees,
        success: function() {
            notification.MaterialSnackbar.showSnackbar(
              {
                message: 'success'
              }
            );
            var myinputmessage = document.getElementById("message");
            myinputmessage.value = myinputmessage.defaultValue;
            var myinputpseudo = document.getElementById("pseudo");
            myinputpseudo.value = myinputpseudo.defaultValue;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            notification.MaterialSnackbar.showSnackbar(
              {
                message: 'fail'
              }
            );
           console.log(textStatus, errorThrown);
        },
        datatype : 'html'
    });
});
$("#formulaire").submit(function(e){ // On sélectionne le formulaire par son identifiant
    e.preventDefault(); // Le navigateur ne peut pas envoyer le formulaire

    var donnees = $(this).serialize(); // On créer une variable content le formulaire sérialisé
    var notification = document.querySelector('.mdl-js-snackbar');
    
    $.ajax({
        url : "modif.php",
        type : 'POST',
        data : donnees,
        success: function() {
            notification.MaterialSnackbar.showSnackbar(
              {
                message: 'success'
              }
            );
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
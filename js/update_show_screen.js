var affichage_data;

function update_show_screen_conso(data) {
  if (affichage_data != data) {
    affichage_data = data;
    toShow = '';
    if (data) {
      for (var i = 0; i < data.length; i++) {
        var e = data[i];
        isPression = e.category_isPression == 1;
        if (isPression) {
          toShow += "<table class='categorytable'><tr class='categorytr cathead'><th class='categoryth categorytdstart'>Nom</th><th class='categoryth categorytdstart'>Type</th><th class='categoryth categorytdstart'>Demi</th><th class='categoryth categorytdstart'>Pinte</th><th class='categoryth'>Metre</th></tr>";
        } else {
          toShow += "<div id='' class='category'><div id='' class='category_name'>" + e.category_name + "</div><div id='' class='category_product'>";
        }

        for (var j = 0; j < e.product.length; j++) {
          var f = e.product[j];
          if (isPression) {
            toShow += "<tr class='categorytr'><td class='categorytd categorytdstart'>" + f.product_name + "</td><td class='categorytd categorytdstart'>" + f.product_pression_type + "</td><td class='categorytd categorytdstart'>" + f.product_pression_price_demi + "</td><td class='categorytd categorytdstart'>" + f.product_pression_price_pinte + "</td><td class='categorytd'>" + f.product_pression_price_metre + "</td></tr>";
          } else {
            toShow += "<div id='' class='product'><div id='' class='product_name'>" + f.product_name + "</div><div id='' class='product_price'>" + f.product_price + " €</div></div>";
          }
        }
        if (isPression) {
          toShow += "</table>";
        } else {
          toShow += "</div></div>";
        }

      }
      $('#consos').html(toShow);
    }
  }
}

function update_show_screen_event(json_response){
  toShow='';
  for (var index = 0; index < json_response.length; index++) {
    var element = json_response[index];
    toShow+="<div id='' class='event_card'><div id='' class='event_type'>";
    toShow+=element.type;
    toShow+="</div><div id='' class='event_name'>";
    toShow+=element.theme;
    toShow+="</div><div id='' class='event_date'>";
    toShow+=element.date;
    toShow+="</div><div id='' class='event_short_detail'>";
    toShow+=element.detail;
    toShow+="</div></div>";    
  }
  $('#events').html(toShow);
}
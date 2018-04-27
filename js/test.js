url_ = 'api_ajax?action=set_product&category_id=' + $('#affichage_add_product_category_select').val();
url_ += '&name=' + $('#affichage_add_product_name').val();
if ($("#affichage_add_product_isPression").is(':checked')) {
  url_ += '&isPression=1';
  url_ += '&demi_price=' + $('#affichage_add_product_demi_price').val();
  url_ += '&pinte_price=' + $('#affichage_add_product_pinte_price').val();
  url_ += '&metre_price=' + $('#affichage_add_product_metre_price').val();
  url_ += '&type=' + $('#affichage_add_product_type').val();
  url_ += '&brewery=' + $('#affichage_add_product_brewery').val();
  url_ += '&from=' + $('#affichage_add_product_from').val();
  url_ += '&degree=' + $('#affichage_add_product_degree').val();
} else {
  url_ += '&isPression=0';
  url_ += '&price=' + $('#affichage_add_product_price').val();
}
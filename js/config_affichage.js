var affichage = {
  "config": {},
  "affichageConfig": []
};
$(document).ready(function() {
  $('#affichage_new_category').hide();
  $('#affichage_new_product').hide();
  $('#affichage_add_category').hide();
  $('#affichage_add_product').hide();
  $('#affichage_edit_category').hide();
  $('#affichage_edit_product').hide();
  $('#affichage_config_category').hide();
  $('#affichage_config_product').hide();
  $('#affichage_category_settings').hide();
  $('#affichage_main_edit').hide();
  show_affichageConfig();
  var lastCategoryEdit;
  $('#save_affichage_category_settings').click(function() {
    var isVisible;
    if ($("#affichage_category_settings_isVisible").is(':checked')) {
      isVisible = 1;
    } else {
      isVisible = 0;
    }
    for (var i = 0; i < affichage[`affichageConfig`].length; i++) {
      var e = affichage[`affichageConfig`][i];
      if (e.category_id == lastCategoryEdit) {
        affichage[`affichageConfig`][i].visible = isVisible;
        break;
      }
    }
    $('#affichage_category_settings').hide('fast', function() {
      $('#affichage_main_edit').show('fast');
    });
  })
  $('#save_affichage_new_category').click(function() {
    if ($("input:checkbox[name='category']:checked").val()) {
      $('#save_affichage_new_category').attr("disabled", true);
      $("input:checkbox[name='category']:checked").each(function() {
        value = $('#' + this.id).val();
        for (var k = 0; k < json.length; k++) {
          var element = json[k];
          if (element.category_id == value) {
            if (affichage[`affichageConfig`]) {
              len = affichage[`affichageConfig`].length;
            } else {
              affichage[`affichageConfig`] = [];
              len = 0;
            }
            affichage[`affichageConfig`][len] = {
              'category_name': element.category_name,
              'category_id': Number(value),
              'visible': 1,
              'product': []
            };
            console.log()
            break;
          }
        }
      })
      show_affichageConfig();
      $('#affichage_new_category').hide('fast', function() {
        $('#affichage_main_edit').show('fast');
      });

    } else {
      notification.MaterialSnackbar.showSnackbar({
        message: 'aucune selection'
      });
    }
  })
  $('#save_affichage_new_product').click(function() {
    if ($("input:checkbox[name='product']:checked").val()) {
      $('#save_affichage_new_product').attr("disabled", true);
      $("input:checkbox[name='product']:checked").each(function() {
        value = $('#' + this.id).val();
        for (var k = 0; k < json.length; k++) {
          var element = json[k];
          if (element.product_id ==value) {
            for (var l = 0; l < affichage[`affichageConfig`].length; l++) {
              var r = affichage[`affichageConfig`][l];
              if (r.category_id == id) {
                affichage[`affichageConfig`][l].product[affichage[`affichageConfig`][l].product.length] = element;
              }
            }
            break;
          }
        }
      })
      show_affichageConfig();
      $('#affichage_new_product').hide('fast', function() {
        $('#affichage_main_edit').show('fast');
      });
      $('#save_affichage_new_product').attr("disabled", false);
    } else {
      notification.MaterialSnackbar.showSnackbar({
        message: 'aucune selection'
      });
    }
  })
   $('#save_affichage_add_product').click(function() {
    if ($('#affichage_add_product_category_select').val() != -1) {
      if ($('#affichage_add_product_name').val().length > 0) {
        url_ = 'api_ajax?action=add_product&category_id=' + $('#affichage_add_product_category_select').val();
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
              $("#affichage_add_product_text").html('');
              show_product_list();
              $('#affichage_add_product').hide('fast', function() {
                $('#affichage_config_product').show('fast');
              });
            }
          },
          error: function(response) {
            console.error(response);
          }
        });
      } else {
        notification.MaterialSnackbar.showSnackbar({
          message: 'this product as no name'
        });
      }
    } else {
      notification.MaterialSnackbar.showSnackbar({
        message: 'this product as no category'
      });
    }
  })
})

$('#config_affichage').click(function() {
  $('#affichage_new_category').hide();
  $('#affichage_new_product').hide();
  $('#affichage_add_category').hide();
  $('#affichage_add_product').hide();
  $('#affichage_edit_category').hide();
  $('#affichage_edit_product').hide();
  $('#affichage_config_category').hide();
  $('#affichage_config_product').hide();
  $('#affichage_category_settings').hide();
  $('#affichage_general_settings').show();
  $('#affichage_main_edit').hide();
  show_affichageConfig();
})

$('#affichage_actual_config').click(function() {

  $('#affichage_main_edit_title').html('config actual');
  url_ = 'api_ajax?action=get_config_affichage&actual';
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      affichage = JSON.parse(response);
      show_affichageConfig();
      $('#affichage_general_settings').hide('fast', function() {
        $('#affichage_main_edit').show('fast');
      });

    },
    error: function(response) {
      console.error(response);
    }
  });

})

$('#save_actual_affichage').click(function() {
  url_ = "api_ajax?action=save_config_affichage&config=" + JSON.stringify(affichage[`affichageConfig`]); // wip ajouter l'id de la config
  console.log(url_);
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      message = "success";
      notification.MaterialSnackbar.showSnackbar({
        message: message
      });
    },
    error: function(response) {
      console.error(response);
    }
  });
})

$('#add_category').click(function() {
  $('#save_affichage_new_category').attr("disabled", false);
  url_ = "api_ajax?action=get_category_list";
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      json = JSON.parse(response);
      if (affichage[`affichageConfig`]) {
        for (var i = 0; i < affichage[`affichageConfig`].length; i++) {
          var e = affichage[`affichageConfig`][i];
          for (var j = 0; j < json.length; j++) {
            var f = json[j];
            if (json[j].category_id == e.category_id) {
              json.splice(j, 1);
            }
          }
        }
      }

      var toShow;
      if (json.length !== 0) {
        toShow = "<div></br>";
        for (var index = 0; index < json.length; index++) {
          var element = json[index];
          toShow += '</br><label class="" for="category-' + element.category_id + '">';
          toShow += '<input type="checkbox" id="category-' + element.category_id + '" class="" name="category" value="' + element.category_id + '">';
          toShow += '<span class="">' + element.category_name + '</span>';
          toShow += '</label></br>';
        }
        toShow += '</div>';
      } else {
        toShow = 'no more result';
      }

      $('#affichage_new_category_text').html(toShow);
    },
    error: function(response) {
      console.error(response);
    }
  });
  $('#affichage_main_edit').hide('fast', function() {
    $('#affichage_new_category').show('fast');
  });
})

$('#affichage_category').click(function() {
  show_category_list();
  $('#affichage_general_settings').hide('fast', function() {
    $('#affichage_config_category').show('fast');
  });
})

function show_category_list() {
  url_ = 'api_ajax?action=list_category';
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      array = JSON.parse(response);
      if (array) {
        toShow = '<ul class="mdl-list">';
        for (var i = 0; i < array.length; i++) {
          var element = array[i];
          toShow += '<div class="mdl-list__item"><span class="mdl-list__item-primary-content">';
          toShow += '<span>' + element.category_name + '</span></span>';
          toShow += '<span class="mdl-list__item-secondary-content"><button class="affichage_config_category_text_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" id="affichage_config_category_text_button_' + element.category_id + '"><i class="material-icons">edit</i></button></span>';
          toShow += '</div>';
        }
        toShow += '</ul>';
      } else {
        toShow = "no result";
      }
      $("#affichage_config_category_text").html(toShow);
      $('.affichage_config_category_text_button').on('click', function() {
        $(this).off('click');
        id = this.id.slice(38);
        showDialog({
          title: 'category config',
          positive: {
            title: 'delete',
            onClick: function() {
              url_ = 'api_ajax?action=delete_category&id=' + id;
              $.ajax({
                type: "GET",
                url: url_,
                dataType: "html",
                success: function(response) {
                  array = JSON.parse(response);
                  notification.MaterialSnackbar.showSnackbar({
                    message: array.message
                  });
                  show_category_list();
                },
                error: function(response) {
                  console.error(response);
                }
              });
            }
          },
          negative: {
            title: 'rename',
            onClick: function() {
              url_ = 'api_ajax?action=category_info&category_id=' + id;
              $.ajax({
                type: "GET",
                url: url_,
                dataType: "html",
                success: function(response) {
                  array = JSON.parse(response);
                  $('#affichage_config_category').hide('fast', function() {
                    $('#affichage_edit_category').show('fast');
                  });
                  $('#name_edit_category').val(array.category_name);
                  $('#save_affichage_edit_category').click(function() {
                    if ($('#name_edit_category').val().length > 0) {
                      url_ = 'api_ajax?action=edit_category&category_id=' + id + '&name=' + $('#name_edit_category').val();
                      $.ajax({
                        type: "GET",
                        url: url_,
                        dataType: "html",
                        success: function(response) {
                          array = JSON.parse(response);
                          notification.MaterialSnackbar.showSnackbar({
                            message: array.message
                          });
                          show_category_list();
                          $('#affichage_edit_category').hide('fast', function() {
                            $('#affichage_config_category').show('fast');
                          });
                        },
                        error: function(response) {
                          console.error(response);
                        }
                      });
                    } else {
                      notification.MaterialSnackbar.showSnackbar({
                        message: 'no name'
                      });
                    }
                  })
                },
                error: function(response) {
                  console.error(response);
                }
              });
            }
          }
        });
      })
    },
    error: function(response) {
      console.error(response);
    }
  });
}

$('#affichage_product').click(function() {
  show_product_list();
  $('#affichage_general_settings').hide('fast', function() {
    $('#affichage_config_product').show('fast');
  });
})

function show_product_list() {
  url_ = 'api_ajax?action=list_category';
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      array = JSON.parse(response);
      toShow = '<div><select id="category_list_for_product"><option value=-1 selected>chose category</option>';
      for (var i = 0; i < array.length; i++) {
        var element = array[i];
        toShow += '<option value=' + element.category_id + '>' + element.category_name + '</option>';
      }
      toShow += '</select></div></br><div id="affichage_config_product_text_in"></div>';
      $('#affichage_config_product_text').html(toShow);
      $('#category_list_for_product').change(function() {
        url_ = 'api_ajax?action=list_product&category_id=' + $('#category_list_for_product').val();
        $.ajax({
          type: "GET",
          url: url_,
          dataType: "html",
          success: function(response) {
            array = JSON.parse(response);
            if (array) {
              toShow = '<ul class="mdl-list">';
              for (var i = 0; i < array.length; i++) {
                var element = array[i];
                toShow += '<div class="mdl-list__item"><span class="mdl-list__item-primary-content">';
                toShow += '<span>' + element.product_name + '</span></span>';
                toShow += '<span class="mdl-list__item-secondary-content"><button class="affichage_config_product_text_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" id="affichage_config_product_text_button_' + element.product_id + '"><i class="material-icons">edit</i></button></span>';
                toShow += '</div>';
              }
              toShow += '</ul>';
            } else {
              toShow = "no result";
            }
            $('#affichage_config_product_text_in').html(toShow);
            $('.affichage_config_product_text_button').on('click', function() {
              $(this).off('click');
              id = this.id.slice(37);
              url_ = 'api_ajax?action=product_info&product_id=' + id;
              $.ajax({
                type: "GET",
                url: url_,
                dataType: "html",
                success: function(response) {
                  array = JSON.parse(response);
                  text = 'nom : ' + array.product_name;
                  text += '</br>';
                  if (Number(array.product_isPression) === 0) {
                    text += 'prix : ' + array.product_price;
                  } else {
                    text += 'brasserie : ' + array.product_pression_brewery;
                    text += '</br>';
                    text += 'type : ' + array.product_pression_type;
                    text += '</br>';
                    text += 'from : ' + array.product_pression_from;
                    text += '</br>';
                    text += 'prix demi : ' + array.product_pression_price_demi;
                    text += '</br>';
                    text += 'prix pinte : ' + array.product_pression_price_pinte;
                    text += '</br>';
                    text += 'prix metre : ' + array.product_pression_price_metre;
                    text += '</br>';
                  }
                  showDialog({
                    title: 'product config',
                    text: text,
                    positive: {
                      title: 'delete',
                      onClick: function() {
                        url_ = 'api_ajax?action=product_delete&product_id=' + id;
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
                              show_product_list();
                            }
                          },
                          error: function(response) {
                            console.error(response);
                          }
                        });
                      }
                    },
                    negative: {
                      title: 'edit',
                      onClick: function() {
                        $("#affichage_edit_product_text").html('<div id="affichage_edit_product_category_select_div"></div></br><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_edit_product_name"><label class="mdl-textfield__label" for="affichage_edit_product_name">Name</label></div><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="affichage_edit_product_isPression"><input type="checkbox" id="affichage_edit_product_isPression" class="mdl-checkbox__input"><span class="mdl-checkbox__label">pression ?</span></label><div id="affichage_edit_product_isPression_false"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_edit_product_price"><label class="mdl-textfield__label" for="affichage_edit_product_price">price</label></div></div><div id="affichage_edit_product_isPression_true"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_edit_product_demi_price"><label class="mdl-textfield__label" for="affichage_edit_product_demi_price">demi price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_edit_product_pinte_price"><label class="mdl-textfield__label" for="affichage_edit_product_pinte_price">pinte price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_edit_product_metre_price"><label class="mdl-textfield__label" for="affichage_edit_product_metre_price">metre price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_edit_product_type"><label class="mdl-textfield__label" for="affichage_edit_product_type">type (blonde,blanche..)</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_edit_product_brewery"><label class="mdl-textfield__label" for="affichage_edit_product_brewery">brasserie</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_edit_product_from"><label class="mdl-textfield__label" for="affichage_edit_product_from">origine</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_edit_product_degree"><label class="mdl-textfield__label" for="affichage_edit_product_degree">degree d\'alcool</label></div></div>');
                        url_ = 'api_ajax?action=list_category';
                        $.ajax({
                          type: "GET",
                          url: url_,
                          dataType: "html",
                          success: function(response) {
                            j = JSON.parse(response);
                            toShow = '<select id="affichage_edit_product_category_select"><option value=-1 selected>chose category</option>';
                            for (var i = 0; i < j.length; i++) {
                              var element = j[i];
                              toShow += '<option value=' + element.category_id + '>' + element.category_name + '</option>';
                            }
                            toShow += '</select>';
                            $('#affichage_edit_product_category_select_div').html(toShow);
                            $('#affichage_edit_product_category_select').val(array.category_id);
                            $('#affichage_edit_product_name').val(array.product_name);
                            if (array.product_isPression == 1) {
                              $('#affichage_edit_product_isPression').prop('checked', true);
                              $('#affichage_edit_product_isPression_false').hide();
                              $('#affichage_edit_product_demi_price').val(array.product_pression_price_demi);
                              $('#affichage_edit_product_pinte_price').val(array.product_pression_price_pinte);
                              $('#affichage_edit_product_metre_price').val(array.product_pression_price_metre);
                              $('#affichage_edit_product_type').val(array.product_pression_type);
                              $('#affichage_edit_product_brewery').val(array.product_pression_brewery);
                              $('#affichage_edit_product_from').val(array.product_pression_from);
                              $('#affichage_edit_product_degree').val(array.product_pression_degree);
                            } else {
                              $('#affichage_edit_product_isPression').prop('checked', false);
                              $('#affichage_edit_product_isPression_true').hide();
                              $('#affichage_edit_product_price').val(array.product_price);
                            }
                          },
                          error: function(response) {
                            console.error(response);
                          }
                        });
                        $('#affichage_config_product').hide('fast', function() {
                          $('#affichage_edit_product').show('fast');
                        });
                        $('#affichage_edit_product_isPression').click(function() {
                          $('#affichage_edit_product_isPression_true').toggle('fast');
                          $('#affichage_edit_product_isPression_false').toggle('fast');
                        })
                        $('#save_affichage_edit_product').click(function() {
                          if ($('#affichage_edit_product_category_select').val() != -1) {
                            if ($('#affichage_edit_product_name').val().length > 0) {
                              url_ = 'api_ajax?action=edit_product&category_id=' + $('#affichage_edit_product_category_select').val();
                              url_ += '&name=' + $('#affichage_edit_product_name').val();
                              url_ += '&product_id=' + id;
                              if ($("#affichage_edit_product_isPression").is(':checked')) {
                                url_ += '&isPression=1';
                                url_ += '&demi_price=' + $('#affichage_edit_product_demi_price').val();
                                url_ += '&pinte_price=' + $('#affichage_edit_product_pinte_price').val();
                                url_ += '&metre_price=' + $('#affichage_edit_product_metre_price').val();
                                url_ += '&type=' + $('#affichage_edit_product_type').val();
                                url_ += '&brewery=' + $('#affichage_edit_product_brewery').val();
                                url_ += '&from=' + $('#affichage_edit_product_from').val();
                                url_ += '&degree=' + $('#affichage_edit_product_degree').val();
                              } else {
                                url_ += '&isPression=0';
                                url_ += '&price=' + $('#affichage_edit_product_price').val();
                              }
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
                                    $("#affichage_edit_product_text").html('');
                                    show_product_list();
                                    $('#affichage_edit_product').hide('fast', function() {
                                      $('#affichage_config_product').show('fast');
                                    });
                                  }
                                },
                                error: function(response) {
                                  console.error(response);
                                }
                              });
                            } else {
                              notification.MaterialSnackbar.showSnackbar({
                                message: 'this product as no name'
                              });
                            }
                          } else {
                            notification.MaterialSnackbar.showSnackbar({
                              message: 'this product as no category'
                            });
                          }
                        })
                      }
                    }
                  });
                },
                error: function(response) {
                  console.error(response);
                }
              });

            })
          },
          error: function(response) {
            console.error(response);
          }
        });
      });
    },
    error: function(response) {
      console.error(response);
    }
  });
}

$('#close_affichage_config_category').click(function() {
  $('#affichage_config_category').hide('fast', function() {
    $('#affichage_general_settings').show('fast');
  });
})

$('#close_affichage_config_product').click(function() {
  $('#affichage_config_product').hide('fast', function() {
    $('#affichage_general_settings').show('fast');
  });
})

$('#button_affichage_add_category').click(function() {
  $('#affichage_config_category').hide('fast', function() {
    $('#affichage_add_category').show('fast');
  });
})

$('#button_affichage_add_product').click(function() {
  update_product_add();
  show_select_for_product_add();
  $('#affichage_config_product').hide('fast', function() {
    $('#affichage_add_product').show('fast');
  });
})

function update_product_add() {
  $("#affichage_add_product_text").html('<div id="affichage_add_product_category_select_div"></div></br><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_add_product_name"><label class="mdl-textfield__label" for="affichage_add_product_name">Name</label></div><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="affichage_add_product_isPression"><input type="checkbox" id="affichage_add_product_isPression" class="mdl-checkbox__input"><span class="mdl-checkbox__label">pression ?</span></label><div id="affichage_add_product_isPression_false"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_add_product_price"><label class="mdl-textfield__label" for="affichage_add_product_price">price</label></div></div><div id="affichage_add_product_isPression_true"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_add_product_demi_price"><label class="mdl-textfield__label" for="affichage_add_product_demi_price">demi price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_add_product_pinte_price"><label class="mdl-textfield__label" for="affichage_add_product_pinte_price">pinte price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_add_product_metre_price"><label class="mdl-textfield__label" for="affichage_add_product_metre_price">metre price</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_add_product_type"><label class="mdl-textfield__label" for="affichage_add_product_type">type (blonde,blanche..)</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_add_product_brewery"><label class="mdl-textfield__label" for="affichage_add_product_brewery">brasserie</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" id="affichage_add_product_from"><label class="mdl-textfield__label" for="affichage_add_product_from">origine</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="number" step="0.01" id="affichage_add_product_degree"><label class="mdl-textfield__label" for="affichage_add_product_degree">degree d\'alcool</label></div></div>');
}

function show_select_for_product_add() {
  $('#affichage_add_product_isPression_true').hide();
  $('#affichage_add_product_isPression').click(function() {
    $('#affichage_add_product_isPression_true').toggle('fast');
    $('#affichage_add_product_isPression_false').toggle('fast');
  })
  url_ = 'api_ajax?action=list_category';
  $.ajax({
    type: "GET",
    url: url_,
    dataType: "html",
    success: function(response) {
      array = JSON.parse(response);
      toShow = '<select id="affichage_add_product_category_select"><option value=-1 selected>chose category</option>';
      for (var i = 0; i < array.length; i++) {
        var element = array[i];
        toShow += '<option value=' + element.category_id + '>' + element.category_name + '</option>';
      }
      toShow += '</select>';
      $('#affichage_add_product_category_select_div').html(toShow);
    },
    error: function(response) {
      console.error(response);
    }
  });
}

$('#close_affichage_add_category').click(function() {
  $('#affichage_add_category').hide('fast', function() {
    $('#affichage_config_category').show('fast');
  });
})

$('#close_affichage_add_product').click(function() {
  $('#affichage_add_product').hide('fast', function() {
    $('#affichage_config_product').show('fast');
  });
})

$('#close_affichage_edit_category').click(function() {
  $('#affichage_edit_category').hide('fast', function() {
    $('#affichage_config_category').show('fast');
  });
})

$('#close_affichage_edit_product').click(function() {
  $('#affichage_edit_product').hide('fast', function() {
    $('#affichage_config_product').show('fast');
  });
})

$('#save_affichage_add_category').click(function() {
  url_ = 'api_ajax?action=add_category&name=' + $("#name_add_category").val();
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
        $("#name_add_category").val(null);
        show_category_list();
        $('#affichage_add_category').hide('fast', function() {
          $('#affichage_config_category').show('fast');
        });
      }
    },
    error: function(response) {
      console.error(response);
    }
  });
})

$('#close_affichage_main_edit').click(function() {
  $('#affichage_main_edit').hide('fast', function() {
    $('#affichage_general_settings').show('fast');
  });
})

$('#close_affichage_new_category').click(function() {
  $('#affichage_new_category').hide('fast', function() {
    $('#affichage_main_edit').show('fast');
  });
})

$('#close_affichage_new_product').click(function() {
  $('#affichage_new_product').hide('fast', function() {
    $('#affichage_main_edit').show('fast');
  });
})

$('#close_affichage_category_settings').click(function() {
  $('#affichage_category_settings').hide('fast', function() {
    $('#affichage_main_edit').show('fast');
  });
})

function show_affichageConfig() {
  var toShow = '';
  if (affichage[`affichageConfig`]) {
    for (var index = 0; index < affichage[`affichageConfig`].length; index++) {
      var element = affichage[`affichageConfig`][index];
      if (element.visible == 1) {
        toShow += '<div id="" class="modulable_card mdl-cell mdl-card mdl-shadow--2dp"><div class="mdl-card__title">';
        toShow += '<h2 class="mdl-card__title-text">' + element.category_name + '</h2></div><div class="mdl-card__supporting-text" id="">';
        for (var i = 0; i < element.product.length; i++) {
          var e = element.product[i];
          toShow += '<span class="mdl-chip mdl-chip--deletable">';
          toShow += '<span class="mdl-chip__text">' + e.product_name + '</span>';
          toShow += '<button type="button" class="afficheConfigRemoveProductButton mdl-chip__action" id="afficheConfigRemoveProductButton' + e.product_id + '"><i class="material-icons">cancel</i></button>';
          toShow += '</span>';

        }
        toShow += '</div><div class="mdl-card__menu">';
        toShow += '<button class="afficheConfigSettingsButton mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="afficheConfigSettingsButton' + element.category_id + '"><i class="material-icons" disabled>settings</i></button>';
        toShow += '<button class="afficheConfigAddButton mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="afficheConfigAddButton' + element.category_id + '"><i class="material-icons">add_circle</i></button>';
        toShow += '<button class="afficheConfigRemoveButton mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="afficheConfigRemoveButton' + element.category_id + '"><i class="material-icons">cancel</i></button>';
        toShow += '</div></div>';
      }
    }

  }

  $("#affichage_main_text").html(toShow);

  $('.afficheConfigRemoveProductButton').on('click', function() {
    $(this).off('click');
    id = this.id.slice(32);
    for (var index = 0; index < affichage[`affichageConfig`].length; index++) {
      for (var index2 = 0; index2 < affichage[`affichageConfig`][index].product.length; index2++) {
        if (affichage[`affichageConfig`][index].product[index2].product_id == id) {
          affichage[`affichageConfig`][index].product.splice(index2, 1);
          show_affichageConfig();
          break;
        }
      }
    }
  })

  $('.afficheConfigRemoveButton').on('click', function() {
    $(this).off('click');
    id = this.id.slice(25);
    for (var index = 0; index < affichage[`affichageConfig`].length; index++) {
      if (affichage[`affichageConfig`][index].category_id == id) {
        affichage[`affichageConfig`].splice(index, 1);
        show_affichageConfig();
        break;
      }
    }
  })

  $('.afficheConfigAddButton').on('click', function() {
    $(this).off('click');
    id = this.id.slice(22);
    url_ = "api_ajax?action=get_product_list&id=" + id;
    $.ajax({
      type: "GET",
      url: url_,
      dataType: "html",
      success: function(response) {
        json = JSON.parse(response);
        for (var i = 0; i < affichage[`affichageConfig`].length; i++) {
          var e = affichage[`affichageConfig`][i];
          if (e.category_id == id) {
            for (var j = 0; j < e.product.length; j++) {
              var f = e.product[j];
              for (var k = 0; k < json.length; k++) {
                var g = json[k];
                if (Number(g.product_id) == f.product_id) {
                  json.splice(k, 1);
                }
              }
            }
          }
        }
        var toShow;
        if ((json)) {
          if (json.length !== 0) {
            toShow = "<div></br>";
            for (var index = 0; index < json.length; index++) {
              var element = json[index];
              toShow += '</br><label class="" for="product-' + element.product_id + '">';
              toShow += '<input type="checkbox" id="product-' + element.product_id + '" class="" name="product" value="' + element.product_id + '">';
              toShow += '<span class="">' + element.product_name + '</span>';
              toShow += '</label></br>';
            }
            toShow += '</div>';
          } else {
            toShow = 'no more product';
          }
        } else {
          toShow = 'no product';
        }

        $('#affichage_new_product_text').html(toShow);
      },
      error: function(response) {
        console.error(response);
      }
    });
    $('#affichage_main_edit').hide('fast', function() {
      $('#affichage_new_product').show('fast');
    });
  })

  $('.afficheConfigSettingsButton').on('click', function() {
    $(this).off('click');
    id = Number(this.id.slice(27));
    lastCategoryEdit = id;
    for (var i = 0; i < affichage[`affichageConfig`].length; i++) {
      var element = affichage[`affichageConfig`][i];
      if (element.category_id == id) {
        if (affichage[`affichageConfig`][i].visible == 1) {
          $('.affichage_category_settings_isVisible').each(function(index, element) {
            element.MaterialCheckbox.check();
          });
        } else {
          $('.affichage_category_settings_isVisible').each(function(index, element) {
            element.MaterialCheckbox.uncheck();
          });
        }
        break;
      }
    }
    $('#affichage_main_edit').hide('fast', function() {
      $('#affichage_category_settings').show('fast');
    });
  })
}
function showSnackbar() {
  $('#snackbar').addClass('show_snackbar');
}

function hideSnackbar() {
  $('#snackbar').removeClass('show_snackbar');
}

function callSnackbar(data) {
  if (data.message) {
    $('#snackbar').html(data.message);
    showSnackbar();
    if (data.time) {
      setTimeout(hideSnackbar, data.time);
    } else {
      setTimeout(hideSnackbar, 5000);
    }
  } else {
    console.error('no message');
  }

}

// callSnackbar({
//   message: 'salut les loulous', time : 2000
// });
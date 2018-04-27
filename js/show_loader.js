function showPage() {
  $('#theater1').addClass('hidetheater1');
  $('#theater2').addClass('hidetheater2');
}

function hidePage() {
  $('#theater1').removeClass('hidetheater1');
  $('#theater2').removeClass('hidetheater2');
}

$(window).load(function() {
  setTimeout(showPage, 600);
});
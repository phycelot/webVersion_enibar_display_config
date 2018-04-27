function updateShow() {
  var theme = document.getElementById('themeSwitch').checked;
  var bouffe = document.getElementById('bouffeSwitch').checked;
  var boisson = document.getElementById('boissonSwitch').checked;

  if (theme){
    document.getElementById('themeStuff').className = 'ouvert';
  } else {
    document.getElementById('themeStuff').className = 'ferme';
  }
  if (bouffe){
    document.getElementById('bouffeStuff').className = 'ouvert';
  } else {
    document.getElementById('bouffeStuff').className = 'ferme';
  }
  if (boisson){
    document.getElementById('boissonStuff').className = 'ouvert';
  } else {
    document.getElementById('boissonStuff').className = 'ferme';
  }

}
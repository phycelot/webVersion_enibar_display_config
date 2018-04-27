function testUpdate(mode){
  if(mode=='normal'){
    document.getElementById('theme').className = 'ferme';
    document.getElementById('bouffe').className = 'ferme';
    document.getElementById('boisson').className = 'ferme';
  }
  else if (mode=='apero'){
    document.getElementById('theme').className = 'ouvert';
    document.getElementById('bouffe').className = 'ouvert';
    document.getElementById('boisson').className = 'ouvert';
  }
  else if (mode=='nolimit'){
    document.getElementById('theme').className = 'ouvert';
    document.getElementById('bouffe').className = 'ouvert';
    document.getElementById('boisson').className = 'ouvert';
  }
}
  
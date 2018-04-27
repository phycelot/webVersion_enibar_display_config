var loaderVar;

function loader() {
    loaderVar = setTimeout(showPage, 300);
}

function showPage() {
  document.getElementById("main").classList.remove('close');
  document.getElementById("loader").classList.add('close');
}
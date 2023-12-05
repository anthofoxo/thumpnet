const args = document.currentScript.dataset;
let xhr = new XMLHttpRequest();
xhr.open("GET", args.fetch, false);
xhr.send();
document.getElementById(args.target).innerHTML = xhr.responseText;

// Theme JavaScript
function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    } 
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function setText(id,newvalue) {
  var s= document.getElementById(id);
  s.innerHTML = newvalue;
}

window.onload=function() {
  var naav = getParameterByName('naav');
  setText("naav_result", naav);
}

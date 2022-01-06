// creating active table to display comes from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_active_element and https://www.w3schools.com/howto/howto_js_active_element.asp
var line = document.getElementsByClassName("line");
for (var i = 0; i < line.length; i++) {
  line[i].addEventListener("click", function () {
    if (this.className.includes(" active")) {
      this.className = this.className.replace(" active", "");
    } else {
      var current = document.getElementsByClassName("active");
      if (current.length > 0) { // when we have another active we need to handle this so only one active at a time
        current[0].className = current[0].className.replace(" active", "");
      }
      this.className += " active";
    }
  });
}

// the onclick passing elem comes from https://www.w3schools.com/jsref/event_onclick.asp
function rowdisplay(elem, row) {
  var rows = document.getElementsByClassName(row);
  if (elem.className.includes(" active")) {
    elem.className = elem.className.replace(" active", "");
    for (var i = 0; i < rows.length; i++) {
      rows[i].className += " details";
    }
  } else {
    elem.className = elem.className + " active";
    for (var i = 0; i < rows.length; i++) {
      rows[i].className = rows[i].className.replace(" details", "");
    }
  }
}

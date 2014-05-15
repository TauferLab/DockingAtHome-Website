<!--

/*
	Global Javascript file for website.
	Manages global cached images and Javascript functions.
*/

// Global cached images for preloading effects
var cachedLoginButton_over=new Image();
cachedLoginButton_over.src='/images/login_button_over.png';

// Functions and variables for easily selecting a random image
var currentDate = new Date();
var currentDateSeconds = currentDate.getSeconds();

function ImageArray (length) {
  this.length = length;
  for (var i =1; i <= n; i++) {
    this[i].src = new String();
	this[i].description = new String();
  }
}

function randomNumber (arrayLength) {
	return Math.floor(currentDateSeconds/(60/arrayLength));
}


// Functions for easily showing and hiding objects (cross-browser safe)
function show(object) {
  if (document.getElementById) {
    document.getElementById(object).style.display = 'inline';
  }
  else if (document.layers && document.layers[object]) {
    document.layers[object].visibility = 'visible';
  }
  else if (document.all) {
    document.all[object].style.visibility = 'visible';
  }
}

function hide(object) {
  if (document.getElementById) {
    document.getElementById(object).style.display = 'none';
  }
  else if (document.layers && document.layers[object]) {
    document.layers[object].visibility = 'hidden';
  }
  else if (document.all) {
    document.all[object].style.visibility = 'hidden';
  }
}

//-->

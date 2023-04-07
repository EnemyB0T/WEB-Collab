var canvas = document.getElementById("sketchpad");
var ctx = canvas.getContext("2d");
var pos = { x: 0, y: 0 };
var color = "#000000";
var width = 20;

// set default color and canvas dimensions
setCurrentColor(color);
ctx.canvas.width = window.innerWidth;
ctx.canvas.height = window.innerHeight - 150;

/*********************** WELCOME MODAL ***********************/
$(document).ready(function(){
  $("#myModal").modal('show');
});

/*********************** PEN WIDTH SLIDER ***********************/
$(function() {
   $( "#slider-2" ).slider({
      value: 20,
      min: 5,
      animate:"slow",
      orientation: "horizontal"
   });
});

/*********************** COLOR PICKER ***********************/
$('.colors').on('click','td', function(){
    // console.log($(this).css('background-color'));
    // color = $(this).css('background-color');
    console.log($(this).attr("bgcolor"));
    color = $(this).attr("bgcolor");
    setCurrentColor(color);
});

function setCurrentColor(color) {
  $(".currentColor").css("background-color", color);
  if (color == "#000000") {
    $(".currentColor").css("color", "#FFFFFF");
  } else {
    $(".currentColor").css("color", "#000000");
  }
}

/*********************** RESET BUTTON ***********************/
$('.reset').on('click', function(){
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    color = "#000000";
    setCurrentColor(color);
    $("#slider-2").slider("value", 20);
});

/***************************************************************************
The functions below are borrowed from a canvas example and used for the
actual pen / canvas functionality.
****************************************************************************/

// add event listeners to specify when functions should be triggered
document.addEventListener("mousemove", draw);
document.addEventListener("mousedown", setPosition);
document.addEventListener("mouseenter", setPosition);

// new position from mouse events
function setPosition(event) {
  pos.x = event.clientX;
  pos.y = event.clientY - 150;
}

function draw(event) {
  if (event.buttons !== 1) return;

  var width = $("#slider-2").slider("value");
  ctx.beginPath();

  ctx.lineWidth = width; // line width determined by slider
  ctx.lineCap = "round";
  ctx.strokeStyle = color; // color of line determined by color picker

  ctx.moveTo(pos.x, pos.y); // from position
  setPosition(event);
  ctx.lineTo(pos.x, pos.y); // to position

  ctx.stroke();
}

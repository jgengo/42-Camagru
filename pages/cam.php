<?php 
// require_once('../config/functions.php');
if (is_logged()) { 
?>
<h2 id='page_title'>Cam</h2>

<video name='cam' id='cam' autoplay></video>
<img id="image" style="display: none;"/>
<div id="canvasvideo"></div>

<input type='submit' value='Submit this pic' id='video_form' />

<div class='filter_cont'>
<div id='filter1' class='filter'><img src='filters/filter1.png' /></div>
<div id='filter2' class='filter'><img src='filters/filter2.png' /></div>
<div id='filter3' class='filter'><img src='filters/filter3.png' /></div>
<div id='filter4' class='filter'><img src='filters/filter4.png' /></div>
<div id='filter5' class='filter'><img src='filters/filter1.png' /></div>

</div>
<input type='file' accept="image/*" onchange="readURL(this);" id='upload_form' />
<canvas id="canvas"></canvas>
<script>
(function() {
  image_statut = false;
  var streaming       = false,
      video           = document.querySelector('#cam'),
      canvas          = document.querySelector('#canvas'),
      photo           = document.querySelector('#photo'),
      startbutton     = document.querySelector('#video_form'),
      image           = document.querySelector('#image'),
      width           = 320,
      height          = 0;

  navigator.getMedia  = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);
    navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      image.setAttribute('width', width);
      image.setAttribute('height', height);
      image
      streaming = true;
    }
  }, false);

  function takepicture() {
    if (image_statut || streaming)
    {
      if (image_statut)
      {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(image, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
      }
      else
      {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
      }
      var http = new XMLHttpRequest();
      var params = "pic="+data;
      http.open("POST", "functions/add_pic.php");
      http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http.onreadystatechange = function() {
        if (http.readyState == 4 && http.status == 200) {
          // alert(http.responseText);
        }
      }
    http.send(params);
    } else { alert('nothing to take'); }
  }
  startbutton.addEventListener('click', function(ev){
      if (!streaming && !image_statut)
        alert('cam is disabled and file not uploaded');
      else 
        takepicture();
    ev.preventDefault();
  }, false);

})();

var tlists = document.querySelectorAll(".filter"),
  doSomething = function() {
    var img = new Image();
    img.src = this.childNodes[0].src;
    
    var canvass = document.createElement('canvas');
    var context = canvass.getContext('2d');
    canvass.width = 640;
    canvass.height = 480;
    canvass.draggable = true;
    canvass.id = "filtercanvas";
    // canvass.addEventListener("click", getClickPosition, false);
    document.querySelector('#canvasvideo').appendChild(canvass);
    context.drawImage(img, 50, 50, 150, 150);
    };
[].map.call(tlists, function(elem) {
    elem.addEventListener("click", doSomething, false);
}); 

function readURL(input) {
      var video         = document.querySelector('#cam'),
          canvas        = document.querySelector('#canvas'),
          photo         = document.querySelector('#photo'),
          startbutton   = document.querySelector('#video_form'),
          image         = document.querySelector('#image'),
          width         = 320;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        image = document.getElementById('image');
        reader.onload = function(e) {
            image.style.display = "";
            image.setAttribute('src', e.target.result);
            image.width = 320;
            if (video.style.display != "none") { video.style.display = "none"; }
        };

        reader.readAsDataURL(input.files[0]);
    }
    image_statut = true;
}

</script>

<?php 
} else {
  include("assets/forbidden.html");
}
?>

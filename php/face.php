<!DOCTYPE html>
<html>
<head>
    <title></title>
         <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">
     <link href="../css/rs_style.css" rel="stylesheet">
      <script src="../vendor/jquery/jquery.min.js"></script>
</head>
<body>

<div>
    <video id="live" width="320" height="240" autoplay style="display: inline;"></video>
    <canvas width="320" id="canvas" height="240" style="display: inline;"></canvas>
</div>
 
 <script type="text/javascript">
    var video = $("#live").get()[0];
    var canvas = $("#canvas");
    var ctx = canvas.get()[0].getContext('2d');
 
    // navigator.webkitGetUserMedia("video",
    //         function(stream) {
    //             video.src = webkitURL.createObjectURL(stream);
    //         },
    //         function(err) {
    //             console.log("Unable to get video stream!")
    //         }
    // )
    if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        //video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        //video.play();
    });
}

     var ws = new WebSocket("ws://127.0.0.1:9999");
    ws.onopen = function () {
              console.log("Openened connection to websocket");
    }

   timer = setInterval(
            function () {
                ctx.drawImage(video, 0, 0, 320, 240);
                var data = canvas.get()[0].toDataURL('image/jpeg', 1.0);
                newblob = dataURItoBlob(data);
                ws.send(newblob);
            }, 250);
    
    
</script>

</body>
</html>
<!-- <script type="text/javascript">


    var video = document.getElementById('live');

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        //video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        //video.play();
    });
}

</script> -->
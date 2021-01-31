<?php include("support/nav.php"); ?>
<hr>
<br>
<?php include("upload_picture.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .container{
            width: 500px;
            margin: 0 auto;
        }
        .video{
          width: 350px;
          height: 300px;
        }
        .video .overlay {
          position: relative;
          margin-top: -300px;
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;
          height: 300px;
          width: 350px;
          z-index: 1;
          transition: .5s ease;
          background-color: rgba(255, 255, 255, 0.5);
        }
        video{
            width: 350px;
            height: 300px;
        }
        button{
            margin: 10px;
            padding: 20px;
            border-radius: 1;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel = "stylesheet" type = "text/css" href = "css/styles.css">
</head>
<body>
<br>
<div class="container">
    <div class="capture">
      <div>
        <div class="video">
          <video autoplay id="video"></video>
          <div class="overlay">
            <img id="sticker" width="150px" height="250px">
          </div>
        </div>
        <select id="select_sticker" onchange="loadSticker()">
            <option value="">none</option>
            <option value="Spider.png">spider man</option>
            <option value="John-Cena.png">John Cena</option>
            <option value="one_piece.jpg">One piece</option>
            <option value="law.jpg">Law</option>
            <option value="Kevin-Durant.png">Kevin Durant</option>
        </select>
        <canvas id="canvas" hidden></canvas>
        <div>
        <br>
        <form method='post' action='' enctype='multipart/form-data'>
        <input type='file' name='files[]' multiple />
        <input type='submit' value='Upload Picture' name='submit' />
        </form>
        <br><br>
        </div>
        <button id="button">Capture Photo</button><br>
      </div>
    </div>
    </div>
</div>
<div>
      <img style="position: relative; left: 272px; top: -470px; height: 300px; width: 350px;" id="final" >
      <div>
<script src="js/script.js"></script>
<?php include 'support/footer.php';?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚗</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
    <title>PaceMon</title>
</head>
<style type="text/css">
    *{
        font-family: 'Varela Round', sans-serif;
    }
    .data{
        margin-top:30px;
    }
    .detection{
        margin-top:30px;
    }
    .form{
        margin-bottom:30px;
    }
</style>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
    <div class="container-fluid ">
        <a class="navbar-brand" href="index.php">PaceMon</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
            <li class="nav-item">
            <a class="nav-link" href="npr.php">Detect Number Plate</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
</body>
<div class="container data">
    <div class="form">
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="file" name="uploadfile" value="" />
        <div>
            <button class="btn btn-primary"type="submit" name="upload">
              UPLOAD
            </button>
        </div>
    </form>
    </div>
    <?php
        include('./db.php');
        $msg='';
        $filename='';

        if(isset($_POST['upload'])) {
            $filename = $_FILES["uploadfile"]["name"];
            $src='./npr-images/'.$filename;
            move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$src);
        }
        

        $command = escapeshellcmd('python3 ./npr.py '.$filename.'');
        $output = shell_exec($command);
    ?>
    <img src="./npr-images/<?php echo $filename?$filename:''; ?>" alt="" height="200" width="250"/>
    <p class="detection">Detected Number is : <strong><?php echo $output?$output:''; ?></strong></p>
</div>
</html>

<?php


include('./db.php');
$cam_records =DB::query('SELECT * FROM camdata');

// foreach($cam_records as $cam_record){
//     echo "id :".$cam_record['id'];
//     echo "speed :".$cam_record['speed'];
//     echo "time :".$cam_record['timeCaptured'];
//     echo "exceeded :".$cam_record['exceeded'];
//     echo "cam name :".$cam_record['camName'];
//     echo '<img src="data:image/jpeg;base64,'.base64_encode($cam_record['image']) .'" height="100" width="100" />';
//     echo '<br /><hr/>';
// }

?>

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
    #dataTable{
        margin-top:30px;
        overflow: hidden;
    }
    .dataTables_wrapper{
        overflow: hidden;
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

    <div class="container data">
        <div class=" table-bordered table-striped">
            <table class="table" id="dataTable">
                <thead>  
                    <tr>  
                        <td>ID</td>  
                        <td>Image</td>  
                        <td>Captured Time</td>  
                        <td>Speed</td>  
                        <td>has Exceeded?</td>
                        <td>Camera Name</td>  
                    </tr>  
                </thead>  
                <?php
                foreach($cam_records as $cam_record){
                    echo'
                    <tr>
                    <td>'.$cam_record["id"].'</td>
                    <td><img src="data:image/jpeg;base64,'.base64_encode($cam_record['image']) .'" height="50" width="50" /></td>
                    <td>'.$cam_record["timeCaptured"].'</td>
                    <td>'.$cam_record["speed"].'</td>
                    <td>'.($cam_record["exceeded"]==1?'Yes':'No').'</td>
                    <td>'.$cam_record["camName"].'</td>
                    </tr>
                ';
                }
                


                ?>
            </table>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<script>  
 $(document).ready(function(){  
      $('#dataTable').DataTable();  
 }); 
</script>
</html>

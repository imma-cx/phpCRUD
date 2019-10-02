<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">

    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<?php
require_once "config.php";
require_once "security.php";

// comment this line to byposs scrubInput (sanitization)
$_POST = scrubInput($_POST, 'post');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
      }
      else{
          $name = $input_name;
      }
    }
?>
<div>
<form method="post" action="find.php">
  Name: <input type="text" name="name" >
  <input type="submit" value="Search" />
</form>
</div>
<div>
<?php
      if(empty($name_err)){
          $sql = "SELECT * FROM userinfo WHERE name = '" . $name ."'";
          echo $sql . "<br />";
           $result = mysqli_query($link, $sql);
            //$result = $link->store_result();
            if (mysqli_num_rows($result) > 0){
                echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Name</th>";
                            echo "<th>Address</th>";
                            echo "<th>Date of Birth</th>";
                            echo "<th>Action</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['dateofbirth'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                    echo "</table>";
                    // Free result set
                    mysqli_free_result($result);
                } else{
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
              }


?>
</div>
</body>
</html>

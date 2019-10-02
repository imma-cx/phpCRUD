<?php
require_once "config.php";
require_once "security.php";

$name = $address = $dateofbirth = "";
$name_err = $address_err = $dateofbirth_err = "";

$_POST = scrubInput($_POST, 'post');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";

      // using scrubInput - security.php
    } //elseif($_POST){
      //  $name_err = "Please enter a valid name.";

    //} elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        // $name_err = "Please enter a valid name.";
    //}
    else{
        $name = $input_name;
    }

    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";
    } else{
        $address = $input_address;
    }

    $input_dateofbirth = trim($_POST["dateofbirth"]);
    if(empty($input_dateofbirth)){
        $dateofbirth_err = "Please enter the users date of birth";
    } elseif(!ctype_digit($input_dateofbirth)){
        $dateofbirth_err = "Please enter a valid date of birth.";
    } else{
        $dateofbirth = $input_dateofbirth;
    }

 // without mysqli prepared statements
    if(empty($name_err) && empty($address_err) && empty($dateofbirth_err)){
        $sql = "INSERT INTO userinfo (name, address, dateofbirth) VALUES ('" . $name ."', '" . $address . "', " . $dateofbirth . ")";
        if ($link->multi_query($sql) === TRUE) {

        //if(isset($query)){
          header("location: index.php");
          exit();
        } else{
          echo "Something went wrong. Please try again later." . "<br />" . $sql . "<br />" . mysqli_error($link);
        }

/*
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_dateofbirth);

            $param_name = $name;
            $param_address = $address;
            $param_dateofbirth = $dateofbirth;

            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
*/
      //  mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add user record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($dateofbirth_err)) ? 'has-error' : ''; ?>">
                            <label>Date of Birth</label>
                            <input type="text" name="dateofbirth" class="form-control" value="<?php echo $dateofbirth; ?>">
                            <span class="help-block"><?php echo $dateofbirth_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

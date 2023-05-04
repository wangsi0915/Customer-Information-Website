<?php
// Include customerDAO file
require_once('./dao/customerDAO.php');
 
// Define variables and initialize with empty values
$name = $age = $email = $join_date = $address = $reward_point = $image = "";
$name_err = $age_err = $email_err = $join_date_err = $address_err = $reward_point_err = $image_err ="";
$customerDAO = new customerDAO(); 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate age from 0 to 150
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter an age.";
    } elseif(!is_numeric($input_age)){
        $age_err = "Age must be a number.";
    } elseif($input_age < 0 || $input_age > 150){
        $age_err = "Please enter a number between 0 and 150.";
    } else{
        $age = $input_age;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";
    } elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
        $email_err = "Please enter the valid email.";
    } else{
        $email = $input_email;
    }

    // Validate join date
    $input_join_date = trim($_POST["join_date"]);
    if(empty($input_join_date)){
        $join_date_err = "Please enter a join date.";
    } elseif(strtotime($input_join_date) === false){
        $join_date_err = "Please enter a date in the format YYYY-MM-DD.";
    } elseif($input_join_date > date('Y-m-d')) {
        $join_date_err = "Join date cannot be a future date.";
    }else{
        $join_date = $input_join_date;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }

    // Validate reward_point
    $input_reward_point = trim($_POST["reward_point"]);
    if(empty($input_reward_point)){
        $reward_point_err = "Please enter the reward_point amount.";     
    } elseif(!ctype_digit($input_reward_point)){
        $reward_point_err = "Please enter a positive integer value.";
    } else{
        $reward_point = $input_reward_point;
    }
    
    // upload the image
    if($_FILES["file"]["name"] == null){
        $image = '';
    }
    else{
        $target_file = "images/".basename($_FILES["file"]["name"]);
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
            $image = $target_file;
        }
        else{
            $image_err = "Please upload your image";
        }
    }

    // Check input errors before inserting in database
    if(empty($name_err)  && empty($age_err)  && empty($email_err)  && empty($join_date_err) && empty($address_err) && empty($reward_point_err)&& empty($image_err)){
        $customer = new Customer($id, $name, $age, $email, $join_date, $address, $reward_point, $image);
        $result = $customerDAO->updateCustomer($customer);        
		header("refresh:2; url=index.php");
		echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $customerDAO->getMysqli()->close();
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $customer = $customerDAO->getCustomer($id);               
        if($customer){
            // Retrieve individual field value
            $name = $customer->getName();
            $age = $customer->getAge();
            $email = $customer->getEmail();
            $join_date = $customer->getJoinDate();
            $address = $customer->getAddress();
            $reward_point = $customer->getRewardPoint();
            $image = $customer->getImage();
        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $customerDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the customer record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Join Date</label>
                            <input type="date" name="join_date" class="form-control <?php echo (!empty($join_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $join_date; ?>">
                            <span class="invalid-feedback"><?php echo $join_date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Reward Points</label>
                            <input type="text" name="reward_point" class="form-control <?php echo (!empty($reward_point_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reward_point; ?>">
                            <span class="invalid-feedback"><?php echo $reward_point_err;?></span>
                        </div>
                        <div class="form_group">
                            <label for="file">Select a file:</label>
                            <input type="file" name="file" id="file">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
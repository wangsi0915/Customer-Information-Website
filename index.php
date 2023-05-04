<?php require_once('./dao/customerDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 980px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="customer">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Customers Information</h2>
                        <a href="create.php" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Customer</a>
                    </div>
                    <?php
                        $customerDAO = new customerDAO();
                        $customers = $customerDAO->getCustomers();
                        
                        if($customers){
                            echo '<table class="table table-bordered table-striped table table-hover">';
                                echo '<thead class="table-dark">';
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Age</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Join Date</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Reward Point</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach($customers as $customer){
                                    echo "<tr>";
                                        echo "<td>" . $customer->getId(). "</td>";
                                        echo "<td>" . $customer->getName() . "</td>";
                                        echo "<td>" . $customer->getAge() . "</td>";
                                        echo "<td>" . $customer->getEmail() . "</td>";
                                        echo "<td>" . $customer->getJoinDate() . "</td>";
                                        echo "<td>" . $customer->getAddress() . "</td>";
                                        echo "<td>" . $customer->getRewardPoint() . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $customer->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $customer->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $customer->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            //$result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                   
                    // Close connection
                    $customerDAO->getMysqli()->close();
                    include 'footer.php';
                    ?>
                </div>
            </div>        
        </div>
    </div>

</body>
</html>
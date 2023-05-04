<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');

class customerDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getCustomer($customerId){
        $query = 'SELECT * FROM customers WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $customer = new customer($temp['id'],$temp['name'], $temp['age'], $temp['email'], $temp['join_date'], $temp['address'], $temp['reward_point'], $temp['image']);
            $result->free();
            return $customer;
        }
        $result->free();
        return false;
    }


    public function getCustomers(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM customers');
        $customers = Array();

        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new customer object, and add it to the array.
                $customer = new Customer($row['id'],$row['name'], $row['age'], $row['email'], $row['join_date'], $row['address'], $row['reward_point'],$row['image']);
                // adding the $customer object to the end of the $customers array.
                $customers[] = $customer;
            }
            $result->free();
            return $customers;
        }
        $result->free();
        return false;
    }   
    
    public function addCustomer($customer){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO customers (name, age, email, join_date, address, reward_point, image) VALUES (?,?,?,?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                      $id = $customer->getId();
                      $name = $customer->getName();
                      $age = $customer->getAge();
                      $email = $customer->getEmail();
                      $join_date = $customer->getJoinDate();
                      $address = $customer->getAddress();
                      $reward_point = $customer->getRewardPoint();
                      $image = $customer->getImage();

			        $stmt->bind_param('sisssis', 
				        $name,
                        $age,
                        $email,
                        $join_date,
                        $address,
                        $reward_point,	
                        $image,			       
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $customer->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function updateCustomer($customer){  
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE customers SET name=?, age=?, email=?, join_date=?, address=?, reward_point=?, image=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $customer->getId();
                    $name = $customer->getName();
                    $age = $customer->getAge();
                    $email = $customer->getEmail();
                    $join_date = $customer->getJoinDate();
                    $address = $customer->getAddress();
                    $reward_point = $customer->getRewardPoint();
                    $image = $customer->getImage();
                  
			        $stmt->bind_param('sisssisi', 
                        $name,
                        $age,
                        $email,
                        $join_date,
                        $address,
                        $reward_point,  
                        $image,
                        $id,
			        );    
                    //Execute the statement
                    $stmt->execute(); 
                                                
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $customer->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteCustomer($customerId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM customers WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $customerId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>
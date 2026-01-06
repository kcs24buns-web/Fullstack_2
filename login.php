<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    
</head>
<body>
    <?php
        
        include 'dbconnect.php';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Get the submitted username and password
                $submitted_username = $_POST['username'];
                $submitted_password = $_POST['password'];

                // Query to check if the user exists with the provided credentials
                $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
                $stmt->bindParam(':username', $submitted_username);
                $stmt->bindParam(':password', $submitted_password);
                $stmt->execute();
                
                // Check if a matching user was found
                if($stmt->rowCount() > 0) {
                    // Set session variables for admin
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $submitted_username;
                    
                    // Redirect to admin menu
                    header("Location: admin_menu.php");
                    exit();
                } else {
                    echo "<p style='color: red;'>Invalid username or password!</p>";
                }
                
                }
            catch(PDOException $e)
                {
                echo $e->getMessage(); //If we are not successful in connecting or running the query we will see an error
                }
        }
        else{
            echo "You're here by mistake" ;
        }
        ?>


</body>
</html>
<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete participant</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php
       
    include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //DELETE - complete the functionality
                if(isset($_GET['id'])) {
                    $id = $_GET['id'];
                    
                    $stmt = $conn->prepare("DELETE FROM participant WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    
                    if($stmt->execute()) {
                        echo '<div class="alert alert-success">Participant deleted successfully!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error deleting participant.</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning">No participant ID specified.</div>';
                }

                }
            catch(PDOException $e)
                {
                // put the error stuff here
                echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
                }

        
        ?>
        
        <div class="mt-3">
            <a class="btn btn-secondary" href="view_participants_edit_delete.php">Back to participants list</a>
        </div>
    </div>
</div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
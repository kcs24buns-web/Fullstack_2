<?php

//ensure users are logged in to access this page
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
    <title>View participants</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-outline-secondary btn-sm mb-3" href=".">Back to index</a>
                <h1 class="mb-4">View all of the participants for edit or delete</h1>
                <?php
        
    //including connection variables   
    include 'dbconnect.php';
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //SELECT - view the participants with links to edit or delete them. 
            $stmt = $conn->prepare("SELECT * FROM participant ORDER BY firstname");
            $stmt->execute();
            $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($participants) > 0) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-striped table-hover">';
                echo '<thead class="table-dark"><tr><th>ID</th><th>Firstname</th><th>Surname</th><th>Email</th><th>Kills</th><th>Deaths</th><th>Team ID</th><th>Actions</th></tr></thead>';
                echo '<tbody>';
                
                foreach($participants as $participant) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($participant['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($participant['firstname']) . "</td>";
                    echo "<td>" . htmlspecialchars($participant['surname']) . "</td>";
                    echo "<td>" . htmlspecialchars($participant['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($participant['kills']) . "</td>";
                    echo "<td>" . htmlspecialchars($participant['deaths']) . "</td>";
                    echo "<td>" . htmlspecialchars($participant['team_id']) . "</td>";
                    echo "<td>";
                    echo '<a class="btn btn-sm btn-outline-primary me-1" href="edit_participant.php?id=' . $participant['id'] . '">Edit</a>';
                    echo '<a class="btn btn-sm btn-outline-danger" href="delete.php?id=' . $participant['id'] . '">Delete</a>';
                    echo "</td>";
                    echo "</tr>";
                }
                
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-info">No participants found.</div>';
            }
            
            }
        catch(PDOException $e)
            {
            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
            }
        ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
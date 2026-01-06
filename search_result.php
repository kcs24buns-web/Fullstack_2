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
    <title>Search results</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-outline-secondary btn-sm mb-3" href=".">Back to index</a>
                <?php
                    
                include 'dbconnect.php';
            
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //checking which form has been posted. If $_POST['participant'] exists and is equal to 1 then the user must be searching for individual participants. Otherwise they're searching for a team 
                if ($_POST['participant'] == "1") {

                    //search for a particpant here and display the results
                    $search_term = $_POST['firstname_surname'];
                    
                    $stmt = $conn->prepare("SELECT * FROM participant WHERE firstname LIKE :search_term OR surname LIKE :search_term");
                    $search_param = "%$search_term%";
                    $stmt->bindParam(':search_term', $search_param);
                    $stmt->execute();
                    
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(count($results) > 0) {
                        echo '<h2 class="mb-4">Participant Search Results</h2>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-striped table-hover">';
                        echo '<thead class="table-dark"><tr><th>ID</th><th>Firstname</th><th>Surname</th><th>Email</th><th>Kills</th><th>Deaths</th><th>Team ID</th></tr></thead>';
                        echo '<tbody>';
                        
                        foreach($results as $participant) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($participant['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($participant['firstname']) . "</td>";
                            echo "<td>" . htmlspecialchars($participant['surname']) . "</td>";
                            echo "<td>" . htmlspecialchars($participant['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($participant['kills']) . "</td>";
                            echo "<td>" . htmlspecialchars($participant['deaths']) . "</td>";
                            echo "<td>" . htmlspecialchars($participant['team_id']) . "</td>";
                            echo "</tr>";
                        }
                        
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-info">No participants found matching \'' . htmlspecialchars($search_term) . '\'</div>';
                    }
                }
                else{
                    //search for a team here and display the team members as well as their individual and combined stats. 
                    $team_name = $_POST['team'];
                    
                    $stmt = $conn->prepare("SELECT t.name as team_name, t.location, p.* FROM team t LEFT JOIN participant p ON t.id = p.team_id WHERE t.name LIKE :team_name");
                    $search_param = "%$team_name%";
                    $stmt->bindParam(':team_name', $search_param);
                    $stmt->execute();
                    
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(count($results) > 0) {
                        $team_info = $results[0];
                        echo '<h2 class="mb-4">Team Search Results</h2>';
                        echo '<h3 class="mb-3">Team: ' . htmlspecialchars($team_info['team_name']) . ' - Location: ' . htmlspecialchars($team_info['location']) . '</h3>';
                        
                        echo '<h4 class="mb-3">Team Members:</h4>';
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-striped table-hover">';
                        echo '<thead class="table-dark"><tr><th>ID</th><th>Firstname</th><th>Surname</th><th>Email</th><th>Kills</th><th>Deaths</th></tr></thead>';
                        echo '<tbody>';
                        
                        foreach($results as $participant) {
                            if($participant['firstname'] !== null) { // Only show participants, not empty rows
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($participant['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($participant['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($participant['surname']) . "</td>";
                                echo "<td>" . htmlspecialchars($participant['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($participant['kills']) . "</td>";
                                echo "<td>" . htmlspecialchars($participant['deaths']) . "</td>";
                                echo "</tr>";
                            }
                        }
                        
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-info">No teams found matching \'' . htmlspecialchars($team_name) . '\'</div>';
                    }
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
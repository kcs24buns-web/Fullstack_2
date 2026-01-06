<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register your interest</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                //including connection variables  
                include 'dbconnect.php';

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    //INSERT QUERY - complete the functionality to allow a user to register for merchandise
                    if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $firstname = $_POST['firstname'];
                        $surname = $_POST['surname'];
                        $email = $_POST['email'];
                        $terms = isset($_POST['terms']) ? 1 : 0; // Check if terms were accepted
                        
                        // Validate that terms were accepted
                        if($terms != 1) {
                            echo "<div class='alert alert-danger'>You must agree to the terms and conditions.</div>";
                        } else {
                            $stmt = $conn->prepare("INSERT INTO merchandise (firstname, surname, email, terms) VALUES (:firstname, :surname, :email, :terms)");
                            $stmt->bindParam(':firstname', $firstname);
                            $stmt->bindParam(':surname', $surname);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':terms', $terms);
                            
                            if($stmt->execute()) {
                                echo "<div class='alert alert-success'>Registration successful! Thank you for your interest.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error registering. Please try again.</div>";
                            }
                        }
                    }

                    }
                catch(PDOException $e)
                    {
                    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";

                    }


                ?>
                
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Register your interest for merchandise</h2>
                    </div>
                    <div class="card-body">
                        <form action="register.php" method="POST">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="surname" class="form-label">Surname:</label>
                                <input type="text" class="form-control" id="surname" name="surname" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" value="1" required>
                                <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                            </div>
                            
                            <div class="d-grid">
                                <input type="submit" class="btn btn-primary" value="Register">
                            </div>
                        </form>
                        
                        <div class="mt-3">
                            <a class="btn btn-secondary" href=".">Back to index</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
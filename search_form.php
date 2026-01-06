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
    <title>Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-outline-secondary btn-sm mb-3" href=".">Back to index</a>
                <h1 class="mb-4">Search for participants or teams</h1>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h2>Search for an individual participant</h2>
                            </div>
                            <div class="card-body">
                                <form action="search_result.php" method="POST">
                                    <div class="mb-3">
                                        <label for="firstname_surname" class="form-label">Participant firstname or surname</label>
                                        <input type="text" class="form-control" id="firstname_surname" name="firstname_surname">
                                    </div>
                                    <!--leave this hidden input in. Use it to determine whether you are searching for a participant or a team -->
                                    <input type="hidden" name="participant" value="1">
                                    <div class="d-grid">
                                        <input type="submit" class="btn btn-primary" value="Search Participant">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h2>Search for a team</h2>
                            </div>
                            <div class="card-body">
                                <form action="search_result.php" method="POST">
                                    <div class="mb-3">
                                        <label for="team" class="form-label">Team name</label>
                                        <input type="text" class="form-control" id="team" name="team">
                                    </div>
                                    <div class="d-grid">
                                        <input type="submit" class="btn btn-primary" value="Search Team">
                                    </div>
                                </form>
                            </div>
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
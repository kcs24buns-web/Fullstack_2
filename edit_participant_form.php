<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update participant scores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Update Participant Scores</h2>
                    </div>
                    <div class="card-body">
                        <form action="edit_participant.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Participant Firstname</label>
                                <input type="text" class="form-control" name="firstname" disabled value="<?php echo htmlspecialchars($participant['firstname']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Participant Surname</label>
                                <input type="text" class="form-control" name="surname" disabled value="<?php echo htmlspecialchars($participant['surname']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kills</label>
                                <input type="number" step="0.01" class="form-control" name="kills" value="<?php echo htmlspecialchars($participant['kills']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deaths</label>
                                <input type="number" step="0.01" class="form-control" name="deaths" value="<?php echo htmlspecialchars($participant['deaths']); ?>">
                            </div>
                            
                            <input type="hidden" name ="id" value="<?php echo htmlspecialchars($participant['id']); ?>">

                            <div class="d-grid">
                                <input type="submit" class="btn btn-primary" value="Update this player">
                            </div>
                        </form>
                        
                        <div class="mt-3">
                            <a class="btn btn-secondary" href="view_participants_edit_delete.php">Back to participants list</a>
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
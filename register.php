<!-- register.php -->

<?php
// Include the Database class
include('includes/Database.php');

// Initialize variables
$firstName = $lastName = $email = $password = $role = $teamName = $teamOption = $registrationMessage = '';

// Set the default value for team option to 'NA'
$teamOption = 'NA';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : '';
    $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : '';
    $dob = isset($_POST["dob"]) ? $_POST["dob"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    $role = isset($_POST["role"]) ? $_POST["role"] : '';
    // $teamName = isset($_POST["teamName"]) ? $_POST["teamName"] : '';
    // $teamOption = isset($_POST["teamOption"]) ? $_POST["teamOption"] : 'NA';

    // Validate and sanitize inputs (You may want to enhance this based on your requirements)
    $firstName = htmlspecialchars(trim($firstName));
    $lastName = htmlspecialchars(trim($lastName));
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars(trim($password));
    $role = htmlspecialchars(trim($role));
    // $teamName = htmlspecialchars(trim($teamName));

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($dob) || empty($email) || empty($password) || empty($role)) {
        $registrationMessage = "All fields are required.";
    } else {
        // Create an instance of the Database class
        $database = new Database();
        $conn = $database->getConnection();

        // Perform registration based on the user role
        if ($role == "player") {
            // Additional logic for player registration (insert into 'players' table)
            $sql = "INSERT INTO players (first_name, last_name, dob, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $firstName, $lastName, $dob, $email, $password);
        } elseif ($role == "umpire") {
            // Additional logic for umpire registration (insert into 'administrators' table)
            $sql = "INSERT INTO umpires (first_name, last_name, email, password, dob) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $password, $dob);
        } else {
            // Invalid role
            $registrationMessage = "Invalid user role.";
        }

        // Execute the prepared statement
        if ($stmt->execute()) {
            $registrationMessage = "Registration successful!";
        } else {
            $registrationMessage = "Registration failed. Please try again.";
        }

        // Close the database connection
        $database->closeConnection();
    }

    // Check if the form submission is successful
    if ($registrationMessage === 'Registration successful') {
        // Clear form fields on successful submission
        $firstName = $lastName = $email = $password = $role = $teamOption = $teamName = '';
    }
}
?>

<!-- HTML form for registration -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player/Umpire Registration</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include your custom CSS file if any -->

    <!-- Include jQuery and jQuery UI Datepicker CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- ================================================================== -->
    
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    /* Styles for error messages */
    .error-message {
        color: #ff0000; /* Red color for error messages */
        margin-top: 10px;
    }
    /* Style for Datepicker */
    .ui-datepicker {
        background-color: #fff;
    }
    </style>


    <script>
        // Initialize Datepicker on the date of birth field
        $(function () {
            $("#dob").datepicker({
                dateFormat: 'yy-mm-dd', // Set the desired date format
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0" // Allow selection of the last 100 years
            });
        });
    </script>
</head>
<body>

<?php include('views/common/header.php'); ?>

    <div class="container mt-5 mb-3">
        <h2>Player/Umpire Registration</h2>
        <hr class="text-dark">
        <p class="error-message" id="error-message"><?php echo $registrationMessage; ?></p>

        <!-- Registration Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="text" class="form-control" id="dob" name="dob" placeholder="YYYY-MM-DD" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="player" <?php echo ($role == 'player') ? 'selected' : ''; ?>>Player</option>
                    <option value="umpire" <?php echo ($role == 'umpire') ? 'selected' : ''; ?>>Umpire</option>
                </select>
            </div>
            <!-- <div class="mb-3">
                <label class="form-label">Team Option</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="teamOption" id="teamOptionNA" value="NA" <?php echo ($teamOption == 'NA') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="teamOptionNA">Not Applicable</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="teamOption" id="teamOptionYes" value="Yes" <?php echo ($teamOption == 'Yes') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="teamOptionYes">Yes</label>
                </div>
            </div> -->
            <!-- <div class="mb-3">
                <label for="teamName" class="form-label">Team Name (For Players Only)</label>
                <input type="text" class="form-control" id="teamName" name="teamName" value="<?php echo $teamName; ?>" <?php echo ($teamOption == 'Yes') ? '' : 'disabled'; ?>>
            </div> -->
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and Popper.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="assets/js/script.js"></script> -->
</body>
</html>

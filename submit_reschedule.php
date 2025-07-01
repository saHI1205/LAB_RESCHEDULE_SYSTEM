<?php
session_start();

// Check if the student is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Fetch available coordinators for selection
$sql = "SELECT * FROM coordinators";
$coordinators_result = $conn->query($sql);

// Fetch labs for table display
$labs_sql = "SELECT * FROM labs";
$labs_result = $conn->query($labs_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $coordinator_id = $_POST['coordinator_id'];
    $module = $_POST['module'];
    $lab_id = $_POST['lab_id'];
    $lab_name = $_POST['lab_name'];
    $instructor_name = $_POST['instructor_name'];

    // Ensure student_id is set in session
    if (!isset($_SESSION['student_id'])) {
        echo "Student ID not found in session. Redirecting to login...";
        header("Location: login.php");
        exit();
    }
    $student_id = $_SESSION['student_id']; // Get student ID from session

    // File upload for medical certificate
    $medical_certificate = '';
    if (isset($_FILES['medical_certificate']) && $_FILES['medical_certificate']['error'] == 0) {
        $file_name = $_FILES['medical_certificate']['name'];
        $file_tmp = $_FILES['medical_certificate']['tmp_name'];
        $file_path = 'uploads/' . $file_name;

        // Ensure the upload directory exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true); // Create directory if it doesn't exist
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file_tmp, $file_path)) {
            $medical_certificate = $file_name;
        } else {
            echo "Error moving the uploaded file.";
            exit();
        }
    } else {
        echo "No file uploaded or an error occurred.";
        exit();
    }

    // Insert the medical form into the medical_forms table and retrieve the ID
    $stmt = $conn->prepare("INSERT INTO medical_forms (student_id, medical_certificate) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $medical_certificate);
    $stmt->execute();
    
    // Check if there was an error inserting the medical form
    if ($stmt->error) {
        echo "Error inserting medical form: " . $stmt->error;
        exit();
    }
    
    $medical_form_id = $stmt->insert_id;  // Get the ID of the inserted medical form

    // Declare the status as 'pending' since it's hardcoded in the SQL query
    $status = 'pending';

    // Correct SQL query with 8 placeholders (including the status)
    $sql = "INSERT INTO reschedule_requests (student_id, coordinator_id, module, lab_id, lab_name, instructor_name, status, medical_form_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters correctly
    $stmt->bind_param("iisssssi", $student_id, $coordinator_id, $module, $lab_id, $lab_name, $instructor_name, $status, $medical_form_id);

    // Execute the query
    $stmt->execute();

    // Check if there was an error inserting into the reschedule_requests table
    if ($stmt->error) {
        echo "Error inserting reschedule request: " . $stmt->error;
        exit();
    }

    echo "Reschedule request submitted successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Reschedule Request</title>
    <style>
        /* General body styling */
                /* General body styling */
                body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
            overflow: auto;
            background: linear-gradient(315deg, rgba(101,0,94,1) 3%, rgb(39, 100, 161) 38%, rgb(2, 82, 77) 68%, rgb(83, 12, 12) 98%);
            animation: gradient 15s ease infinite;
            background-size: 400% 400%;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            text-align: center;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 0%;
            }
            50% {
                background-position: 100% 100%;
            }
            100% {
                background-position: 0% 0%;
            }
        }

        .wave {
            background: rgb(0 0 0 / 25%);
            border-radius: 1000% 1000% 0 0;
            position: fixed;
            width: 200%;
            height: 12em;
            animation: wave 10s -3s linear infinite;
            transform: translate3d(0, 0, 0);
            opacity: 0.8;
            bottom: 0;
            left: 0;
            z-index: -1;
        }

        .wave:nth-of-type(2) {
            bottom: -1.25em;
            animation: wave 18s linear reverse infinite;
            opacity: 0.8;
        }

        .wave:nth-of-type(3) {
            bottom: -2.5em;
            animation: wave 20s -1s reverse infinite;
            opacity: 0.9;
        }

        @keyframes wave {
            2% {
                transform: translateX(1);
            }

            25% {
                transform: translateX(-25%);
            }

            50% {
                transform: translateX(-50%);
            }

            75% {
                transform: translateX(-25%);
            }

            100% {
                transform: translateX(1);
            }
        }

        /* Container for the form */
        .form-container {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            width: 400px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #4e9ef1;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #4e9ef1;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3c8cd3;
        }

        /* Styling for the labs table */
        .labs-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .labs-table th, .labs-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .labs-table th {
            background-color: #f2f2f2;
        }

        /* Flexbox for form and labs container */
        .main-container {
            display: flex;
            justify-content: space-between;
            width: 1000px; /* Adjust as necessary */
        }

        .form-container {
            width: 48%;
        }

        /* Lab Table Animation */
        .labs-container {
            width: 48%;
            position: absolute;
            right: 0;
            top: 10%;
            display: none; /* Initially hidden */
            background: #fff;
            border-radius: 12px;
            padding: 20px 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transform: translateX(100%); /* Hidden off-screen */
            animation: slideIn 0.5s forwards; /* Slide-in animation */
        }

        /* Slide-in animation */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        /* Button and note styling */
        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-row label {
            width: 45%;
        }

        .form-row input,
        .form-row select {
            width: 50%;
        }

        .note {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }
    </style>
    <script>
        function toggleLabsTable() {
            var table = document.getElementById("labsContainer");
            if (table.style.display === "none" || table.style.display === "") {
                table.style.display = "block";
            } else {
                table.style.display = "none";
            }
        }
    </script>
</head>
<body>

    <div class="main-container">
        <!-- Form Container -->
        <div class="form-container">
            <h2>Submit Reschedule Request</h2>

            <form method="POST" enctype="multipart/form-data">
                <!-- Coordinator selection -->
                <label for="coordinator_id">Coordinator:</label>
                <select name="coordinator_id" required>
                    <?php while ($row = $coordinators_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['coordinator_id']; ?>"><?php echo $row['coordinator_name']; ?></option>
                    <?php } ?>
                </select><br>

                <!-- Form Row for Module and View Labs Button -->
                <div class="form-row">
                    <div>
                        <label for="module">Module:</label>
                        <input type="text" name="module" required><br>
                    </div>
                    <div>
                        <button type="button" onclick="toggleLabsTable()">View Labs</button>
                        <div class="note">You can see the details</div>
                    </div>
                </div>

                <!-- Lab ID input -->
                <label for="lab_id">Lab ID:</label>
                <input type="number" name="lab_id" required><br>

                <!-- Lab Name input -->
                <label for="lab_name">Lab Name:</label>
                <input type="text" name="lab_name" required><br>

                <!-- Instructor Name input -->
                <label for="instructor_name">Instructor Name:</label>
                <input type="text" name="instructor_name" required><br>

                <!-- Medical Certificate upload -->
                <label for="medical_certificate">Upload Medical Certificate (PDF):</label>
                <input type="file" name="medical_certificate" accept="application/pdf" required><br>

                <!-- Submit button -->
                <button type="submit">Submit Request</button>
            </form>
        </div>

        <!-- Labs Table Container (Initially Hidden) -->
        <div class="labs-container" id="labsContainer">
            <h3>Labs Table</h3>
            <table class="labs-table">
                <tr>
                    <th>Lab ID</th>
                    <th>Lab Name</th>
                    <th>Module</th>
                    <th>Instructor</th>
                </tr>
                <?php while ($row = $labs_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['lab_id']; ?></td>
                        <td><?php echo $row['lab_name']; ?></td>
                        <td><?php echo $row['module']; ?></td>
                        <td><?php echo $row['instructor_name']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>
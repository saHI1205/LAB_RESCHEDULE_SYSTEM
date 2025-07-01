<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');
$username = $_SESSION['username'];

// Fetch student details
$sql = "SELECT * FROM students WHERE username = '$username'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

// Check if the form is submitted to view the rescheduled labs
$show_rescheduled_labs = isset($_POST['view_rescheduled_labs']);  // Check if the button was clicked

// Fetch rescheduled labs for the logged-in student (only if the button is clicked)
$rescheduled_labs_result = null;  // Initialize as null
if ($show_rescheduled_labs) {
    $student_id = $student['student_id'];

    // Query to fetch rescheduled labs for the logged-in student
    $rescheduled_labs_sql = "
        SELECT rl.lab_id, rl.lab_name, rl.rescheduled_date, ts.available_time AS rescheduled_time
        FROM rescheduled_labs rl
        JOIN time_slots ts ON rl.lab_id = ts.lab_id
        WHERE rl.student_id = '$student_id' AND ts.student_id = '$student_id'
    ";
    $rescheduled_labs_result = $conn->query($rescheduled_labs_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
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

        .container {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            width: 400px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4e9ef1;
            color: #fff;
            border-radius: 8px;
            font-size: 16px;
            margin: 15px 0;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #3c8cd3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4e9ef1;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e3e3e3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome <?php echo $student['student_name']; ?></h1>
        <p>Email: <?php echo $student['student_email']; ?></p>
        <p>ID: <?php echo $student['student_id']; ?></p>

        <!-- Submit Reschedule Request -->
        <a href="submit_reschedule.php"><button class="button">Submit Your Reschedule Request</button></a>

        <!-- View Reschedule Status -->
        <a href="view_status.php"><button class="button">View Reschedule Request Status</button></a>

        <!-- View Rescheduled Lab Details -->
        <!-- View Rescheduled Lab Details Button -->
        <a href="view_rescheduled_labs.php"><button class="button">View Rescheduled Lab Details</button></a>


        <!-- Display Rescheduled Lab Details if the form is submitted -->
        <?php if ($show_rescheduled_labs): ?>
            <h2>Rescheduled Lab Details</h2>
            <?php if ($rescheduled_labs_result && $rescheduled_labs_result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Lab ID</th>
                        <th>Lab Name</th>
                        <th>Rescheduled Date</th>
                        <th>Rescheduled Time</th>
                    </tr>
                    <?php while ($row = $rescheduled_labs_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['lab_id']; ?></td>
                            <td><?php echo $row['lab_name']; ?></td>
                            <td><?php echo $row['rescheduled_date']; ?></td>
                            <td><?php echo $row['rescheduled_time']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No rescheduled labs found for this student.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>

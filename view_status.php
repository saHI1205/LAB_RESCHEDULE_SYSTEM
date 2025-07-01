<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

include('db_connection.php');
$username = $_SESSION['username'];

// Fetch student details securely using prepared statements
$sql = "SELECT * FROM students WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Fetch student's reschedule request status securely using prepared statements
$sql = "SELECT * FROM reschedule_requests WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student['student_id']);
$stmt->execute();
$reschedule_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Request Status</title>
    <style>
        /* Basic styling */
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
            width: 80%;
            max-width: 900px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
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

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            table th, table td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Reschedule Request Status</h1>

    <table>
        <tr>
            <th>Request ID</th>
            <th>Module</th>
            <th>Lab Name</th>
            <th>Status</th>
        </tr>

        <?php while ($row = $reschedule_result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['request_id']); ?></td>
            <td><?php echo htmlspecialchars($row['module']); ?></td>
            <td><?php echo htmlspecialchars($row['lab_name']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

include('db_connection.php');
$username = $_SESSION['username'];

// Fetch coordinator details
$sql = "SELECT * FROM coordinators WHERE username = '$username'";
$result = $conn->query($sql);
$coordinator = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>
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

        /* Container for the page */
        .container {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Table styling */
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

        a {
            text-decoration: none;
            color: #4e9ef1;
            font-weight: bold;
        }

        a:hover {
            color: #3c8cd3;
        }

        /* Button Styling */
        .approve-btn {
            padding: 8px 16px;
            background-color: #4e9ef1;
            color: white;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .approve-btn:hover {
            background-color: #3c8cd3;
        }

        /* View Button Styling */
        .view-btn {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: none;
        }

        .view-btn:hover {
            background-color: #218838;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
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
        <h1>Welcome <?php echo $coordinator['coordinator_name']; ?></h1>

        <!-- View Reschedule Requests -->
        <table>
            <tr>
                <th>Request ID</th>
                <th>Student ID</th>
                <th>Medical form ID</th>
                <th>Medical Form</th>
                <th>Status</th>
                <th>Approve</th>
                <th>Module</th>
                <th>Lab ID</th>
                <th>Instructor Name</th>
            </tr>
            <?php
            $sql = "SELECT * FROM reschedule_requests WHERE coordinator_id = " . $coordinator['coordinator_id'];
            $result = $conn->query($sql);
            while ($request = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $request['request_id'] . "</td>";
                echo "<td>" . $request['student_id'] . "</td>";
                echo "<td>". $request["medical_form_id"] . "</td>";
                echo "<td><a href='uploads/" . $request['medical_form_id'] . "' target='_blank'><button class='view-btn'>View</button></a></td>";
                echo "<td>" . $request['status'] . "</td>";
                echo "<td><a href='approve_request.php?id=" . $request['request_id'] . "'><button class='approve-btn'>Approve</button></a></td>";
                echo "<td>". $request["module"] . "</td>";
                echo "<td>". $request["lab_id"] . "</td>";
                echo "<td>". $request["instructor_name"] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

    </div>

</body>
</html>

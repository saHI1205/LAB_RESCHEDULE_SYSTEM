<?php
session_start();

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Fetch approved medical requests from the database
$sql = "SELECT * FROM reschedule_requests WHERE status = 'Approved'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Medical Requests</title>
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
            background-color: white;
            width: 90%;
            max-width: 1100px;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 2.4rem;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            text-align: left;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        table th {
            background-color: #f1f1f1;
            color: #4A90E2;
            font-size: 1.1rem;
        }

        table td {
            background-color: #fff;
            color: #555;
            font-size: 1rem;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        table a {
            color: #4A90E2;
            text-decoration: none;
            font-weight: 500;
        }

        section {
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Approved Reschdule Requests</h1>

    <!-- Displaying the approved medical requests -->
    <section id="approved-medicals">
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Student ID</th>
                    <th>Medical Certificate</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['request_id']}</td>
                                <td>{$row['student_id']}</td>
                                <td><a href='{$row['medical_certificate']}' target='_blank'>View Certificate</a></td>
                                <td>{$row['status']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No approved medical requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>

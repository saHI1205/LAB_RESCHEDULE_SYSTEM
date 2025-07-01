<?php
session_start();

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Fetch the instructor's details (Optional)
$instructor_id = $_SESSION['instructor_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <style>
        /* General Styling */
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

        .buttons {
            margin-top: 20px;
        }

        button {
            padding: 12px 24px;
            font-size: 1.2rem;
            margin: 10px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 230px;
        }

        button:hover {
            background-color: #3578e5;
        }

        button:focus {
            outline: none;
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
            transition: color 0.3s ease;
        }

        table a:hover {
            color: #3578e5;
        }

        section {
            margin-top: 40px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            h1 {
                font-size: 1.8rem;
            }

            button {
                width: 100%;
                padding: 12px 20px;
                font-size: 1rem;
            }

            table th, table td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>

    <div class="buttons">
        <button onclick="location.href='manage_slots.php'">Manage your time slots</button>
        <button onclick="location.href='approved_medicals.php'">Approved medical with student details</button>
        <button onclick="location.href='assign_student_slot.php'">Assign student to lab time slot</button>
    </div>

    

    <!-- Section for displaying available lab time slots -->
    <section id="time-slots">
        <h2>Available Time Slots for Rescheduling</h2>
        <table>
            <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Lab Name</th>
                    <th>Available Date</th>
                    <th>Available Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch available lab time slots from the database
                $sql = "SELECT * FROM time_slots WHERE is_booked = 0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['slot_id']}</td>
                                <td>{$row['lab_id']}</td>
                                <td>{$row['available_date']}</td>
                                <td>{$row['available_time']}</td>
                                <td><a href='assign_slot.php?slot_id={$row['slot_id']}'>Assign Slot</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No available time slots found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>

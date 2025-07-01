<?php
session_start();

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Fetch available students (you can modify the query to get specific students if needed)
$student_sql = "SELECT * FROM students";
$student_result = $conn->query($student_sql);

// Fetch available time slots
$slot_sql = "SELECT * FROM time_slots WHERE is_booked = 0";
$slot_result = $conn->query($slot_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get selected student and slot
    $student_id = $_POST['student_id'];
    $slot_id = $_POST['slot_id'];

    // Insert into rescheduled_labs table
    $assign_sql = "INSERT INTO rescheduled_labs (student_id, lab_id, rescheduled_date, rescheduled_time)
                   SELECT '$student_id', lab_id, available_date, available_time
                   FROM time_slots
                   WHERE slot_id = '$slot_id'";

    if ($conn->query($assign_sql) === TRUE) {
        // Mark slot as booked
        $update_slot_sql = "UPDATE time_slots SET is_booked = 1 WHERE slot_id = '$slot_id'";
        $conn->query($update_slot_sql);

        echo "<script>alert('Student assigned to slot successfully');</script>";
    } else {
        echo "<script>alert('Error assigning student to slot');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Student to Lab Time Slot</title>
    <style>
        /* General Body Styling */
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

        /* Container Styling */
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
            box-sizing: border-box;
        }

        /* Heading Styling */
        h1 {
            color: #000;
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        /* Label Styling */
        label {
            font-size: 16px;
            color: #666;
            margin-bottom: 8px;
            text-align: left;
            display: block;
        }

        /* Select Styling */
        select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            transition: border 0.3s ease;
        }

        /* Focus Styling for Select */
        select:focus {
            border-color: #0056b3;
            outline: none;
        }

        /* Button Styling */
        button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Hover Effect on Button */
        button:hover {
            background-color: #004085;
        }

        /* Alert Message Styling */
        script {
            font-size: 16px;
            color: #28a745;
        }

        /* Responsive Design: Making sure the layout looks good on smaller screens */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Assign Student to Lab Time Slot</h1>
    <form method="POST">
        <div>
            <label for="student_id">Select Student:</label>
            <select name="student_id" id="student_id" required>
                <?php
                if ($student_result->num_rows > 0) {
                    while ($row = $student_result->fetch_assoc()) {
                        echo "<option value='{$row['student_id']}'>{$row['student_name']}</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div>
            <label for="slot_id">Select Available Time Slot:</label>
            <select name="slot_id" id="slot_id" required>
                <?php
                if ($slot_result->num_rows > 0) {
                    while ($row = $slot_result->fetch_assoc()) {
                        echo "<option value='{$row['slot_id']}'>Lab: {$row['lab_id']} on {$row['available_date']} at {$row['available_time']}</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div>
            <button type="submit">Assign Slot</button>
        </div>
    </form>
</div>

</body>
</html>

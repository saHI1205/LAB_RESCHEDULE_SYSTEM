<?php
session_start();

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Get the logged-in instructor's ID from the session
$instructor_id = $_SESSION['instructor_id'];

// Handle form submission to add a new time slot
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_slot'])) {
    $lab_id = $_POST['lab_id'];  // Using 'lab_id' instead of 'lab_name'
    $available_date = $_POST['available_date'];
    $available_time = $_POST['available_time'];

    // Insert the new time slot into the database using lab_id and instructor_id
    $sql = "INSERT INTO time_slots (lab_id, available_date, available_time,  instructor_id) 
            VALUES ('$lab_id', '$available_date', '$available_time',  '$instructor_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Time slot added successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Handle form submission to update an existing time slot
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_slot'])) {
    $slot_id = $_POST['slot_id'];
    $lab_id = $_POST['lab_id'];
    $available_date = $_POST['available_date'];
    $available_time = $_POST['available_time'];

    // Update the time slot
    $sql = "UPDATE time_slots 
            SET lab_id = '$lab_id', available_date = '$available_date', available_time = '$available_time'
            WHERE slot_id = $slot_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Time slot updated successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $slot_id = $_GET['delete'];
    $sql = "DELETE FROM time_slots WHERE slot_id = $slot_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Time slot deleted successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Time Slots</title>
    <style>
        /* Include similar CSS from previous example */
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
            overflow-y: auto; /* This will enable the vertical scrollbar */
            max-height: 80vh; /* Limits the container height to 80% of the viewport height */
        }

        h1 {
            font-size: 2.4rem;
            color: #333;
            margin-bottom: 20px;
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
        }

        button:hover {
            background-color: #3578e5;
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

        .form-container {
            margin-top: 20px;
        }

        input, select {
            padding: 10px;
            margin: 5px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Time Slots</h1>

    <!-- Add Time Slot Form -->
    <div class="form-container">
        <h2>Add New Time Slot</h2>
        <form method="POST" action="">
            <!-- Dropdown for lab_id -->
            <select name="lab_id" required>
                <option value="">Select Lab</option>
                <?php
                // Fetch all labs (Assuming you have a `labs` table to get the lab names)
                $sql = "SELECT * FROM labs";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['lab_id']}'>{$row['lab_name']}</option>";
                    }
                }
                ?>
            </select><br>
            <input type="date" name="available_date" required><br>
            <input type="time" name="available_time" required><br>
            <button type="submit" name="add_slot">Add Time Slot</button>
        </form>
    </div>

    <!-- Display Existing Time Slots -->
    <section id="time-slots">
        <h2>Existing Time Slots</h2>
        <table>
            <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Lab ID</th>
                    <th>Available Date</th>
                    <th>Available Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all time slots from the database
                $sql = "SELECT * FROM time_slots";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['slot_id']}</td>
                                <td>{$row['lab_id']}</td>
                                <td>{$row['available_date']}</td>
                                <td>{$row['available_time']}</td>
                                <td>
                                    <a href='?delete={$row['slot_id']}'>Delete</a>
                                    <a href='update_slot.php?slot_id={$row['slot_id']}'>Update</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No time slots found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

</body>
</html>


<?php
session_start();

// Check if the user is logged in and is a coordinator
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'coordinator') {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Check if the 'id' is set in the URL (it should contain the request_id)
if (isset($_GET['id'])) {
    $request_id = $_GET['id'];

    // Prepare SQL query to update the status to 'approved'
    $sql = "UPDATE reschedule_requests SET status = 'approved' WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id); // Bind the request_id to the query
    $stmt->execute();

    // Fetch the details of the approved request to insert into 'Messages_from_Coordinator' table
    $sql_request = "
        SELECT rs.lab_id, rs.module, rs.student_id, s.student_name, rs.medical_form_id
        FROM reschedule_requests rs
        JOIN students s ON rs.student_id = s.student_id
        WHERE rs.request_id = ?";
    
    $stmt_request = $conn->prepare($sql_request);
    $stmt_request->bind_param("i", $request_id);
    $stmt_request->execute();
    $result = $stmt_request->get_result();
    $request_data = $result->fetch_assoc();

    // Get the medical certificate file path (assuming it's stored as the file name)
    $medical_certificate = 'uploads/' . $request_data['medical_form_id'];

    // Insert the approved request into the 'Messages_from_Coordinator' table
    $sql_message = "INSERT INTO Messages_from_Coordinator (lab_id, module, student_id, student_name, medical_certificate, status)
                    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt_message = $conn->prepare($sql_message);
    $status = 'approved'; // Status is approved for the request
    $stmt_message->bind_param("isssss", 
        $request_data['lab_id'], 
        $request_data['module'], 
        $request_data['student_id'], 
        $request_data['student_name'], 
        $medical_certificate, 
        $status
    );
    $stmt_message->execute();

    // Redirect to coordinator dashboard after approval
    header("Location: coordinator_dashboard.php");
    exit();
} else {
    echo "No request ID found!";
}
?>

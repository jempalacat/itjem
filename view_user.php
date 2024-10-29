<?php
include 'includes/db_connect.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $sql = "SELECT * FROM users WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "<p><strong>User ID:</strong> " . $user['user_id'] . "</p>";
        echo "<p><strong>Name:</strong> " . $user['first_name'] . " " . $user['middle_name'] . " " . $user['last_name'] . "</p>";
        echo "<p><strong>User Type:</strong> " . $user['user_type'] . "</p>";
        echo "<p><strong>Status:</strong> " . $user['email'] . "</p>";
        echo "<p><strong>Status:</strong> " . $user['mobile_number'] . "</p>";
        echo "<p><strong>Status:</strong> " . $user['active_status'] . "</p>";
        
    } else {
        echo "<p>User details not found.</p>";
    }
}
?>

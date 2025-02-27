<?php
session_start();
$conn = new mysqli("localhost", "root", "", "idea_selection");

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit();
}

$user_id = $_SESSION['user_id'];
$idea_id = $_POST["idea_id"];

// Check if user has already selected an idea
$sql = "SELECT selected_idea_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['selected_idea_id']) {
    echo "You have already selected an idea!";
    exit();
}

// Mark idea as selected
$sql = "UPDATE ideas SET is_selected = TRUE WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idea_id);
$stmt->execute();

// Assign selected idea to user
$sql = "UPDATE users SET selected_idea_id = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idea_id, $user_id);
$stmt->execute();

echo "Your idea has been saved!";
?>

<?php
$conn = new mysqli("localhost", "root", "", "idea_selection");

$sql = "SELECT * FROM ideas WHERE is_selected = FALSE";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['idea_name']}</option>";
}
?>

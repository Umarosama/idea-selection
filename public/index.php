<?php
session_start();
$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT"); // Make sure to use the correct port

// Create connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if user already selected an idea
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

// Fetch available ideas
$sql = "SELECT * FROM ideas WHERE is_selected = FALSE";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Idea Selection</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Select an Idea</h2>
    <form id="ideaForm">
        <select name="idea_id" id="ideaSelect">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['idea_name'] ?></option>
            <?php } ?>
        </select>
        <button type="submit">Submit</button>
    </form>

    <p id="response"></p>

    <script>
        $(document).ready(function(){
            function loadAvailableIdeas() {
                $.ajax({
                    url: "fetch_ideas.php",
                    success: function(data) {
                        $("#ideaSelect").html(data);
                    }
                });
            }

            $("#ideaForm").submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: "submit.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response){
                        $("#response").html(response);
                        loadAvailableIdeas();
                    }
                });
            });

            setInterval(loadAvailableIdeas, 5000); // Refresh ideas every 5 seconds
        });
    </script>
</body>
</html>

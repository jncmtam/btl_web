<?php
session_start();
include 'db.php';

// Check if the user is logged in and has the 'user' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $reference_id = $_POST['reference_id'];
    $comment = $_POST['comment'];

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedbacks (user_id, type, reference_id, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $user_id, $type, $reference_id, $comment);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Feedback submitted successfully!'); window.location.href = 'feedback.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact page">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="css/styles.css">

    <script>
        function loadTitles(type) {
            fetch(`fetch_titles.php?type=${type}`)
                .then(response => response.json())
                .then(data => {
                    const referenceSelect = document.getElementById("reference_id");
                    referenceSelect.innerHTML = ""; // Clear existing options

                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.title; // Display title instead of ID
                        referenceSelect.appendChild(option);
                    });
                });
        }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>

    <main id="feedback">
        <h1>Submit Feedback</h1>
        <form action="feedback.php" method="POST">
            <label for="type">Feedback Type:</label>
            <select name="type" id="type" onchange="loadTitles(this.value)" required>
                <option value="">-- Select Type --</option>
                <option value="product">Product</option>
                <option value="news">News</option>
            </select>

            <label for="reference_id">Select Title:</label>
            <select name="reference_id" id="reference_id" required>
                <!-- Options will be dynamically populated -->
            </select>

            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" rows="4" required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php
session_start();
include 'db.php'; // Database connection

// Check if user is logged in and has an admin role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle deletion if requested
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    header("Location: feedback_admin.php"); 
    exit();
}

// Fetch all feedback
$sql = "SELECT f.id, f.type, f.reference_id, f.comment, f.created_at, u.username 
        FROM feedbacks f 
        JOIN users u ON f.user_id = u.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Feedback - Admin</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'nav.php'; ?>

    <main id="manage-feedback">
        <h1>Manage Feedback</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Reference ID</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php while ($feedback = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $feedback['id']; ?></td>
                        <td><?php echo $feedback['username']; ?></td>
                        <td><?php echo ucfirst($feedback['type']); ?></td>
                        <td><?php echo $feedback['reference_id']; ?></td>
                        <td><?php echo htmlspecialchars($feedback['comment']); ?></td>
                        <td><?php echo $feedback['created_at']; ?></td>
                        <td>
                            <a href="feedback_admin.php?delete_id=<?php echo $feedback['id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No feedback available.</p>
        <?php endif; ?>

    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>

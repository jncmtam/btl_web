<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guess';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pricing page">
    <title>Pricing - Company</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <?php include 'nav.php'; ?>

    <main>
        <section id="pricing">
            <h1>Pricing</h1>
            <table>
                <tr>
                    <th>Service</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td>Service 1</td>
                    <td>$100</td>
                </tr>
                <tr>
                    <td>Service 2</td>
                    <td>$200</td>
                </tr>
            </table>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>

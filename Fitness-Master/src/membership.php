<?php
// Start session
session_start();

// Include database connection
require('db.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch membership packages from the database
$query = "SELECT * FROM membership_packages";
$result = $con->query($query);

// Check if query is successful
if (!$result) {
    die("Error fetching data: " . $con->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Packages - Fitness Master</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Ensure the body takes full height */
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .header-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px; /* Add space between the cards */
        }

        .package-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            width: 320px;
            padding: 25px;
            text-align: center;
            position: relative;
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .package-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
        }

        .package-icon {
            background-color: #17a2b8;
            border-radius: 50%;
            width: 85px;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: background-color 0.3s;
        }

        .package-icon img {
            width: 45px;
            height: 45px;
        }

        .package-card:hover .package-icon {
            background-color: #138496;
        }

        .package-name {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 18px;
        }

        .package-details {
            font-size: 15px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .package-price {
            font-size: 22px;
            color: #28a745;
            font-weight: 700;
        }

        .package-duration {
            font-size: 15px;
            color: #888;
            margin-top: 8px;
        }

        /* Ensure the footer sticks to the bottom */
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .package-card {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?> <!-- Sidebar -->

<div class="content-wrapper">
    <div class="header-container">
        <h2>Available Membership Packages</h2>
    </div>

    <div class="container">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="package-card">
            <div class="package-icon">
                <img src="images/gym.svg" alt="Package Icon"> <!-- Replace with actual icon path -->
            </div>
            <div class="package-name"><?php echo htmlspecialchars($row['package_name']); ?></div>
            <div class="package-details"><?php echo htmlspecialchars($row['description']); ?></div>
            <div class="package-price">$<?php echo number_format($row['price'], 2); ?></div>
            <div class="package-duration"><?php echo htmlspecialchars($row['duration']); ?> days</div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>

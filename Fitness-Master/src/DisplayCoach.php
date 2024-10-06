<?php
// Start the session
session_start();

// Include your database connection file
require('db.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); 
    exit();
}

// Fetch coaches data
$sql = "SELECT * FROM coaches";
$result = $con->query($sql);

include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Coaches - Fitness Master</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin-left: 250px; /* Ensure enough space for sidebar */
        }

        .coaches-container {
            max-width: 1200px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .coaches-container h2 {
            text-align: center;
            color: #1c3d3f;
            margin-bottom: 30px;
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .coaches-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .coach-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .coach-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .coach-card h3 {
            color: #379d9d;
            margin-bottom: 15px;
            font-size: 22px;
        }

        .coach-info {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        .coach-info span {
            font-weight: bold;
            color: #4ecdc4;
        }

        /* Additional hover effect for styling */
        .coach-card:hover .coach-info span {
            color: #379d9d;
        }

        /* Responsive design improvements */
        @media (max-width: 768px) {
            .coaches-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
                margin-left: 0;
            }

            .coaches-container {
                padding: 20px;
            }

            .coaches-grid {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>
    <div class="coaches-container">
        <h2>Meet Our Coaches</h2>
        <div class="coaches-grid">
            <?php while ($coach = $result->fetch_assoc()) : ?>
                <div class="coach-card">
                    <h3><?php echo htmlspecialchars($coach['name']); ?></h3>
                    <p class="coach-info">
                        <span>Email:</span> <?php echo htmlspecialchars($coach['email']); ?>
                    </p>
                    <p class="coach-info">
                        <span>Specialization:</span> <?php echo htmlspecialchars($coach['specialization']); ?>
                    </p>
                    <p class="coach-info">
                        <span>Phone:</span> <?php echo htmlspecialchars($coach['phone_number']); ?>
                    </p>
                    <p class="coach-info">
                        <span>Experience:</span> <?php echo htmlspecialchars($coach['experience_years']); ?> years
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

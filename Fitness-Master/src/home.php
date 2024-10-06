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

include 'navbar.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Home</title>
    <style>
        /* Button-like styling for <a> tags */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        body {
            background-image: url('images/bg3.webp'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
        }
       /* body{
            background-color:black;
        }*/
    </style>
</head>
<body>

<div class="home-container">
    <section class="hero">
        <h2>How Fitness Master Helps You</h2>
        <p>At Fitness Master, we understand your goals and lifestyle before creating a personalized plan that works for YOU.</p>
    </section>
    
    <section class="plans">
        <h2>The Right Plan for Your Health</h2>
        <p>Choose the perfect plan for your fitness needs. Flexible and easy to follow.</p>
        
        <div class="plan-cards">
            <div class="plan-card card-1">
                <h3><i class="fas fa-dumbbell"></i> Fitness Coaching</h3>
                <ul>
                    <li>Internationally certified coaches</li>
                    <li>Personalized workout plans</li>
                    <li>Nutrition advice tailored to your needs</li>
                    <li>Weekly check-ins with your coach</li>
                </ul>
                <a href="DisplayCoach.php" class="btn">View Coaches</a> <!-- Redirect to DisplayCoach.php -->
            </div>

            <div class="plan-card card-2">
                <h3><i class="fas fa-apple-alt"></i> Nutrition Coaching</h3>
                <ul>
                    <li>Scientifically backed plans</li>
                    <li>Personalized based on your fitness level</li>
                    <li>Ongoing adjustments for progress</li>
                    <li>1-on-1 coaching support</li>
                </ul>
                <a href="DisplayCoach.php" class="btn">View Coaches</a> <!-- Redirect to DisplayCoach.php -->
            </div>

            <div class="plan-card card-3">
                <h3><i class="fas fa-chart-line"></i> Advanced Strategies</h3>
                <ul>
                    <li>Custom-tailored to your goals</li>
                    <li>Daily check-ins with your coach</li>
                    <li>Exclusive coaching advice</li>
                </ul>
                <a href="DisplayCoach.php" class="btn">View Coaches</a> <!-- Redirect to DisplayCoach.php -->
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

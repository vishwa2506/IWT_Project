<?php
// Start the session
session_start();

// Include your database connection file
require('db.php'); // Ensure db.php sets up a MySQLi connection

// Initialize a success flag
$registrationSuccess = false;

// Handle registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING); // Add phone number sanitization

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^\d{10}$/', $phone_number)) { // Validate phone number (10 digits)
        $error = "Invalid phone number format. It should be 10 digits.";
    } else {
        // Check if email already exists
        $checkQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $con->prepare($checkQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            // Insert new user into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Use password_hash for better security
            $query = "INSERT INTO users (name, email, gender, password, phone_number, type) VALUES (?, ?, ?, ?, ?, 0)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssss", $name, $email, $gender, $hashed_password, $phone_number); // Bind phone number

            if ($stmt->execute()) {
                // Registration successful
                $_SESSION['name'] = $name; // Store name in session
                $registrationSuccess = true; // Set the success flag
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Master - Register</title>
    <link rel="stylesheet" type="text/css" href="styles/regstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script>
        function validateEmail(email) {
            const emailField = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regex.test(email)) {
                emailError.innerText = "Invalid email format.";
                emailField.classList.add('error-input');
                return false; // Prevent form submission
            } else {
                emailError.innerText = "";
                emailField.classList.remove('error-input');
                return true; // Valid email
            }
        }

        function validatePhoneNumber() {
    const phoneField = document.getElementById('phone_number');
    const phoneError = document.getElementById('phone-error');
    const regex = /^\d{10}$/; // Regular expression for exactly 10 digits

    if (!regex.test(phoneField.value)) {
        phoneError.innerText = "Invalid phone number format. It must be exactly 10 digits.";
        phoneField.classList.add('error-input');
        return false; // Prevent form submission
    } else {
        phoneError.innerText = ""; // Clear any previous error message
        phoneField.classList.remove('error-input'); // Remove error styling
        return true; // Valid phone number
    }
}


        function validatePasswords() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordError = document.getElementById('password-error');

            if (password === "") {
                passwordError.innerText = "Password cannot be empty.";
                passwordError.style.display = "block"; // Show error
                return false; // Prevent form submission
            }

            if (password !== confirmPassword) {
                passwordError.innerText = "Passwords do not match.";
                passwordError.style.display = "block"; // Show error
                return false; // Prevent form submission
            } else {
                passwordError.innerText = "";
                passwordError.style.display = "none"; // Hide error
                return true; // Valid passwords
            }
        }

        function validateForm() {
            const email = document.getElementById('email').value;
            return validateEmail(email) && validatePasswords() && validatePhoneNumber(); // Ensure all validations pass
        }

        function showSuccessAlert() {
            alert("You have registered successfully! Click OK to proceed to login.");
            window.location.href = 'login.php'; // Redirect to login page after alert
        }
    </script>
</head>
<body>
<header>
    <div class="logo">
        <a href="#">Fitness Master</a>
    </div>
    <nav>
        <ul>
            <li><a href="login.php">Sign In</a></li>
            <li><a href="register.php" class="active">Sign Up</a></li>
            <li><a href="bmi.php">Calculate BMI</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<div id="page-container">
    <div id="content-wrap">
        <div class="container">
            <form class="form" method="post" onsubmit="return validateForm()">
                <h1 class="login-title">Sign Up</h1>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                
                <div class="input-group">
                    <input type="text" class="login-input" name="name" placeholder="Name" required />
                    <i class="fas fa-user"></i>
                </div>
                
                <div class="input-group">
                    <input type="email" class="login-input" id="email" name="email" placeholder="Email Address" onblur="validateEmail(this.value)" required />
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="input-group">
    <input type="tel" class="login-input" id="phone_number" name="phone_number" placeholder="Phone Number" onblur="validatePhoneNumber()" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required />
    <i class="fas fa-phone"></i>
</div>
                
                <div class="input-group">
                    <label>Gender:</label>
                    <div>
                        <label>
                            <input type="radio" name="gender" value="Male" required> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Female"> Female
                        </label>
                    </div>
                </div>

                <div class="input-group">
                    <input type="password" class="login-input" id="password" name="password" placeholder="Password" required />
                    <i class="fas fa-lock"></i>
                </div>

                <div class="input-group">
                    <input type="password" class="login-input" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
                    <i class="fas fa-lock"></i>
                    <p class="error-message" id="password-error" style="display: none;"></p>
                </div>
                
                <input type="submit" name="submit" value="Sign Up" class="login-button">
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?> 

<!-- Trigger success alert if registration is successful -->
<?php if ($registrationSuccess) : ?>
    <script>
        showSuccessAlert();
    </script>
<?php endif; ?>

</body>
</html>

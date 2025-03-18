<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <link rel="stylesheet" href="cont1a.css">
</head>
<body>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="container">
    <div class="header">
            <img src="2.jpeg" alt="W-Safe Logo" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
            <h1>W-Safe</h1>
        </div>

        <div class="form-container">
            <!-- Contact Form -->
            <form method="POST" action="" id="contactForm">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required placeholder="Enter your name">
                </div>

                <div class="input-group">
                    <label for="phone">Email</label>
                    <input type="email" name="phone" id="phone" required placeholder="Enter email">
                </div>

                <!-- Hidden fields for location -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                
                <div class="button-group">
                    <button type="submit" name="add_contact" class="btn add-btn">Add Contact</button>
                    <button type="submit" name="panic" class="btn panic-btn" onclick="getLocation()">Panic (Send Email)</button>
                </div>
            </form>
        </div>

        <!-- Display contacts here -->
        <div class="contact-list-container">
            <h2>Contact List</h2>

            <!-- PHP to process form and display contacts -->
            <?php
            // Include PHPMailer classes
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';
           
            // Database connection
            $servername = "localhost";
            $username = "root"; // Your DB username
            $password = ""; // Your DB password
            $database = "contact_management"; // Your DB name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (isset($_POST['add_contact'])) {
                // Add contact to the database when form is submitted
                $name = $_POST['name'];
                $email = $_POST['phone'];
                $sql = "INSERT INTO users (name, phone) VALUES ('$name', '$email')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Contact added successfully</p>";
                } else {
                    echo "<p>Error adding contact: " . $conn->error . "</p>";
                }
            }

            // Fetch and display contacts
            $sql = "SELECT name, phone FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Name</th><th>Email</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['name'] . "</td><td>" . $row['phone'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No contacts found.</p>";
            }

            if (isset($_POST['panic'])) {
                $latitude = $_POST['latitude'];
                $longitude = $_POST['longitude'];
                
                $sql = "SELECT phone FROM users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'divyasri29032005@gmail.com'; // Replace with your email
                        $mail->Password ='pdaujdxlkgmrnrow'; // Replace with your email password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Send email to each contact
                        while ($row = $result->fetch_assoc()) {
                            $mail->addAddress($row['phone']);
                            $mail->isHTML(true);
                            $mail->Subject = 'Emergency Alert';
                            $mail->Body = 'I am in emergency,please help me.Here is my live location' .
                                          'Latitude: ' . $latitude . '<br>' .
                                          'Longitude: ' . $longitude . '<br>' .
                                          'Google Maps: <a href="https://www.google.com/maps/search/?api=1&query=' . $latitude . ',' . $longitude . '">View Location</a>';
                            $mail->send();
                            $mail->clearAddresses();
                        }

                        echo 'All messages have been sent successfully';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    echo "No email addresses found.";
                }

                $conn->close();
            }
            ?>
        </div>
    </div>

    <!-- JavaScript for getting location -->
    <script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        document.getElementById("latitude").value = position.coords.latitude;
        document.getElementById("longitude").value = position.coords.longitude;
        document.getElementById("contactForm").submit(); // Automatically submit form after location is set
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }
    </script>
</body>
</html>

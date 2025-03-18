<?php
if (isset($_POST['panic'])) {
    $location = $_POST['location']; // Get location from the form

    $sql = "SELECT email FROM users";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        //Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'divyasri29032005@gmail.com';                     //SMTP username            
            $mail->Password   = 'pdaujdxlkgmrnrow';                     
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        
            $mail->Port       = 587;                                   

            while ($row = $result->fetch_assoc()) {
                $mail->addAddress($row['email']);  
                $mail->isHTML(true);                                  
                $mail->Subject = 'Emergency Alert!';
                $mail->Body    = 'This is an emergency alert! <br><b>Location:</b> ' . $location;
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
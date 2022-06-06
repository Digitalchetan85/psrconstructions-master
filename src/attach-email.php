<?php
    
    $result = '';

    //echo "hello";
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    if (isset($_POST['submit'])){
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        //echo $email;
        //$email = $_POST['email'];
        $phone = $_POST['phone'];
        $apply = $_POST['apply'];
        $exp = $_POST['experience'];
        
        $file = $_FILES['userfile'];
       //print_r($file);
        
        $fileName = $_FILES['userfile']['name'];
        $fileTmpName = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileError = $_FILES['userfile']['error'];
        $fileType = $_FILES['userfile']['type'];
       // echo $fileName;
        $fileExt = explode('.', $fileName);
        //echo $fileExt;
        $fileActualExt = strtolower(end($fileExt));
        //echo $fileActualExt;
        $allowed = array('jpg', 'jepg', 'png', 'docx', 'pdf');
        
        if (in_array($fileActualExt, $allowed)){
            if ($fileError === 0){
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'attachment/'.$fileNameNew;
                    //echo $fileDestination;
                    if (move_uploaded_file($fileTmpName, $fileDestination)){
                        $mail = new PHPMailer(true);
                        //echo get_class($mail);
                        //echo $path;
                    //echo "success";
                        try {
                        //Server settings
                        //$mail->SMTPDebug = 2;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;
                        //$mail->SMTPAutoTLS = false;// Enable SMTP authentication
                        $mail->Username   = 'digitalchetan85@gmail.com';                     // SMTP username
                        $mail->Password   = 'csipmdjhoniovkxq';                                 // SMTP password
                        $mail->SMTPSecure = tls;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                        //Recipients
                        $mail->setFrom($email);
                        $mail->addAddress('chetankumar.nv@gmail.com', 'Digital Chetan');     // Add a recipient
                        //$mail->addAddress('ellen@example.com');               // Name is optional
                        //$mail->addReplyTo('info@example.com', 'Information');
                        //$mail->addCC('cc@example.com');
                        //$mail->addBCC('bcc@example.com');

                        // Attachments
                        $mail->addAttachment($fileDestination);         // Add attachments
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Online Enquiry';
                        $mail->Body    = '<html><body>';
                        $mail->Body   .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                        $mail->Body   .= "<tr style='background: #eee;'><td colspan=1><strong>Enquiry Details:</strong> </td>";
                        $mail->Body   .= "<tr><td><strong>Name:</strong> </td><td>" . strip_tags($_POST['name']) . "</td></tr>";
                        $mail->Body   .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['email']) . "</td></tr>";
                        $mail->Body   .= "<tr><td><strong>phone:</strong> </td><td>" . strip_tags($_POST['phone']) . "</td></tr>";
                        //$mail->Body   .= "<tr><td><strong>Contact No:</strong> </td><td>" . strip_tags($_POST['phone']) . "</td></tr>";
                        $mail->Body   .=  "<tr><td><strong>Apllied for:</strong> </td><td>" . strip_tags($_POST['apply']) . "</td></tr>";
                        $mail->Body   .=  "<tr><td><strong>Experience:</strong> </td><td>" . strip_tags($_POST['experience']) . "</td></tr>";
                        $mail->Body   .= "</table>";
                        $mail->Body   .= "</body></html>";
                        
                        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        ?>
                            <script language="javascript" type="text/javascript">
                            alert('Thank you for the message. We will contact you shortly.');
                            window.location = 'about-us.html';
                            </script>
                        <?php
                        //$result = "<p class='text-center text-success'><strong>Thank You for your request. Will get back to you shortly.</strong></p>";
                        } catch (Exception $e) {
                            ?>
                            <script language="javascript" type="text/javascript">
                            alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
                            window.location = 'about-us.html';
                            </script>
                        <?php
                        }
                    } else {
                        ?>
                            <script language="javascript" type="text/javascript">
                            alert('Failed!! Try again..');
                            window.location = 'about-us.html';
                            </script>
                        <?php
                    }
                    
                } else {
                    ?>
                        <script language="javascript" type="text/javascript">
                        alert('Your file is to big!');
                        window.location = 'about-us.html';
                        </script>
                    <?php
                }
            } else {
                ?>
                    <script language="javascript" type="text/javascript">
                    alert('There was an error uploading your file!');
                    window.location = 'about-us.html';
                    </script>
                <?php
            }
        } else {
            ?>
                <script language="javascript" type="text/javascript">
                alert('You cannot upload files of this type!!');
                window.location = 'about-us.html';
                </script>
            <?php
        }
    }
    
?>
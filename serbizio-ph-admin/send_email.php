<?php
// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'])) {
    $user_email = $data['email'];
    $admin_email = "csv2021tech@gmail.com";
    $subject = "Beta Test Registration";
    $body = "A user wants to join the beta test:\n\nEmail: $user_email";

    // Send the email
    if (mail($admin_email, $subject, $body)) {
        http_response_code(200); // Send a 200 response if the email is sent successfully
    } else {
        http_response_code(500); // Send a 500 response if there's an error
    }
} else {
    http_response_code(400); // Bad request if email is not set
}
?>

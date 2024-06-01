<?php
//Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$_SESSION = array();

//When login out, kills session with cookies.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
 

session_destroy();

//After killing it, returns you to loggin
header("Location: http://localhost/Projects/PF/loggin.html");
exit();

?>

<!-- Overall, this isnt a good solution:
    -Hardcoding the URL might not be flexible and can be problematic if the structure of the project changes or if the script is moved to a different domain.

    -Lack of HTTPS

    -It is important to check if session_destroy() is called after the session cookie is invalidated, as failing to do so might leave a small window where the session is still considered valid.
    
    -The script does not include any security headers that could further protect the user and the application, such as X-Content-Type-Options, X-Frame-Options, or Content-Security-Policy. These headers help mitigate some common attack vectors like MIME type sniffing, clickjacking, and cross-site scripting (XSS).
-->

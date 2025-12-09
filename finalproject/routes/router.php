<?php

// Default path if page is missing or invalid → go to login
$path = "index.php?page=login";

// If 'page' is not set at all, redirect to login
if (!isset($_GET['page'])) {
    header('location: '.$path);
    exit;
}

$page = $_GET['page'];

require_once 'includes/security.php';

if ($page === "login") {

    require_once 'views/loginForm.php';
    $content = init();
}

else if ($page === "welcome") {

    require_once 'views/welcome.php';
    $content = init();
}

else if ($page === "addContact") {

    require_once 'views/addContactForm.php';
    $content = init();
}

else if ($page === "deleteContacts") {

    require_once 'views/deleteContactsTable.php';
    $content = init();
}

else if ($page === "addAdmin") {

        require_once 'views/addAdminForm.php';
        $content = init();
 }
     else if ($page === "deleteAdmins") {
   require_once 'views/deleteAdminsTable.php';
    $content = init();
 }

else {

    // Any wrong parameter → back to login
    header('location: '.$path);
    exit;
}
?>

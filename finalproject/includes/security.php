<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Pages that should ONLY be visible when logged in
$protectedPages = ['welcome', 'addContact', 'deleteContacts', 'addAdmin', 'deleteAdmins'];

// Redirect to login if not logged in and trying to access protected page
if (!isset($_SESSION['user']) && in_array($page, $protectedPages)) {
    header('Location: index.php?page=login');
    exit;
}

// Role-based access control
if (isset($_SESSION['user'])) {

    $status = isset($_SESSION['user']['status']) ? $_SESSION['user']['status'] : '';

    // Pages only admins can access
    $adminOnlyPages = ['addAdmin', 'deleteAdmins'];

    // Redirect staff trying to access admin pages
    if (in_array($page, $adminOnlyPages) && $status !== 'admin') {
        header('Location: index.php?page=login');
        exit;
    }
}

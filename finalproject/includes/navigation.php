<?php

// Build nav links based on login status and role
$links = '';

if (isset($_SESSION['user'])) {
    $links = ' ';

    // Everyone logged in sees Add Contact, Delete Contacts
  
    $links .= '<li class="nav-item">
                    <a class="nav-link" href="index.php?page=addContact">Add Contact</a>
               </li>';
    $links .= '<li class="nav-item">
                    <a class="nav-link" href="index.php?page=deleteContacts">Delete contact(s)</a>
               </li>';

    // Admin-only links
    if (isset($_SESSION['user']['status']) && $_SESSION['user']['status'] === 'admin') {
        $links .= '<li class="nav-item">
                        <a class="nav-link" href="index.php?page=addAdmin">Add Admin</a>
                   </li>';
        $links .= '<li class="nav-item">
                        <a class="nav-link" href="index.php?page=deleteAdmins">Delete Admin(s)</a>
                   </li>';
    }

    // Logout link for anyone logged in
    $links .= '<li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
               </li>';
}

$nav = <<<HTML
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                {$links}
            </ul>
        </div>
    </nav>
HTML;

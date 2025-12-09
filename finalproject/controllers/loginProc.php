<?php

require_once 'classes/StickyForm.php';
require_once 'classes/Pdo_methods.php';

$acknowledgment = ' ';

$formConfig = [
    'email' => [
        'type' => 'text',
        'regex' => 'email',
        'label' => 'Email',
        'name' => 'email',
        'id' => 'email',
        'errorMsg' => 'You must enter a valid email address.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'password' => [
        'type' => 'password',
        'regex' => 'password',
        'label' => 'Password',
        'name' => 'password',
        'id' => 'password',
        'errorMsg' => 'You must enter a valid password.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'masterStatus' => [
        'error' => false
    ]
];

$stickyForm = new StickyForm();
$pdo = new PdoMethods();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate form input
    $formConfig = $stickyForm->validateForm($_POST, $formConfig);

    if (!$stickyForm->hasErrors() && $formConfig['masterStatus']['error'] == false) {

        $sql = "SELECT id, name, email, password, status 
                FROM admins 
                WHERE email = :email";

        $bindings = [
            [':email', $_POST['email'], 'str']
        ];

        $records = $pdo->selectBinded($sql, $bindings);

        if ($records === 'error' || count($records) === 0) {
            // Email format fine, password not empty but no matching record
            $acknowledgment = '<p style="color:black;">Login credentials incorrect</p>';
        }
        else {

            $user = $records[0];

            if (password_verify($_POST['password'], $user['password'])) {

                // Login successful: store user in session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'status' => $user['status']  // 'admin' or 'staff'
                ];

                // Redirect to welcome page
                header('Location: index.php?page=welcome');
                exit;
            }
            else {
                //password doesn't match but both field valid
                $acknowledgment ='<p style="color:black;">Login credentials incorrect</p>';
            }
        }

        // To not keep the password value in the field
        $formConfig['password']['value'] = '';
    }
    
}

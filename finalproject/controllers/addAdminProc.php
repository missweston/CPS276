<?php

require_once 'classes/StickyForm.php';
require_once 'classes/Pdo_methods.php';

$acknowledgment = "<p>&nbsp;</p>";

$formConfig = [
    'name' => [
        'type' => 'text',
        'regex' => 'name',
        'label' => 'Name',
        'name' => 'name',
        'id' => 'name',
        'errorMsg' => 'You must enter a valid name.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
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
        'type' => 'text',
        'regex' => 'password',
        'label' => 'Password',
        'name' => 'password',
        'id' => 'password',
        'errorMsg' => 'You must enter a valid password.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'status' => [
        'type' => 'select',
        'label' => 'Status',
        'name' => 'status',
        'id' => 'status',
        'errorMsg' => 'You must select a status.',
        'error' => '',
        'required' => true,
        'selected' => '0',
        'options' => [
            '0'      => 'Please Select a Status',
            'staff'  => 'Staff',
            'admin'  => 'Admin'
        ]
    ],
    'masterStatus' => [
        'error' => false
    ]
];

$stickyForm = new StickyForm();
$pdo = new PdoMethods();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate the form using StickyForm
    $formConfig = $stickyForm->validateForm($_POST, $formConfig);

    if (!$stickyForm->hasErrors() && $formConfig['masterStatus']['error'] == false) {

        // Check for duplicate email
        $sql = "SELECT id FROM admins WHERE email = :email";
        $bindings = [
            [':email', $_POST['email'], 'str']
        ];

        $records = $pdo->selectBinded($sql, $bindings);

        if ($records === 'error') {
            $acknowledgment = '<p style="color:red">There was an error checking the email.</p>';
        }
        else if (count($records) > 0) {
            $acknowledgment = '<p style="color:red">That email is already in use.</p>';
        }
        else {
            // Hash the password
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO admins (name, email, password, status)
                    VALUES (:name, :email, :password, :status)";

            $bindings = [
                [':name', $_POST['name'], 'str'],
                [':email', $_POST['email'], 'str'],
                [':password', $hash, 'str'],
                [':status', $_POST['status'], 'str']
            ];

            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'error') {
                $acknowledgment = '<p style="color:red">There was an error adding the admin.</p>';
            }
            else {
                $acknowledgment = '<p style="color:green">Admin added.</p>';

                // Clear form fields on success
                $formConfig['name']['value']     = '';
                $formConfig['email']['value']    = '';
                $formConfig['password']['value'] = '';
                $formConfig['status']['selected'] = '0';
            }
        }

        // Never keep password value
        $formConfig['password']['value'] = '';
    }
    else {
        // Validation failed; don't keep password
        $formConfig['password']['value'] = '';
    }
}

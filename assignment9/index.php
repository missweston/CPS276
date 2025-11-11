<?php

require_once 'classes/StickyForm.php';
 



$formConfig = [
    'firstName' => [
        'type' => 'text',
        'regex' => 'name',
        'label' => 'First Name',
        'name' => 'first_name',
        'id' => 'first_name',
        'errorMsg' => 'Please enter a valid first name.',
        'error' => '',
        'required' => true,
        'value' => 'Ty'
    ],

    'lastName' => [
        'type' => 'text',
        'regex' => 'name',
        'label' => 'Last Name',
        'name' => 'last_name',
        'id' => 'last_name',
        'errorMsg' => 'Please enter a valid last name.',
        'error' => '',
        'required' => false,
        'value' => 'Weston'
    ],

    'email' => [
        'type' => 'text',
        'regex' => 'email',
        'label' => 'Email',
        'name' => 'email',
        'id' => 'email',
        'errorMsg' => 'Please enter a valid email address.',
        'error' => '',
        'required' => false,
        'value' => 'tyweston@wccnet.edu'

    ],

    'password' => [
        'type' => 'password',
        'regex' => 'password',
        'label' => 'Password',
        'name' => 'password',
        'id' => 'password',
        'errorMsg' => 'Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.',
        'error' => '',
        'required' => true,
        'value' => 'A$signment9'
    ],

    'confirm_password' => [
        'type' => 'password',
        'regex' => 'confirm_password',
        'label' => 'Confirm Password',
        'name' => 'confirm_password',
        'id' => 'confirm_password',
        'errorMsg' => 'Passwords do not match.',
        'error' => '',
        'required' => true,
        'value' => 'A$signment9'
    ]
    ];

    // Initialize StickyForm instance for form handling 
    $stickyForm = new StickyForm();
    $successMsg = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_POST['first_name']        = $_POST['firstName']  ?? '';
    $_POST['last_name']         = $_POST['lastName']   ?? '';
    $_POST['password']          = $_POST['password']  ?? '';
    $_POST['confirm_password']  = $_POST['confirm_password']  ?? '';


$formConfig = $stickyForm->validateForm($_POST, $formConfig);

if (!$stickyForm->hasErrors() && $formConfig['masterStatus']['error'] == false) {
    require_once 'classes/Pdo_methods.php';
    $pdo = new Pdo_methods();
    
    //Duplicate email check
    $sqlCheck = "SELECT user_id FROM users WHERE user_email = :em LIMIT 1";
    $bindsCheck = [[":em", $_POST['email'], "str"]];
    $exists = $pdo->selectBinded($sqlCheck, $bindsCheck);


             if ($exists === 'error') {
            $formConfig['masterStatus']['error'] = true;
            $formConfig['masterStatus']['msg']   = 'Database error while checking email.';
        } elseif (!empty($exists)) {
            $formConfig['email']['error'] = 'That email is already registered.';
            $formConfig['masterStatus']['error'] = true;
            $formConfig['masterStatus']['msg']   = 'User with email already exist';
        } else {
            // Insert user hashed password
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sqlIns   = "INSERT INTO users (user_firstname, user_lastname, user_email, user_passwordhash)
                         VALUES (:fn, :ln, :em, :ph)";
            $bindsIns = [
                [":fn", $_POST['first_name'], "str"],
                [":ln", $_POST['last_name'],  "str"],
                [":em", $_POST['email'],      "str"],
                [":ph", $hash,                "str"],
            ];
            $ins = $pdo->otherBinded($sqlIns, $bindsIns);

            if ($ins === 'error') {
                $formConfig['masterStatus']['error'] = true;
                $formConfig['masterStatus']['msg']   = 'Database error while inserting.';
            } else {
                // Clear fields on success
                $formConfig['firstName']['value'] = '';
                $formConfig['lastName']['value']  = '';
                $formConfig['email']['value']      = '';
                $formConfig['password']['value']   = '';
                $formConfig['confirm_password']['value'] = '';
                $successMsg = 'You have been added to the database';

            }
        }

        }
    }
    ?>





<!DOCTYPE html>
<html>
<head>
    <title>Sticky Form Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
<p>&nbsp;</p> 
<?php if (!empty($successMsg)) : ?>
    <p class="text-success"><?php echo $successMsg; ?></p>
<?php endif; ?>
<form method="post" action="">
        <div class="row">
            <!-- Render first name field -->
            <div class="col-md-6">
                <div class="mb-3">
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" id="first_name" name="firstName" value="<?php echo htmlspecialchars($formConfig['firstName']['value']); ?>">
    <?php if (!empty($formConfig['firstName']['error'])) : ?>
        <div class="text-danger"><?php echo $formConfig['firstName']['error']; ?></div>
    <?php endif; ?>
</div>            </div>

            <!-- Render last name field -->
            <div class="col-md-6">
                <div class="mb-3">
    <label for="last_name">Last Name</label>
    <input type="text" class="form-control" id="last_name" name="lastName" value="<?php echo htmlspecialchars($formConfig['lastName']['value']); ?>">
    <?php if (!empty($formConfig['lastName']['error'])) : ?>
        <div class="text-danger"><?php echo $formConfig['lastName']['error']; ?></div>
    <?php endif; ?>
</div>            </div>
        </div>

        
        <!-- Render email password password -->
        <div class="row">
           
            <div class="col-md-4">
                <div class="mb-3">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($formConfig['email']['value']); ?>">
    <?php if (!empty($formConfig['email']['error'])) : ?>
        <div class="text-danger"><?php echo $formConfig['email']['error']; ?></div>
    <?php endif; ?>
</div>            </div>
            <div class="col-md-4">
                <div class="mb-3">
    <label for="password">Password</label>
    <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($formConfig['password']['value']); ?>">
    <?php if (!empty($formConfig['password']['error'])) : ?>
        <div class="text-danger"><?php echo $formConfig['password']['error']; ?></div>
    <?php endif; ?>
</div>            </div>
            <div class="col-md-4">
                <div class="mb-3">
    <label for="confirm_password">Confirm Password</label>
    <input type="text" class="form-control" id="confirm_password" name="confirm_password" value="<?php echo htmlspecialchars($formConfig['confirm_password']['value']); ?>">
    <?php if (!empty($formConfig['confirm_password']['error'])) : ?>
        <div class="text-danger"><?php echo $formConfig['confirm_password']['error']; ?></div>
    <?php endif; ?>
</div>            </div>
        </div>
     
        <input type="submit" class="btn btn-primary" value="Register">
    </form>
        <table class="table table-bordered mt-2">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Password</th>
        </tr><tr>

<?php
// One-line render of rows
require_once 'classes/Pdo_methods.php';
$pdo  = new Pdo_methods();
$rows = $pdo->selectBinded(
    "SELECT user_firstname, user_lastname, user_email, user_passwordhash FROM users ORDER BY user_id DESC",
    []
);
echo $stickyForm->renderUserTableRows($rows);
?>
        </table>
</div>

</body>
</html>


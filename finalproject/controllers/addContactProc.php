<?php

require_once('classes/StickyForm.php');
require_once('classes/Pdo_methods.php');

$acknowledgment = "<p></p>";//I use $acknowledgment as a placeholder because sometimes it has data and sometimes it does not and if it does not I don't want the space to collapse. 

$formConfig = [
    'first_name' => [
        'type' => 'text',
        'regex' => 'name',
        'label' => 'First Name',
        'name' => 'first_name',
        'id' => 'first_name',
        'errorMsg' => 'You must enter a valid first name',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'last_name' => [
        'type' => 'text',
        'regex' => 'name',
        'label' => 'Last Name',
        'name' => 'last_name',
        'id' => 'last_name',
        'errorMsg' => 'You must enter a valid last name.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'address' => [
        'type' => 'text',
        'regex' => 'address',
        'label' => 'Address',
        'name' => 'address',
        'id' => 'address',
        'errorMsg' => 'You must enter a valid address.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'city' => [
        'type' => 'text',
        'regex' => 'city',
        'label' => 'City',
        'name' => 'city',
        'id' => 'city',
        'errorMsg' => 'You must enter a valid city.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'state' => [
        'type' => 'select',
        'label' => 'State',
        'name' => 'state',
        'id' => 'state',
        'errorMsg' => 'You must select a state.',
        'error' => '',
        'selected' => '0',
        'required' => true,
        'options' => [
            '0' => 'Please Select a State',
            'ca' => 'California',
            'tx' => 'Texas',
            'mi' => 'Michigan',
            'ny' => 'New York',
            'fl' => 'Florida'
        ]
    ],
    'zip' => [
        'type' => 'text',
        'regex' => 'zip',
        'label' => 'Zip Code',
        'name' => 'zip',
        'id' => 'zip',
        'errorMsg' => 'You must enter a valid zip code.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'phone' => [
        'type' => 'text',
        'regex' => 'phone',
        'label' => 'Phone',
        'name' => 'phone',
        'id' => 'phone',
        'errorMsg' => 'You must enter a valid phone number.',
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
    'dob' => [
        'type' => 'text',
        'regex' => 'date',
        'label' => 'Date of Birth',
        'name' => 'dob',
        'id' => 'dob',
        'errorMsg' => 'You must enter a valid date of birth.',
        'error' => '',
        'required' => true,
        'value' => ''
    ],
    'age_range' => [
        'type' => 'radio',
        'label' => 'Choose an Age Range',
        'name' => 'age_range',
        'id' => 'age_range',
        'errorMsg' => 'You must select an age range',
        'error' => '',
        'required' => true,
        'options' => [
            ['value' => '0-17', 'label' => '0-17', 'checked' => false],
            ['value' => '18-30', 'label' => '18-30', 'checked' => false],
            ['value' => '30-50', 'label' => '30-50', 'checked' => false],
            ['value' => '50+', 'label' => '50+', 'checked' => false]
        ]
    ],
    'contact_preferences' => [
        'type' => 'checkbox',
        'label' => 'Select one or more options',
        'name' => 'contact_preferences',
        'id' => 'contact_preferences',
        'error' => '',
        'required' => false,
        'options' => [
            ['value' => 'Newsletter', 'label' => 'Newsletter', 'checked' => false],
            ['value' => 'Email', 'label' => 'Email', 'checked' => false],
            ['value' => 'Text', 'label' => 'Text', 'checked' => false]
        ]
    ],
       
    'masterStatus' => [
        'error' => false
    ]

];


// Initialize StickyForm instance
$stickyForm = new StickyForm();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $formConfig = $stickyForm->validateForm($_POST, $formConfig);
    if (!$stickyForm->hasErrors() && $formConfig['masterStatus']['error'] == false) {
      
      $pdo = new PdoMethods;

      // Process contact preferences checkboxes
      $contactsValue = '';
      if (isset($_POST['contact_preferences']) && is_array($_POST['contact_preferences'])) {
        $contactsValue = implode(', ', $_POST['contact_preferences']);
      }

      // Process age range
      $ageValue = $_POST['age_range'] ?? '';

      $sql = "INSERT INTO contacts 
      (contact_fname, contact_lname, contact_address, contact_city, contact_state, contact_zip,
      contact_phone, contact_email, contact_dob, contact_contacts, contact_age )
       VALUES (:fname, :lname, :address, :city, :state, :zip, :phone, :email, :dob, :contacts, :age)";

      $bindings = [
        [':fname',$_POST['first_name'],'str'],
        [':lname',$_POST['last_name'],'str'],
        [':address',$_POST['address'],'str'],
        [':city',$_POST['city'],'str'],
        [':state',$_POST['state'],'str'],
        [':zip',$_POST['zip'],'str'],
        [':phone',$_POST['phone'],'str'],
        [':email',$_POST['email'],'str'],
        [':dob',$_POST['dob'],'str'],
        [':contacts',$contactsValue,'str'],
        [':age',$ageValue,'str']
      ];

      $result = $pdo->otherBinded($sql, $bindings);

      if($result === 'error'){
        $acknowledgment = '<p style="color: red">There was an error adding the name</p>';
      }
      else {
        $acknowledgment = '<p style="color: green"> Contact has been added</p>';

        // Clear form values after successful submission
        $formConfig['first_name']['value'] = '';
        $formConfig['last_name']['value'] = ''; 
        $formConfig['address']['value'] = '';
        $formConfig['city']['value'] = '';
        $formConfig['state']['selected'] = '0';
        $formConfig['zip']['value'] = '';
        $formConfig['phone']['value'] = '';
        $formConfig['email']['value'] = '';
        $formConfig['dob']['value'] = '';
        
        // Clear age range radio buttons
        foreach ($formConfig['age_range']['options'] as &$option) {
          $option['checked'] = false;
        }
        
        // Clear contact preferences checkboxes
        foreach ($formConfig['contact_preferences']['options'] as &$option) {
          $option['checked'] = false;
        }


      }
    }  
}
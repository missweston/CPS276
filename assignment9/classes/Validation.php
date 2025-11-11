<?php

class Validation {

    public function checkFormat ($value, $type, $customErrorMsg = '') {

        $patterns = [ 
            'name' => '/^[a-z\'\s]{1,50}$/i', //Allows letters, apostrophes, and spaces
            'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', //Standard email format
            'password' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', // At least 8 characters, 1 uppercase, 1 number, 1 special character
        ];

        if(!isset($patterns[$type])) {return true; }
        return (bool)preg_match($patterns[$type], $value);
    }

}

/* 


Why does StickyForm extend Validation instead of including validation logic directly? What are the benefits of this design?

Separating logic into a validation class allows for better organization and resuability. 
validation handles input checking, while stickyform maintains form data. 
sitcky form calls checkFormat() instead of reimplementing validation logic. 




Explain what "sticky form" means. How does it improve user experience compared to a non-sticky form?


A "sticky form" retains user input after submission, especially if there are validation errors.
This improves user experience allowing users to correct errors without re-entering all information.


Describe the validation process. When does validation occur, and what happens if validation fails?

Validation occurs when the form is submitted (POST request).
Each field is checked against its rules (required, regex).
If validation fails, error messages are set for each invalid field, and the form is re-displayed with user input preserved.



Explain the purpose of the $formConfig array. What information does it store, and how is it used throughout the form lifecycle?

The $formConfig array stores the configuration for each form field, including its name, label, type, and validation rules.
It is used to generate the form, validate input, and display error messages.


What is the purpose of masterStatus['error'] in the form configuration? How does it coordinate validation across multiple form fields?

Serves as a global flag indicating if any field has validation errors.
If any field fails validation, masterStatus['error'] is set to true or optional msg, 
the submit path checks this once to if it should stop or proceed with processing.

*/
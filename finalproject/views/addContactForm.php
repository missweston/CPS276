<?php
require_once 'controllers/addContactProc.php';
function init(){
  global $formConfig, $stickyForm, $acknowledgment;
  

return<<<HTML
{$acknowledgment}
<div class="container mt-5">

    <form method="post" action="">
        <div class="row">
            <!-- Render first name field -->
            <div class="col-md-6">
                {$stickyForm->renderInput($formConfig['first_name'], 'mb-3')}
            </div>

            <!-- Render last name field -->
            <div class="col-md-6">
                {$stickyForm->renderInput($formConfig['last_name'], 'mb-3')}
            </div>
        </div>

        <!-- Render address field -->
        <div class="row">
            <div class="col-md-12">
                {$stickyForm->renderInput($formConfig['address'], 'mb-3')}
            </div>
        </div>

        <!-- Render city, state, and zip code fields -->
        <div class="row">
            <div class="col-md-4">
                {$stickyForm->renderInput($formConfig['city'], 'mb-3')}
            </div>
            <div class="col-md-4">
                {$stickyForm->renderSelect($formConfig['state'], 'mb-3')}
            </div>
            <div class="col-md-4">
                {$stickyForm->renderInput($formConfig['zip'], 'mb-3')}
            </div>
        </div>

        <!-- Render phone, email, and dob fields -->
        <div class="row">
            <div class="col-md-4">
                {$stickyForm->renderInput($formConfig['phone'], 'mb-3')}
            </div>
            <div class="col-md-4">
                {$stickyForm->renderInput($formConfig['email'], 'mb-3')}
            </div>
            <div class="col-md-4">
                {$stickyForm->renderInput($formConfig['dob'], 'mb-3')}
            </div>
        </div>

        <!-- Render age range radio buttons -->
        <div class="row">
            <div class="col-md-12">
                {$stickyForm->renderRadio($formConfig['age_range'], 'mb-3', 'horizontal')}
            </div>
        </div>

        <!-- Render contact preferences checkboxes -->
        <div class="row">
            <div class="col-md-12">
                {$stickyForm->renderCheckboxGroup($formConfig['contact_preferences'], 'mb-3', 'horizontal')}
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Add Contact">
    </form>
</div>

HTML;

}

?>
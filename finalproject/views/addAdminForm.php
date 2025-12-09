<?php
require_once 'controllers/addAdminProc.php';

function init() {
    global $formConfig, $stickyForm, $acknowledgment;

    return <<<HTML
    {$acknowledgment}
    <div class="container mt-5">
        <h1>Add Admin</h1>
        <form method="post" action="index.php?page=addAdmin">
            <div class="row">
                <div class="col-md-6">
                    {$stickyForm->renderInput($formConfig['name'], 'mb-3')}
                </div>
                <div class="col-md-6">
                    {$stickyForm->renderInput($formConfig['email'], 'mb-3')}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    {$stickyForm->renderInput($formConfig['password'], 'mb-3')}
                </div>
                <div class="col-md-6">
                    {$stickyForm->renderSelect($formConfig['status'], 'mb-3')}
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Add Admin">
        </form>
    </div>
HTML;
}
?>

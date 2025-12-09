<?php

require_once 'classes/Pdo_methods.php';
$pdo = new PdoMethods();

$msg = "<p>&nbsp;</p>";
$output = "";
$deleted = false;

if (isset($_POST['delete'])) {
    if (isset($_POST['chkbx'])) {

        foreach ($_POST['chkbx'] as $id) {

            $sql = "DELETE FROM admins WHERE id = :id";
            $bindings = [
                [':id', $id, 'int'],
            ];
            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'error') {
                $msg = "<p>There was a problem deleting this admin.</p>";
                break;
            }
            else {
                $deleted = true;
            }
        }
    }
}

// Get all admin records for the table
$sql = "SELECT * FROM admins";
$records = $pdo->selectNotBinded($sql);

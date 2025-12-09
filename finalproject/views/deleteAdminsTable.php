<?php
require_once 'controllers/deleteAdminProc.php';

function init() {
    global $records, $msg, $deleted;

    if ($records == "error") {
        $msg = "<p style='color:red'>Could not display admin records</p>";
        $output = "";
    }
    else if (count($records) === 0) {
        $msg = "<p>&nbsp;</p>";
        $output = "<p>There are no admin records to display</p>";
    }
    else {
        $output = <<<HTML

        <form method='post' action='index.php?page=deleteAdmins'>
            <input type='submit' class='btn btn-danger' name='delete' value='Delete'/><br><br>
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password (hashed)</th>
                        <th>Status</th>
                        <th>Delete?</th>
                    </tr>
                </thead>
                <tbody>

HTML;

        foreach ($records as $row) {
            $output .= "<tr>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['password']}</td>
                <td>{$row['status']}</td>
                <td><input type='checkbox' name='chkbx[]' value='{$row['id']}' /></td>
            </tr>";
        }

        $output .= "</tbody></table></form>";

        if (!$deleted) {
            $msg = "<p>&nbsp;</p>";
        }
        else {
            $msg = "<p style='color: green'>Admin(s) deleted</p>";
        }
    }

    return $msg . $output;
}
?>

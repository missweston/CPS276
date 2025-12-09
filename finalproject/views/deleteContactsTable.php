<?php
require_once 'controllers/deleteContactProc.php';

function init(){
    global $records, $msg, $deleted;
    if(count($records) === 0){
        $msg = "<p></p>";
        $output = "<p>There are no records to display</p>";
    }
    else {
        $output = <<<HTML

        <form method='post' action='index.php?page=deleteContacts'>
            <input type='submit' class='btn btn-danger' name='delete' value='Delete'/><br><br><table class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Contacts</th>
                    <th>Age</th>
                    <th>Delete?</th>

                </tr>
            </thead>
        <tbody>

HTML;

        foreach($records as $row){
            $output .= "<tr>
            <td>{$row['contact_fname']}</td>
            <td>{$row['contact_lname']}</td>
            <td>{$row['contact_address']}</td>
            <td>{$row['contact_city']}</td>
            <td>{$row['contact_state']}</td>
            <td>{$row['contact_zip']}</td>
            <td>{$row['contact_phone']}</td>
            <td>{$row['contact_email']}</td>
            <td>{$row['contact_dob']}</td>
            <td>{$row['contact_contacts']}</td>
            <td>{$row['contact_age']}</td>
            <td><input type='checkbox' name='chkbx[]' value='{$row['contact_id']}' /></td></tr>";
        }

        $output .= "</tbody></table></form>";

        if($records == "error"){
            $msg = "<p style='color:red'>Could not display records</p>";
        }
        else {
            if(!$deleted){
                $msg = "<p>&nbsp;</p>";
            }
            else {
                $msg = "<p style='color: green'>Contact(s) deleted</p>";
            }
            
        }
        
    }

    return $msg.$output;
}
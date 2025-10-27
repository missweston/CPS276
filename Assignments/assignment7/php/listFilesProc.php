<?php
require_once 'classes/Pdo_methods.php';

$output = "";

$pdo = new PdoMethods();

$sql = "SELECT user_file_Name, file_path FROM uploaded_files ORDER BY id DESC";
$records = $pdo->selectNotBinded($sql);

if ($records == 'error') {
    $output = "<p> There was an error retrieving the file list. <p>";
} 

    elseif (count($records) === 0) {
    $output = "No files found.";
} 
    else {
    $listItems = "";
    
    foreach ($records as $row) {
        $displayName = htmlspecialchars($row['user_file_Name']);
        $href = htmlspecialchars($row['file_path']);

        $listItems .= "<li><a target='_blank' href='{$href}'>{$displayName}</a></li>";
    }

    $output = "<ul>{$listItems}</ul>";
}
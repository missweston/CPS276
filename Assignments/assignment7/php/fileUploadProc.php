<?php
require_once 'classes/Pdo_methods.php';


$output = "";  // index.php will echo this exactly



class FileApp extends PdoMethods {

    public function processUpload() {

        // only act on POST. If it's not POST, just return "" so the page stays quiet.
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return "";
        }

        // pull values
        $userFileName = isset($_POST['fileName']) ? trim($_POST['fileName']) : "";
        $file = isset($_FILES['file']) ? $_FILES['file'] : null;

        // required fields check
        if ($userFileName === "" || $file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return "<p> Select a file and provide a name. </p>";
        }

        // size check
        if ($file["size"] > 100000 || $file["error"] === UPLOAD_ERR_INI_SIZE) {
            return "<p> File is too large </p>";
        }

        // mime type check
        $mimeType = mime_content_type($file["tmp_name"]);
        if ($mimeType !== 'application/pdf') {
            return "<p> PDF files only please </p>";
        }

        // build server path and public path
        // this script is in assignment7/php/
        // ../files/ should be assignment7/files/
       // build the upload destination
    $serverDir = "../assignment7/files/";
    $serverFilePath = $serverDir . basename($file["name"]);
    $publicPath = "files/" . basename($file["name"]);

       // Make sure upload directory exists
            if (!is_dir($serverDir)) {
        // Folder is missing. Instructor says it should already exist.
               return "<p>Upload directory not found.</p>";
         }

        // Make sure we can write to it
        if (!is_writable($serverDir)) {
            return "<p>Upload directory is not writable.</p>";
        }

// Try to move uploaded file
if (!move_uploaded_file($file["tmp_name"], $serverFilePath)) {
    return "<p>There was an error uploading your file.</p>";
}

// Insert into DB using PdoMethods
$sql = "INSERT INTO uploaded_files (user_file_Name, file_path) VALUES (:fname, :fpath)";
$bindings = [
    [":fname", $userFileName, "str"],
    [":fpath", $publicPath, "str"]
];

$result = $this->otherBinded($sql, $bindings);

if ($result === "noerror") {
    return "<p>File uploaded </p>";
}
else {
    // Remove the uploaded file if DB insert fails
    if (file_exists($serverFilePath)) {
        unlink($serverFilePath);
    }
    return "<p>There was a problem saving the file information </p>";
}

        }
    }

// run the processor and capture its return into $output
$app = new FileApp();
$output = $app->processUpload();
?>


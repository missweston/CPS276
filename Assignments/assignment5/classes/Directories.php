<?php 

class Directories {
    public $directoryname;
    public $filecontent;
   
    //Create Directory and put file content in it
    public function createDirectory() {
        $path = 'directories/' . $this->directoryname; // Define the path where the directory will be created
       
        if (is_dir($path)) {
            return "A directory with that name already exists.";
        }

        $success = mkdir($path); // Create the directory
        if (!$success) {
            return "There was an error creating the directory.";
        }
         chmod($path, 0777); // Set permissions to read, write, execute for all

         if (file_put_contents($path . "readme.txt", $this->filecontent) === false) {
            return "Failed to create file inside directory.";
         }
         return "<a href='$path/readme.txt' target='_blank'>Path where file is located</a>";
           
    }

}


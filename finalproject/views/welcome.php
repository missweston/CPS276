<?php
function init(){
   $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';

    return <<<HTML
    <h1>Welcome Page</h1>
    <p>Welcome {$name}</p>
HTML;
}
?>
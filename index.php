<?php

declare(strict_types=1);

// require_once __DIR__ . "/assets/php/db-insertion.php"; // Importing the database insertion PHP file
require_once "assets/php/advice-fetching.php"; // Importing the advice fetching PHP file
require_once "assets/php/functions.php"; // Importing the functions PHP file

# Setting the advice for default use
$id = set_id($advice);
$advice = set_text($advice);

?>

<!DOCTYPE html>
<html lang="en">

<?php render_template("head"); // Renders the head template
?>
<?php render_template("body", ["id" => $id, "advice" => $advice]); // Renders the body template 
?>

</html>
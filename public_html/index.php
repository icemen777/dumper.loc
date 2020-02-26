<?php
session_start();
require __DIR__ . '/../main/Mainclass.php';
require __DIR__ . '/../main/User.php';
$app = new Mainclass();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<p><a href="http://dumper.loc/index.php">Go Home</a> </p>
<?php
if(isset($_SESSION['userid']))    {
    print "пользователь авторизован";
    $app->userin=true;
}
?>




<div class="parent">
    <div class="block">
        <p>Form</p>
        <?php $app->run(); ?>
    </div>
</div>
</body>

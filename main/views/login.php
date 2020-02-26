<?php ?>
<h2>Login page</h2>
<?php
echo 'Count - ', $user->count;
?>
<form action="index.php" method="post">
    <button type="submit" name="logout" value="1">Logout</button>
    <button type="submit" name="add" value="2">ADD</button>
</form>

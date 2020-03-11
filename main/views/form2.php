<form action="index.php" method="post">
    <p><input type="text" value="name" name="name"></p>
    <p>
        <select name="day">
            <?for ($i=1; $i<=31; $i++) :?>
                <option><?=$i?></option>
            <?endfor?>
        </select>
        <select name="mounth">
            <?for ($i=1; $i<=12; $i++) :?>
                <option><?=$i?></option>
            <?endfor?>
        </select>
        <select name="year" value="Год">
            <?for ($i=date('Y', time()); $i>1899; $i--) :?>
                <option><?=$i?></option>
            <?endfor?>
        </select>
    </p>
    <p><input type="password" value="" name="pass"></p>
    <button type="submit" name="register" value="1">Register</button>
</form>
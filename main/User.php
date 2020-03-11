<?php


class User
{
    public $user;
    public $count;

    function __construct()
    {
        $this->user=$this->DB_Connect();
    }

    function DB_Connect()
    {
        $dsn = 'mysql:host=localhost;dbname=yii2';
        $username = 'root';
        $password = '';
        try {
            $dbh = new PDO($dsn, $username, $password);
            }
            catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $dbh;
    }

    function login($post) {
        if (is_string($post['name']) && is_string($post['pass'])) {
            $nick = htmlspecialchars($post['name']);
            $pass = htmlspecialchars($post['pass']);
            $pass = hash('md5', $pass);
            $this->userTest(['nick'=>$nick, 'pass'=>$pass]);
        } else {
            echo 'Invalid input Data';
        }
    }

    public function calcUserAge($date, $mounth, $year)
    {
        $newDate = new DateTime();
        $oldDate = new DateTime("$year-$mounth-$date");
        return  $newDate->diff($oldDate);
    }

    function register($post) {
        $today = date("Y");
        if (is_string($post['name']) && is_string($post['pass'])) {
            $nick = $post['name'];
            $pass = $post['pass'];
            $pass = hash('md5', $pass);


            $day = (int)$post['day'];
            $mounth = (int)$post['mounth'];
            $year = (int)$post['year'];

            $age = $this->calcUserAge($day, $mounth, $year)->y;

            if(!checkdate($mounth,$day,$year)) {
                $this->error = "Это был не такой длинный месяц!";
                echo 'Too long month';
                die();
            }


            if ($age<6) {
                echo 'Too Young'; die();
            }
            if ($age>100) {
                echo 'Too old'; die();
            }
            $this->userSave(['nick'=>$nick, 'pass' => $pass, 'birth' => $age]);
            return (true);
        }
    }

    function userSave($us)
    {
        //var_dump($us);
        $nick = $us['nick'];
        $pass = $us['pass'];
        $birth = $us['birth'];
        $sql = "INSERT INTO user (username, password_hash, birthday) VALUES (?,?,?)";
        $this->user->prepare($sql)->execute([$nick, $pass, $birth]);
    }

    function userTest($us)
    {
        $nick = $us['nick'];
        $pass = $us['pass'];

        $sql = "SELECT * FROM user WHERE username=? AND password_hash=?";
        $sth = $this->user->prepare($sql);
        $test = $sth->execute([$nick, $pass]);

        if ($sth->rowCount() == 1) {
            $id = $sth->fetch(0)['id'];
            session_start();
            $_SESSION['userid'] = $id;
            return (TRUE);
        }
        return (FALSE);
    }



    function incCount($counter)
    {
        $counter++;
        $id = $_SESSION['userid'];
        $sql = "UPDATE user SET status=? WHERE id=?";
        $sth = $this->user->prepare($sql);
        $test = $sth->execute([$counter, $id]);
    }

    function getCount()
    {
        $id = $_SESSION['userid'];
        $sql = "SELECT * FROM user WHERE id=?";
        $sth = $this->user->prepare($sql);
        $test = $sth->execute([$id]);
        if ($sth->rowCount() == 1) {
            $count = $sth->fetch(0)['status'];
            $this->count = $count;
            return $count;
        }
        return (FALSE);
    }
}
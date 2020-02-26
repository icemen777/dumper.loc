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

    function register($post) {
        $today = date("Y");
        if (is_string($post['name']) && is_string($post['pass']) && is_string($post['birth'])) {
            $nick = htmlspecialchars($post['name']);
            $pass = htmlspecialchars($post['pass']);
            $pass = hash('md5', $pass);
            $birth = htmlspecialchars($post['birth']);

            $year = (date_parse_from_format("Y.n.j", $birth))['year'];
            $age = (int)$today - (int)$year;
            if ($age<6) {
                echo 'Too Young'; die();
            }
            if ($age>100) {
                echo 'Too old'; die();
            }
            $this->userSave(['nick'=>$nick, 'pass' => $pass, 'birth' => $birth]);
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



    function incCount($status)
    {
        $status++;
        $id = $_SESSION['userid'];
        $sql = "UPDATE user SET status=? WHERE id=?";
        $sth = $this->user->prepare($sql);
        $test = $sth->execute([$status, $id]);
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
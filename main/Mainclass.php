<?php


class Mainclass
{
    private static $Page;
    public $userin;

    function  __construct()
    {
        $this->setPage('form1.php');
        if ($_POST) $this->form();
    }

    public function run()
    {
        if (!$this->userin) {
            return (require self::$Page);
        } else {
            $user = new User();
            $this->setPage('login.php');
            $user->getCount();
            return (require self::$Page);
        }
    }



    function form()
    {
        if ($_POST['add']=='2') {
            $user = new User();
            $count = $user->getCount();
            $user->incCount($count);
            $this->setPage('login.php');
        }
        if ($_POST['login']=='1') {
            $user = new User();
            $user->login($_POST);
            $this->setPage('login.php');
        }
        if ($_POST['register']=='2') {
            $this->setPage('form2.php');
        }
        if ($_POST['register']=='1' || $this->userin) {
            $user = new User();
            $user->register($_POST);
            $this->setPage('login.php');
        }
        if ($_POST['logout']=='1') {
            unset($_SESSION['userid']);
            session_destroy();
            $this->setPage('form1.php');
            header("Location: /index.php"); die();
        }

    }

    function setPage ($n)
    {
        self::$Page = 'views/'.$n;
    }

}
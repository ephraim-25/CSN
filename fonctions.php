<?php


function findUserBylogin($login)
{

    global $con;

    $statement = $con->prepare("SELECT login FROM utilisateur WHERE login=?");

    $statement->execute(array($login));

    $count = $statement->rowCount();

    return $count;
}

function findUserByemail($email)
{

    global $con;

    $statement = $con->prepare("SELECT email FROM utilisateur WHERE email=?");

    $statement->execute(array($email));

    $count = $statement->rowCount();

    return $count;
}

function redirectPage($messag, $url = null, $seconds = 2)
{

    if ($url === null) {

        $url = 'dashboard.php';

        $back = 'HomePage';
    } elseif ($url == 'back') {

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {

            $url = $_SERVER['HTTP_REFERER'];

            $back = 'Previous Page';
        } else {

            $url = 'dashboard.php';

            $back = 'HomePage';
        }
    }
    echo $messag;

    echo "<div class='alert alert-info'> You Will be redirected after $seconds seconds</div>";

    header("refresh:$seconds;url=$url");

    exit();
}

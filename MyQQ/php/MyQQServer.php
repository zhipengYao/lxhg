<?php

include_once './Server.php';
include_once './UserServer.php';

$requestobj = json_decode($_REQUEST["request"]);

$sv = new Server();
$type = $requestobj->type;
$typearr = explode("_", $type);


switch ($typearr[0]) {
    case "USER":
        $sv = new UserServer();
        break;
}

$sv->setRequest($requestobj);


if (!$sv->openConnection()) {
    echo json_encode($sv->getResponse());
    exit(1);
}

$sv->run();
$sv->closeConnection();

echo json_encode($sv->getResponse());







/*

if ($requestobj->type === "USER_LOGIN") {

     $username = $requestobj->params->username;
     $password = $requestobj->params->password;
      $constr = "host=127.0.0.1 port=5432 dbname=webgis user=postgres password=yaozp369";
      $con = pg_connect($constr);
      if (!$con) {
      echo json_encode(array(
      "success" => false,
      "message" => "Can't connect to DATABASE"
      ));
      exit(1);
      }

      $sql = "select count(1) from qq_user where username='{$username}' and passwd='{$password}'";
      $result = pg_query($con, $sql);
      if (!$result) {
      echo json_encode(array("success" => false, "message" => "query did not execute"));
      exit(1);
      }
      $row = pg_fetch_row($result, 0);
      if (intval($row[0]) === 1) {
      echo json_encode(array("success" => true, "message" => "登录成功！"));
      } else {
      echo json_encode(array("success" => false, "message" => "登录失败！"));
      exit(1);
      }

      pg_free_result($result);
      pg_close($con);

}




if ($requestobj->type === "USER_Register") {

    $username = $requestobj->params->username;
    $password = $requestobj->params->password;
    $repassword = $requestobj->params->repassword;
    $email = $requestobj->params->email;
    $telephone = $requestobj->params->telephone;



    if ($username === '') {
        echo json_encode(array("success" => false, "noWord" => true));
        exit(1);
    } else if ($password === '') {
        echo json_encode(array("success" => false, "noWord" => true));
        exit(1);
    } else if ($email === '') {
        echo json_encode(array("success" => false, "noWord" => true));
        exit(1);
    } else if ($telephone === '') {
        echo json_encode(array("success" => false, "noWord" => true));
        exit(1);
    }

    $passwordpattern = "/^[a-zA-Z\d_]{6,16}$/";
    if (!preg_match($passwordpattern, $password)) {
        echo json_encode(array("success" => false, "passFormatWrong" => true));
        exit(0);
    }



    $emailpattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if (!preg_match($emailpattern, $email)) {
        echo json_encode(array("success" => false, "emailFormatWrong" => true));
        exit(0);
    }

    $telepattern = "/^1[3|4|5|7|8]\d{9}$/";
    if (!preg_match($telepattern, $telephone)) {
        echo json_encode(array("success" => false, "teleFormatWrong" => true));
        exit(0);
    }

    if ($password === $repassword) {

        $constr = "host=127.0.0.1 port=5432 dbname=webgis user=postgres password=yaozp369";
        $con = pg_connect($constr);
        if (!$con) {
            echo json_encode(array(
                "success" => false,
                "message" => "Can't connect to DATABASE"
            ));
            exit(1);
        }
        $sql = "select username from qq_user where username='{$username}'";
        $result = pg_query($con, $sql);

        if (pg_num_rows($result)) {
            echo json_encode(array("success" => false, "sameUsername" => true));
            exit(0);
        } else {
            $sql_insert = "insert into qq_user(username,passwd,email,telephone) values('$username','$password','$email','$telephone')";
            $res_insert = pg_query($con, $sql_insert);
            if ($res_insert) {
                echo json_encode(array("success" => true, "registsuccess" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "注册失败！"));
            }
            pg_free_result($res_insert);
        }

        pg_free_result($result);
        pg_close($con);
    } else {
        echo json_encode(array("success" => false, "repasswordWrong" => true));
        exit(0);
    }
}
 * 
 * 
 */





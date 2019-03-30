<?php

class UserServer extends Server {

    public function __construct() {
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function run() {
        parent::run();

        switch ($this->_request->type) {
            case "USER_LOGIN":
                $this->login();
                break;
            case "USER_Register":
                $this->register();
                break;
            case "USER_Friends":
                $this->getFriends();
                break;
        }
    }

    protected function login() {
        $username = $this->_request->params->username;
        $password = $this->_request->params->password;

        $sql = "select count(1) from qq_user where username='{$username}' and passwd='{$password}'";
        $result = pg_query($this->_con, $sql);
        if (!$result) {
            $this->makeSuccessResponse(false, "query did not execute");
            exit(1);
        }
        $row = pg_fetch_row($result, 0);

        if (intval($row[0]) === 1) {
            $this->makeSuccessResponse(true, "登录成功！");
        } else {
            $this->makeSuccessResponse(false, "登录失败！");
        }

        pg_free_result($result);
    }

    protected function register() {
        $username = $this->_request->params->username;
        $password = $this->_request->params->password;
        $repassword = $this->_request->params->repassword;
        $email = $this->_request->params->email;
        $telephone = $this->_request->params->telephone;



        if ($username === '') {
            $this->makeSuccessResponse(false, "不能为空！");
        } else if ($password === '') {
            $this->makeSuccessResponse(false, "不能为空！");
        } else if ($email === '') {
            $this->makeSuccessResponse(false, "不能为空！");
        } else if ($telephone === '') {
            $this->makeSuccessResponse(false, "不能为空！");
        } else {

            $passwordpattern = "/^[a-zA-Z\d_]{6,16}$/";
            if (!preg_match($passwordpattern, $password)) {
                $this->makeSuccessResponse(false, "密码格式错误，不能有特殊字符！");
            } else {

                $emailpattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
                if (!preg_match($emailpattern, $email)) {
                    $this->makeSuccessResponse(false, "邮箱格式错误！");
                } else {

                    $telepattern = "/^1[3|4|5|7|8]\d{9}$/";
                    if (!preg_match($telepattern, $telephone)) {
                        $this->makeSuccessResponse(false, "电话号码格式错误！");
                    } else {

                        if ($password === $repassword) {

                            $sql = "select username from qq_user where username='{$username}'";
                            $result = pg_query($this->_con, $sql);

                            if (pg_num_rows($result)) {
                                $this->makeSuccessResponse(false, "用户名重复！");
                            } else {
                                $sql_insert = "insert into qq_user(username,passwd,email,telephone) values('$username','$password','$email','$telephone')";
                                $res_insert = pg_query($this->_con, $sql_insert);
                                if ($res_insert) {
                                    $this->makeSuccessResponse(true, "注册成功！");
                                } else {
                                    $this->makeSuccessResponse(false, "注册失败！");
                                }
                                pg_free_result($res_insert);
                            }
                            pg_free_result($result);
                        } else {
                            $this->makeSuccessResponse(false, "密码重复错误！");
                        }
                    }
                }
            }
        }
    }

    protected function getFriends() {
        $username = $this->_request->params->username;
        $a = array(); //存放好友数和好友用户名 
        /*
          $sql = "select count(1) from qq_friendship where user1=(select id from qq_user where username='{$username}')";
          $result = pg_query($this->_con, $sql);
          if (!$result) {
          $this->makeSuccessResponse(false, "query did not execute");
          }
          $rownum = pg_fetch_row($result, 0);
          // $this->makeSuccessResponse(true, "得到好友数",array(friendsnum=>$rownum));
          array_push($a, $rownum);
         * 
         */

        //下面开始获取好友用户名
        //
        //改了千百次，最终还是回到原点，发现败在了一个=号上，就像武功练到极致后的返璞归真。。。.
        $sql = "select username from qq_user where id in (select user2 from qq_friendship where user1=(select id from qq_user where username='{$username}'))";
        $result = pg_query($this->_con, $sql);
        if (!$result) {
            $this->makeSuccessResponse(false, "query did not execute");
        }
        $num = pg_numrows($result);
        array_push($a, $num);
        //for语句这个地方调试的时候迷了我好久呀。
        for ($i = 0; $i < $num; $i++) {
            $rowuser = pg_fetch_row($result, $i); //这就得到了好友的id号啦
            array_push($a, $rowuser);
            /*     $sql1 = "select username from qq_user where id='{$rowuserid}'";
              $resultusername = pg_query($this->_con, $sql1);
              if ($resultusername) {
              $this->makeSuccessResponse(false, "query did not execute");
              }
              $rowusername = pg_fetch_row($resultusername, 0);
              array_push($a,$rowusername);
             * 
             */
        }
        // $this->makeSuccessResponse(true, "好友列表id", $b[0]);

        $this->makeSuccessResponse(true, "你他娘的终于成功了！", $a);
    }

}

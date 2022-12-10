<?php
require_once "dbstatus.php";
class DB
{
    private $Connection;
    public function __construct($options = null)
    {
        if ($options == null) {
            global $options;
            $DBHost = $options["db"]["LocalHost"];
            $DBName = $options["db"]["Name"];
            $DBUser = $options["db"]["User"];
            $DBPass = $options["db"]["Password"];

            try {
                $this->Connection = new PDO("mysql:hostname=$DBHost;dbname=$DBName", $DBUser, $DBPass);
                $this->Connection->exec("set character set utf-8");
                $this->Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (ErrorException $error) {
                echo ("Faild " . $error->getMessage());
            }
        }
    }
    public function AddToDb($Name,$Lastname,$UserName,$Email,$Password)
    {
        $query = "select count(*) from Users where UserName=?";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $UserName);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count >= 1) {
            return false;
        } else {
            $Passhash = password_hash($Password, PASSWORD_DEFAULT);
            $query = "insert into Users values (null,?,?,?,?,0,?,Null)";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $UserName);
            $result->bindValue(2, $Passhash);
            $result->bindValue(3, $Name);
            $result->bindValue(4, $Lastname);
            $result->bindValue(5, $Email);
            $finish = $result->execute();
            if ($finish) {
                return true;
                //header("Location:index.php");
            }
        }
    }
    function UpdateData($Title, $Phone, $Email, $Location,$UserID)
    {
        $query = "select count(*) from data where userid=?";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $UserID);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count >= 1) 
        {
            $query = "update data set title=?,phone=?,email=?,location=? where userid=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $Title);
            $result->bindValue(2, $Phone);
            $result->bindValue(3, $Email);
            $result->bindValue(4, $Location);
            $result->bindValue(5, $UserID);
            $result->execute();
            if ($result->rowCount() == 0) {
                return false;
            }
            return true;
        }
        else{
            $query = "insert into data values (null,?,?,?,?,?,'','')";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $UserID);
            $result->bindValue(2, $Title);
            $result->bindValue(3, $Phone);
            $result->bindValue(4, $Email);
            $result->bindValue(5, $Location);
            $finish = $result->execute();
            if ($finish) {
                return true;
            }
        }

    }
    function UpdateAbout($S_Title,$S_Des,$UserID)
    {
        $query = "select count(*) from data where userid=?";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $UserID);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count >= 1) 
        {
            $query = "update data set s_title=?,s_des=? where userid=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $S_Title);
            $result->bindValue(2, $S_Des);
            $result->bindValue(3, $UserID);
            $result->execute();
            if ($result->rowCount() == 0) {
                return false;
            }
            return true;
        }
        else{
            $query = "insert into data values (null,?,'','','','',?,?)";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $UserID);
            $result->bindValue(2, $S_Title);
            $result->bindValue(3, $S_Des);
            $finish = $result->execute();
            if ($finish) {
                return true;
            }
        }

    }
    function UpdateUser($OldUserName, $UserName, $Password, $Name)
    {
        $query = "update users set UserName=?,Password=?,Name=? where UserName=? ";
        $Passhash = password_hash($Password, PASSWORD_DEFAULT);
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $UserName);
        $result->bindValue(2, $Passhash);
        $result->bindValue(3, $Name);
        $result->bindValue(4, $OldUserName);
        $result->execute();
        if ($result->rowCount() == 0) {
            return false;
        }
        return true;
    }

    function UpdateService($select, $Title, $Icon, $Description,$UserID)
    {
        if($select=='none'){
            $query = "insert into services values (null,?,?,?,?)";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $UserID);
            $result->bindValue(2, $Title);
            $result->bindValue(3, $Icon);
            $result->bindValue(4, $Description);
            $finish = $result->execute();
            if ($finish) {
                return true;
            }
        }
        else{
            $query = "select count(*) from services where userid=? and id=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $UserID);
            $result->bindValue(2, $select);
            $result->execute();
            $count = $result->fetchColumn();
            if ($count >= 1) {
                $query = "update services set title=?,icon=?,description=? where id=? ";
                $result = $this->Connection->prepare($query);
                $result->bindValue(1, $Title);
                $result->bindValue(2, $Icon);
                $result->bindValue(3, $Description);
                $result->bindValue(4, $select);
                $result->execute();
                if ($result->rowCount() == 0) {
                    return false;
                }
                return true;
            }

        }

    }

    function DeleteService($select,$UserID){
        $query = "delete from services where id=? and userid=?";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $select);
        $result->bindValue(2, $UserID);
        $finish = $result->execute();
        if ($finish) {
            return true;
        }
    }


    function CheckAcc($UserName)
    {
        $query = "select * from Users where UserName=:UserName";
        $result = $this->Connection->prepare($query);
        $result->bindValue(':UserName', $UserName);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_OBJ);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
    function getRememberMEToken($UserName)
    {
        $query = "update users set RememberMe=? where UserName=?";
        $token = md5(microtime() . $UserName);
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $token);
        $result->bindValue(2, $UserName);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $token;
        } else {
            return false;
        }
    }
    function Forcelogin($token)
    {
        $query = "select * from Users where rememberme=:token";
        $result = $this->Connection->prepare($query);
        $result->bindValue(":token", $token);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_OBJ);
        if ($user) {
            $_SESSION['login'] = array(
                'status' => true,
                'info' => $user,
            );
        } else {
            return false;
        }
    }
    function GetData($UserName)
    {
        $query = "select * from Users where UserName=:UserName";
        $result = $this->Connection->prepare($query);
        $result->bindValue(':UserName', $UserName);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_OBJ);
        if ($user) {
            $query = "select * from data where userid=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $user->id);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data;
        }
    }
    function GetService($UserName)
    {
        $query = "select * from users where UserName=:UserName";
        $result = $this->Connection->prepare($query);
        $result->bindValue(':UserName', $UserName);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_OBJ);
        if ($user) {
            $query = "select * from services where userid=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $user->id);
            $result->execute();
            $data = $result->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }
    }
    function AddRequest($Name,$Email,$Description,$UserID){
        $query = "insert into requests values (null,?,?,?,?)";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $UserID);
        $result->bindValue(2, $Name);
        $result->bindValue(3, $Email);
        $result->bindValue(4, $Description);
        $finish = $result->execute();
        if ($finish) {
            return true;
        }
    }
    function GetRequests($UserName){
        $query = "select * from users where UserName=:UserName";
        $result = $this->Connection->prepare($query);
        $result->bindValue(':UserName', $UserName);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_OBJ);
        if ($user) {
            $query = "select * from requests where userid=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $user->id);
            $result->execute();
            $data = $result->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }
    }

    function GetCv(){
     
        $query = "select * from users";
        $result = $this->Connection->prepare($query);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_OBJ);
        return $data;
        
    }
}

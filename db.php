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

    function UpdateCVPublished($published,$cvid){
        $query = "select count(*) from users_cv where ID=?";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $cvid);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count >= 1) 
        {
            $query = "update users_cv set Published=? where ID=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $published);
            $result->bindValue(2, $cvid);
            $result->execute();
            if ($result->rowCount() == 0) {
                return false;
            }
            return true;
        }
        else{return false;
        }
    }

    function DeleteCV($cvid){
        $query = "delete from users_cv where ID=?";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $cvid);
        $result->execute();
        
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

    function GetpublishedCv(){
     
        $query = "select * from users_cv where Published=1";
        $result = $this->Connection->prepare($query);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_OBJ);
        return $data;
        
    }

    function GetCv(){
     
        $query = "select * from users_cv";
        $result = $this->Connection->prepare($query);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_OBJ);
        return $data;
        
    }

    function GetUser($UserID){
        $query = "select * from Users where ID=:UserID";
        $result = $this->Connection->prepare($query);
        $result->bindValue(':UserID', $UserID);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_OBJ);
        return $user;
    
    }

    function GetCVByID($UserID){
     
        $query = "select * from users_cv where UserID=:UserID";
        $result = $this->Connection->prepare($query);
        $result->bindValue(':UserID', $UserID);
        $result->execute();
        $user = $result->fetch(PDO::FETCH_OBJ);
        if ($user) {
            return $user;
        } else {
            return false;
        }
        
    }
    
    function UpdateAccount($_FirstNameNew, $_LastNameNew,$_EmailNew, $UserID){
        $query = "update users set FirstName=?,LastName=?,Email=? where ID=? ";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $_FirstNameNew);
        $result->bindValue(2, $_LastNameNew);
        $result->bindValue(3, $_EmailNew);
        $result->bindValue(4, $UserID);
        $result->execute();
        if ($result->rowCount() == 0) {
            return false;
        }
        return true;
    }

    function UpdateCV($_about, $_age, $_lang , $_ywr, $_phone , $_specialties , $_gender , $_UserId){
        $query = "select count(*) from users_cv where userid=?";
        $result = $this->Connection->prepare($query);
        $result->bindValue(1, $_UserId);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count >= 1) 
        {
            $query = "update users_cv set About=?,Age=?,YWR=?,Phone=?,Specialties=?,Gender=?,Language=? where UserID=?";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $_about);
            $result->bindValue(2, $_age);
            $result->bindValue(3, $_ywr);
            $result->bindValue(4, $_phone);
            $result->bindValue(5, $_specialties);
            $result->bindValue(6, $_gender);
            $result->bindValue(7, $_lang);
            $result->bindValue(8, $_UserId);
            $result->execute();
            if ($result->rowCount() == 0) {
                return false;
            }
            return true;
        }
        else{
            $query = "insert into users_cv values (null,?,?,?,?,?,?,?,?,?)";
            $result = $this->Connection->prepare($query);
            $result->bindValue(1, $_UserId);
            $result->bindValue(2, $_about);
            $result->bindValue(3, $_age);
            $result->bindValue(4, $_ywr);
            $result->bindValue(5, $_phone);
            $result->bindValue(6, $_specialties);
            $result->bindValue(7, $_gender);
            $result->bindValue(8, $_lang);
            $result->bindValue(9, "0");
            $finish = $result->execute();
            if ($finish) {
                return true;
            }
        }
    }
}

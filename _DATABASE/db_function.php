<?php

class db_function
{

    private $username;
    private $password;
    private $host;
    private $dbname;
    private $strconn;
    private $db;

    function __construct()
    {
        $this->username = "SYSDBA"; 
        $this->password = "masterkey";
        #########
        //$this->host = "192.168.1.9"; 
        //$this->dbname = "192.168.1.9:E:\_Siska\_CGI\data\data.gdb"; 
        #########
        $this->host = "localhost"; 
        $this->dbname = "localhost:E:\data.gdb"; 
        $this->strconn = "firebird:dbname={$this->dbname};host={$this->host}";
        try 
        { 
            $this->db = new PDO($this->strconn, $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(PDOException $ex)
        {
            die("Failed Connection to database". $ex->getMessage());
        }
    }

    function get_data($sql)
    {
        $query_params = array() ;
        try
        {
            $stmt = $this->db->prepare($sql); 
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex)
        {
            die(json_encode($ex->getMessage()));
        }
        $rows = $stmt->fetchAll();
        $data = json_encode($rows);
        return $data;
    }

    function get_value($sql)
    {
        $query_params = array() ;
        try
        {
            $stmt = $this->db->prepare($sql); 
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex)
        {
            die(json_encode($ex->getMessage()));
        }
        $data = $stmt->fetch(PDO::FETCH_COLUMN);
        return $data;
    }

    public function insert_query($sql,$data)
    {
        try 
        {
            $stmt = $this->db->prepare($sql); 
            $result =$stmt->execute($data);
        }
        catch (PDOException $ex) 
        { 
            die(json_encode($ex)); 
        }
    } 
}
?>

<?php

class CreateDB{
    public $servername, $username, $password, $dbname, $tablename, $con, $sql_table_creation;
    
    public function __construct($dbname, $tablename, $servername, $username, $password, $sql_table_creation)
    {
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->sql_table_creation = $sql_table_creation;

        $this->con = mysqli_connect($servername, $username, $password);

        if(!$this->con){
            die("Connection failed: ".mysqli_connect_error());
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if( mysqli_query($this->con,$sql) ){
            $this->con = mysqli_connect($servername, $username, $password, $dbname);
            
            // Creo nueva tabla
            if( !mysqli_query($this->con, $this->sql_table_creation) ){
                echo "Error creating table: ".mysqli_error($this->con);
            } else {
                return false;
            }
        }
    }

    public function getProducts(){
        $sql = "SELECT * FROM $this->tablename";
        $result = mysqli_query($this->con, $sql);
        if( mysqli_num_rows($result)>0 ){
            return $result;
        }
    }

    public function insertProduct($producto, $presentacion, $marca, $precio, $img){
        $sql = "INSERT INTO productos (producto, presentacion, marca, precio, img) VALUES ($producto, $presentacion, $marca, $precio, $img)";
        mysqli_query($this->con, $sql);
        return;
    }

    public function checkAdminExists($dni, $contrasenia){
        $sql = "SELECT * FROM `admins` WHERE `dni`= $dni AND `contrasenia`='$contrasenia'";
        $result = mysqli_query($this->con, $sql);
        if( mysqli_num_rows($result)>0 ){
            return $result;
        }
    }
}

?>
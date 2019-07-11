<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
// HOW TO USE THIS SCRIPT > VISIT BELOW LINK
// https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046

class DatabaseConnect
{
    public $mysqli ;
    public $connectionConfig ;

    public function __construct()
    {
      
            $this->connectionConfig = array(

                // HOST ADDRESS, FOR EXAMPLE : localhost or some ip address
                'host' => 'localhost', 


                // DATABASE NAME , MAKE SURE TO CREATE THIS DATABASE FIRST
                // OR GIVE NAME OF THE EXISTING DATABASE
                // contact_us TABLE IS CREATED CREATED IN THIS DATABASE 
                'database' => 'demo_database',

                // MYSQL USER NAME
                // MAKE SURE THIS USER EXISTS AND HAS PRIVILEGES TO ABOVE DATABASE
                'user' => 'root', 


                // MYSQL USER PASSWORD
                'password' => 'root', 

                // MYSQL SEVER PORT
                // BY DEFAULT IT IS 3306
                // CHANGE IT AS PER YOUR SERVER
                'mysqlport' => 3306  
            );
         
    }


    // connects to database using $connectionConfig
    public function connect()
    {
        $this->mysqli = new mysqli(
            $this->connectionConfig['host'],
            $this->connectionConfig['user'],
            $this->connectionConfig['password'],
            $this->connectionConfig['database'],
            $this->connectionConfig['mysqlport']
        );
        if ($this->mysqli->connect_error) {
            return [
                    'connected' => false,
                    'message' => $this->mysqli->connect_error,
                ];
        } else {
            return [
                    'connected' => true,
                    'message' => 'Connected to MySql server',
                ];
        }
    }
}

//$db=new DatabaseConnect();
//var_dump($db->connect());

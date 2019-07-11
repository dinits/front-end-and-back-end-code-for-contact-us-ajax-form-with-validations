<?php

//error_reporting(E_ALL);
//ini_set('display_errors',1);
// HOW TO USE THIS SCRIPT > VISIT BELOW LINK
// https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046
include('./DatabaseConnect.php');

class CreateTable extends DatabaseConnect{

    public function __construct(){


        parent::__construct();

        $this->connect()["connected"] ? $this->create() : $this->dbconnectionFailed();

        
    }

    public function create(){

        $qry="
        CREATE TABLE IF NOT EXISTS contact_us (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(128) NOT NULL,
            email VARCHAR(320) NOT NULL,
            message VARCHAR(2048) NOT NULL,
            contacted_on DATETIME NOT NULL,
            PRIMARY KEY (id))        
        ";

        if($this->mysqli->query($qry)){
            $con=<<<CONTENT
            <h1>CONGRATS!</h1>
        <p>Your Contact Us Form is up and running. Try it here - <a href="./contact-us.html"> contact-us.html </a></p>
        <ul style="text-align:left">
            <li>TABLE - <span class="var">contact_us</span> created successfully.</li>
            <li> Add Content in <span class="var">contact-us.html</span> to your webpage or use it individually.</li>
            <li>If you don't know how to use , visit <a target="_blanc" href="https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046">OFFICIAL WEBSITE</a> to know more</li>
        </ul>    
            <p>Visit <a href="https://www.thewebblinders.in/programming">https://www.thewebblinders.in/programming</a> for more tutorials</p>

CONTENT;
            $this->sendResponse($con);
        }
        $this->sendResponse($this->mysqli->error);
    }
    public function dbconnectionFailed(){
            $con=<<<CON
   <h1>FAILED TO CONNECT TO DATABASE</h1>
   <p>Error : {$this->mysqli->connect_error}     
   <p>You supplied following input</p>
   <table>
     <tr>
       <td>HOST</td>
       <td>{$this->connectionConfig['host']}</td>
     </tr>
     <tr>
       <td>DATABASE</td>
       <td>{$this->connectionConfig['database']}</td>
     </tr>  
     <tr>
       <td>USER</td>
       <td>{$this->connectionConfig['user']}</td>
     </tr>  
     <tr>
       <td>PASSWORD</td>
       <td>{$this->connectionConfig['password']}</td>
     </tr>  
     <tr>
       <td>PORT</td>
       <td>{$this->connectionConfig['mysqlport']}</td>
     </tr>              
   </table>    
   <p>If above input is wrong , edit <span class="var">\$connectionConfig</span> array inside <span class="var">DatabaseConnect.php</span></span> and try again. </p>
   <p>Read more about  <a target="_blanc" href="https://www.php.net/manual/en/mysqli.construct.php">mysqli construct here</a></p>
   <p style="color:skyblue">If your issue is not resolved , post a comment here in the <a href="https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046" target="_blanc">OFFICIAL THREAD</a> to get it solved immediately </p>

   <p>Visit <a href="https://www.thewebblinders.in/programming">https://www.thewebblinders.in/programming</a> for more tutorials</p>
CON;

       $this->sendResponse($con);
    }

    public function sendResponse($content){

        echo <<<MESSAGE

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1.0,maximum-scale=1.0">
    <title>Result - Creating contact_us Table</title>
    <style>
    body {
        margin: 0;
        color:white;
        line-height: 1.7em;
        background: linear-gradient(to right, #ee0979, #ff6a00);
        color: white;
        font-family:Monospace;
    }
    html {
        font-size: 16px;
    }
    
    @media screen and (min-width: 320px) {
        html {
            font-size: calc(16px + 6 * ((100vw - 320px) / 680));
        }
    }
    
    @media screen and (min-width: 1000px) {
        html {
            font-size: 22px;
        }
    }    
    .fullScreenFlex {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    .responsive1000 {
        margin: 0 auto 0 auto;
        overflow: hidden;
        width: 1000px;
        text-align:center;
    }


   .var {
       background-color: SKYBLUE;
       COLOR: black;
       padding: 0.2em;
    }

    a{
        color: black;
        text-decoration-color: black;
    }
    table{
        margin:0 auto 0 auto;
        width:98%;
        text-align:center;
    }
     table td{
        padding:1em;
        border:2px solid black;
    }
    @media (max-width:1020px) {
        .responsive600 {
            width: 90%;
        }

    }
  
    </style>
</head>
<body>
   <div class="fullScreen">
      <div class="content responsive1000">
          {$content}
      </div>
   </div>
</body>
</html>

MESSAGE;

exit;
    }
}

$ct=new CreateTable();

?>
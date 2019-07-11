<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
// HOW TO USE THIS SCRIPT > VISIT BELOW LINK
// https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046

include './DatabaseConnect.php';
$db = new DatabaseConnect();

if (!($_SERVER['REQUEST_METHOD'] == 'POST') || (!$db->connect()["connected"])) {
    header('HTTP/1.0 403 Forbidden'); 
    exit;
}


class ContactUs
{

    public function __construct($mysqli)
    {
        $this->validate($mysqli);
    }

    public function validate($mysqli)
    {

        try {
            if (!isset($_POST['data']) || empty($_POST['data'])) {
                $this->sendResponse(false, "LOOKS LIKE YOU SUBMITTED THE FORM WITH OUT ANY DATA");
            }

            $data = json_decode($_POST['data'], true);


            if (!isset($data['email']) || (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) == false) {
                $this->sendResponse(false, "Invalid email");
            }


            if (!isset($data['name']) || empty($data['name']) || strlen($data['name']) < 3 || strlen($data['name']) > 60) {
                $this->sendResponse(false, "Name must be between 3 to 60 characters");
            }


            if (!isset($data['message']) || empty($data['message']) || strlen($data['message']) < 3 || strlen($data['message']) > 1024) {
                $this->sendResponse(false, "Message must be between 3 to 1024 characters");
            }


            foreach ($data as $key => $value) {
                $data[$key] = htmlspecialchars($value);
            }

            $addedOn = date('Y-m-d H:i:s');


            $qry = '
        INSERT INTO contact_us( 
            name, 
            email,
            message, 
            contacted_on)
          VALUES ( ?, ?, ?, ?)       
        ';

            if ($stmt = $mysqli->prepare($qry)) {

                $stmt->bind_param(
                    'ssss',
                    $data['name'],
                    $data['email'],
                    $data['message'],
                    $addedOn
                );

                if ($stmt->execute()) {
                    $this->sendResponse(true, "THANK YOU , WE GOT YOUR MESSAGE");
                }
            }
            $this->sendResponse(false, $mysqli->error);
        } catch (Exception $e) {
            $this->sendResponse(false, "server error or invalid data");
        }
    }



    public function sendResponse($status, $message)
    {
        try {
            $res = [
                "status" => $status,
                "message" => $message
            ];
            echo json_encode($res);
            exit;
        } catch (Exception $e) {
            $res = [
                "status" => false,
                "message" => "SERVER ERROR - CONTACT ADMINISTRATOR OR TRY AFTER SOME TIME"
            ];
            echo json_encode($res);
            exit;
        }
    }
}

(new ContactUs($db->mysqli));
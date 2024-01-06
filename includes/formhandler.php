<?php

class Formhandler extends Entry {
    private $username;
    private $password;
    private $score;

    public function __construct($username, $password, $score) {
        $this->username = $username;
        $this->password = $password;
        $this->score = $score;
    }

    public function verifyPlayer() {
        if ($this->emptyInput() == false) {
            header("location: ../index.php?error=emptyInput");
            exit();
        }
        if ($this->invalidUn() == false) {
            header("location: ../index.php?error=invalidUsername");
            exit();
        }
        if($this->unTakenCheck() == false) {
            header("location: ../index.php?error=sameUsername");
            exit();
        }
    
        $this->setUsername($this->username);
        $this->setPassword($this->username, $this->password);
        $this->setScore($this->username, $this->score);
        header("location: ../signup_success.php");
    }    

    private function emptyInput() {
        $result = false;
        if (empty($this->username) || $this->score < 0) {
            $result = false;
        } else {
            $result = true;
        }
        return $result; 
    }

    private function invalidUn() { 
        $result = false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result; 
    }

    private function unTakenCheck() {
        $result = false;
        if(!$this->checkUser($this->username)) {
            $result = false; 
        }
        else {
            $result = true;
        }
        return $result; 
    }
}
?>

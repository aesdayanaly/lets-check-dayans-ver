<?php

class Loginform extends Entry {
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

        $userExists = $this->checkUserPass($this->username);

        if ($userExists) {
            $retrievedScore = $this->getScore($this->username);
            echo "User exists. Retrieved Score: " . $retrievedScore;
        } else {
            $retrievedScore = $this->getScore($this->username);
            echo "User doesn't exist. Created user. " ;
        }
    }

    private function emptyInput() {
        $result = true;
        if (empty($this->username) || $this->score < 0) {
            $result = false;
        }
        return $result;
    }

    private function invalidUn() {
        $result = true;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = false;
        }
        return $result;
    }

    private function getScore($username) {
        try {
            $stmt = $this->connect()->prepare('SELECT score FROM players WHERE username = ?;');
            if (!$stmt->execute([$username])) {
                throw new Exception("Score retrieval failed");
            }

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;

            return $result ? $result['score'] : 0;
        } catch (Exception $e) {
            header("location: ../index.php?error=scoreRetrievalFailed");
            exit();
        }
    }
}
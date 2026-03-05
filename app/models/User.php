<?php
class User {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function findByUsername($username) {
        $u = mysqli_real_escape_string($this->db, $username);
        $r = mysqli_query($this->db, "SELECT * FROM users WHERE username = '$u'");
        return mysqli_fetch_assoc($r);
    }

    public function findById($id) {
        $id = (int)$id;
        $r  = mysqli_query($this->db, "SELECT * FROM users WHERE ID = $id");
        return mysqli_fetch_assoc($r);
    }

    public function getAll() {
        return mysqli_query($this->db, "SELECT ID, username FROM users ORDER BY username ASC");
    }

    public function usernameExists($username) {
        $u = mysqli_real_escape_string($this->db, $username);
        $r = mysqli_query($this->db, "SELECT ID FROM users WHERE username = '$u'");
        return mysqli_num_rows($r) > 0;
    }

    public function create($username, $password) {
        $u = mysqli_real_escape_string($this->db, $username);
        $p = md5($password);
        return mysqli_query($this->db, "INSERT INTO users (username, password) VALUES ('$u', '$p')");
    }

    public function updatePassword($id, $password) {
        $id = (int)$id;
        $p  = md5($password);
        return mysqli_query($this->db, "UPDATE users SET password = '$p' WHERE ID = $id");
    }

    public function delete($id) {
        $id = (int)$id;
        return mysqli_query($this->db, "DELETE FROM users WHERE ID = $id");
    }
}
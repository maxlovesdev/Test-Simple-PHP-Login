<?php
class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        // Auto-login via cookie
        if (isset($_COOKIE['ID_your_site'])) {
            $info = $this->userModel->findByUsername($_COOKIE['ID_your_site']);
            if ($info && $_COOKIE['Key_your_site'] === $info['password']) {
                header("Location: " . BASE . "/members/");
                exit();
            }
            setcookie('ID_your_site', '', time() - 3600);
            setcookie('Key_your_site', '', time() - 3600);
        }

        $error = '';
        if (isset($_POST['submit'])) {
            if (empty($_POST['username'])) {
                $error = 'You did not fill in a username.';
            } elseif (empty($_POST['pass'])) {
                $error = 'You did not fill in a password.';
            } else {
                $info = $this->userModel->findByUsername($_POST['username']);
                if (!$info) {
                    $error = 'That user does not exist in our database.';
                } elseif (md5($_POST['pass']) !== $info['password']) {
                    $error = 'Incorrect password, please try again.';
                } else {
                    $hour = time() + 3600;
                    setcookie('ID_your_site', $info['username'], $hour);
                    setcookie('Key_your_site', $info['password'], $hour);
                    header("Location: " . BASE . "/members/");
                    exit();
                }
            }
        }

        require APP . 'views/auth/login.php';
    }

    public function register() {
        $error   = '';
        $success = false;

        if (isset($_POST['submit'])) {
            if (empty($_POST['username']) || empty($_POST['pass']) || empty($_POST['pass2'])) {
                $error = 'You did not complete all of the required fields.';
            } elseif ($this->userModel->usernameExists($_POST['username'])) {
                $error = 'Sorry, the username ' . htmlspecialchars($_POST['username']) . ' is already in use.';
            } elseif ($_POST['pass'] !== $_POST['pass2']) {
                $error = 'Your passwords did not match.';
            } else {
                $this->userModel->create($_POST['username'], $_POST['pass']);
                $success = true;
            }
        }

        require APP . 'views/auth/register.php';
    }

    public function logout() {
        setcookie('ID_your_site', '', time() - 3600);
        setcookie('Key_your_site', '', time() - 3600);
        header("Location: " . BASE . "/login/");
        exit();
    }
}
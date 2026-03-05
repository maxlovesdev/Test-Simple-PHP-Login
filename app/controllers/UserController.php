<?php
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        $this->requireAuth();
    }

    private function requireAuth() {
        if (!isset($_COOKIE['ID_your_site'])) {
            header("Location: " . BASE . "/login/");
            exit();
        }
        $info = $this->userModel->findByUsername($_COOKIE['ID_your_site']);
        if (!$info || $_COOKIE['Key_your_site'] !== $info['password']) {
            setcookie('ID_your_site', '', time() - 3600);
            setcookie('Key_your_site', '', time() - 3600);
            header("Location: " . BASE . "/login/");
            exit();
        }
    }

    public function index() {
        $users = $this->userModel->getAll();
        require APP . 'views/users/index.php';
    }

    public function modify($id) {
        $targetUser = $this->userModel->findById($id);
        if (!$targetUser) {
            header("Location: " . BASE . "/members/");
            exit();
        }

        $error   = '';
        $success = false;

        if (isset($_POST['submit'])) {
            $newPass  = $_POST['new_pass']     ?? '';
            $confPass = $_POST['confirm_pass'] ?? '';

            if (empty($newPass) || empty($confPass)) {
                $error = 'Please fill in both password fields.';
            } elseif ($newPass !== $confPass) {
                $error = 'Passwords do not match.';
            } else {
                $this->userModel->updatePassword($id, $newPass);
                // Keep cookie in sync if user changed their own password
                if ($targetUser['username'] === $_COOKIE['ID_your_site']) {
                    setcookie('Key_your_site', md5($newPass), time() + 3600);
                }
                $success = true;
            }
        }

        require APP . 'views/users/modify.php';
    }

    public function delete($id) {
        $targetUser = $this->userModel->findById($id);
        // Server-side guard: never allow self-deletion
        if ($targetUser && $targetUser['username'] !== $_COOKIE['ID_your_site']) {
            $this->userModel->delete($id);
        }
        header("Location: " . BASE . "/members/");
        exit();
    }
}
<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class AuthController extends AbstractController
{
    public function login(): void
    {
        $this->render("login", []);
    }

    public function checkLogin(): void
    {

        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $tokenManager = new CSRFTokenManager();

            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);

                if ($user !== null) {
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        $_SESSION["user"] = $user->getId();

                        unset($_SESSION["error-message"]);

                        $this->redirect("index.php");
                    } else {
                        $_SESSION["error-message"] = "Invalid login information";
                        $this->redirect("index.php?route=login");
                    }
                } else {
                    $_SESSION["error-message"] = "Invalid login information";
                    $this->redirect("index.php?route=login");
                }
            } else {
                $_SESSION["error-message"] = "Invalid CSRF token";
                $this->redirect("index.php?route=login");
            }
        } else {
            $_SESSION["error-message"] = "Missing fields";
            $this->redirect("index.php?route=login");
        }
    }

    public function register(): void
    {
        $this->render("register", []);
    }

    public function checkRegister(): void
    {
        if (
            //all register form infos are posted
            isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["email"]) && $_POST["email"] !== ""
            && isset($_POST["password"]) && $_POST["password"] !== "" && isset($_POST["confirm-password"]) && $_POST["confirm-password"] !== ""
        ) {
            $tokenManager = new CSRFTokenManager();
            //check post token and session token
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                //check password is equal to password confirmation
                if ($_POST["password"] === $_POST["confirm-password"]) {
                    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}/';
                    //check password is 8chars minimum with at least 1 maj, 1min 1 number and 1 special char
                    if (preg_match($password_pattern, $_POST["password"])) {
                        $um = new UserManager();
                        $user = $um->findByEmail($_POST["email"]);
                        //check if sbmitted email is allready used
                        if ($user === null) {
                            //if not create new user, filtering html special chars preventing xss 

                            $username = htmlspecialchars($_POST["username"]);
                            $email = htmlspecialchars($_POST["email"]);
                            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                            $user = new User($username, $email, $password);

                            $um->create($user);
                            $user = $um->findByEmail($email);

                            $_SESSION["user"] = $user->getId();

                            unset($_SESSION["error-message"]);

                            $this->redirect("index.php");
                        } else {
                            $_SESSION["error-message"] = "User already exists";
                            $this->redirect("index.php?route=register");
                        }
                    } else {
                        $_SESSION["error-message"] = "Password is not strong enough";
                        $this->redirect("index.php?route=register");
                    }
                } else {
                    $_SESSION["error-message"] = "The passwords do not match";
                    $this->redirect("index.php?route=register");
                }
            } else {
                $_SESSION["error-message"] = "Invalid CSRF token" . $_POST["csrf-token"] .  "and session token=" . $_SESSION['csrf-token'];

                $this->redirect("index.php?route=register");
            }
        } else {
            $_SESSION["error-message"] = "Missing fields";
            $this->redirect("index.php?route=register");
        }
    }

    public function logout(): void
    {
        session_destroy();

        $this->redirect("index.php");
    }
}

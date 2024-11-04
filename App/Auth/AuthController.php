<?php

namespace App\Auth;


use DB\Connection;

class AuthController
{

    public function __construct()
    {
        $methods = array_filter(get_class_methods($this), function ($item) {
            return $item != "__construct" && $item != "logout";
        });
        if (isset($_SESSION["user_id"])) {
            foreach ($methods as $method) {
                if (str_contains($_SERVER["REQUEST_URI"], $method)) {
                    redirect(route("home"));
                }
            }
        }
    }

    /**
     * @param $request
     *
     * @return false|string|void
     */
    public function login($request)
    {
        if (empty($request['email']) || empty($request['password'])) {
            return view("user.login", ["error_message" => "Email and password are required"]);
        }
        $email    = filter_var($request['email'], FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($request['password']);

        $con  = Connection::connect();
        $stmt = $con->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row             = $result->fetch_assoc();
            $user_id         = $row['id'];
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                unset($_SESSION['error_message']);
                redirect(route('home'));
            } else {
                return view("user.login", ["error_massage" => "Invalid password"]);
            }
        } else {
            return view("user.login", ["error_massage" => "User not found"]);
        }
    }

    /**
     * @return false|string
     */
    public function loginPage()
    {
        return view("user.login");
    }

    public function register($request)
    {
        $_SESSION["register"] = $request;
        if (empty($request['username']) || empty($request['password']) || empty($request['confirm_password']) || empty($request['email'])) {
            return view("user.register", ["error_message" => "All fields are required"]);
        }
        if ($request['password'] !== $request['confirm_password']) {
            return view("user.register", ["error_message" => "Passwords do not match. Please ensure both fields are identical."]);
        }

        $username = $request['username'];
        $password = $request['password'];
        $email    = filter_var($request['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return view("user.register", ["error_message" => "Invalid email format"]);
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $con = Connection::connect();

        $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return view("user.register", ["error_message" => "All fields required"]);
        }

        $stmt = $con->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            $_SESSION['user_id']         = $con->insert_id;
            $_SESSION['success_message'] = "Registration successful!";
            redirect(route('home'));
        } else {
            return view("user.register", ["error_message" => "Registration failed. Please try again."]);
        }
    }

    /**
     * @return false|string
     */
    public function registerPage()
    {
        return view("user.register");
    }

    public function logout($request)
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            session_destroy();
            header("Location: " . route("login"));
            exit;
        } else {
            return json_encode(["error" => "No active session found"]);
        }
    }

}
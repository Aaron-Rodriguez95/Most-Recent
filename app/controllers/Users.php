<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
        }

        // Handles loading the form on users/register
        // Also submitting the form.
        public function register(){
            // Check for POST
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process the form
                
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                 // Init data
                 $data = [
                    'name'               => trim($_POST['name']),
                    'email'              => trim($_POST['email']),
                    'password'           => trim($_POST['password']),
                    'confirm_password'   => trim($_POST['confirm_password']),
                    'name_error'         => '',
                    'email_error'        => '',
                    'password_error'     => '',
                    'confirm_pass_error' => '',
                ];

                // Validate Email
                if(empty($data['email'])) {
                    $data['email_error'] = 'Please enter email.';
                }
                else{
                    // Check if email exists
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_error'] = "There is already an account registered to this email.";
                    }
                }
               

                // Validate Name
                if(empty($data['name'])){
                    $data['name_error'] = "Please enter your name.";
                }

                // Validate Name
                if(empty($data['password'])){
                    $data['password_error'] = "Please enter your password.";
                }
                elseif(strlen($data['password']) < 6){
                    $data['password_error'] = "Passwords must be at least 6 characters.";
                }

                // Validate Confirmed Password
                if(empty($data['confirm_password'])){
                    $data['confirm_pass_error'] = "Please confirm your password.";
                }
                else{             
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_pass_error'] = "Passwords do not match!";
                    }
                }

                // Check for errors
                if(empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_pass_error'])){
                    // Validated
                    
                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are now registered! Welcome to SharePosts');
                        redirect('Users/login');
                    }
                    else{
                        die('Something went wrong');
                    }
                }
                else{
                    // Load view with errors
                    $this->view('/Users/register', $data);
                }

                // 
            }
            else {
                // Init data
                $data = [
                    'name'               => '',
                    'email'              => '',
                    'password'           => '',
                    'confirm_password'   => '',
                    'name_error'         => '',
                    'email_error'        => '',
                    'password_error'     => '',
                    'confirm_pass_error' => '',
                ];

                // Load view
                $this->view('Users/register', $data);
            }
        }

        public function login(){
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process the form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'email'              => trim($_POST['email']),
                    'password'           => trim($_POST['password']),          
                    'email_error'        => '',
                    'password_error'     => '',
                ];

                // Validate Email
                if(empty($data['email'])) {
                    $data['email_error'] = 'Please enter email.';
                }

                if(empty($data['password'])){
                    $data['password_error'] = "Please enter password.";
                }

                if($this->userModel->findUserByEmail($data['email'])){
                    // User Found
                
                }
                else {
                    // User Not Found
                    $data['email_error'] = 'No user found';
                }

                // Check for errors
                if(empty($data['email_error']) && empty($data['password_error'])){
                    // Validated
                    // Check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser){
                        // Create Session
                        $this->createUserSession($loggedInUser);
                    }
                    else {
                        $data['password_error'] = 'Password incorrect, please try again.';
                        $this->view('/Users/login', $data);
                    }
                }
                else{
                    // Load view with errors
                    $this->view('/Users/login', $data);
                }
            }
            else {
                // Init data
                $data = [          
                    'email'            => '',
                    'password'         => '',
                    'email_error'      => '',
                    'password_error'   => '',  
                ];

                // Load view
                $this->view('Users/login', $data);
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id']    = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name']  = $user->name;

            redirect('Posts');
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();

            redirect('Users/login');
        }
    }
<?php
    session_start();
    // $_SESSION['user'] = 'AJ';
    // unset($_SESSION['user']);
    // Can also call session destroy to get rid of all variables

    // FLash message helper
    // Example - flash('register_success', 'You are now registered' 'alert alert-danger'); to overwrite class
    // DISPLAY IN VIEW - <?php echo flash('register_success'); 
    function flash($name = '', $message = '', $class ='alert alert-success'){
        if(!empty($name)){
            if(!empty($message) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }

                if(!empty($_SESSION[$name . '_class'])){
                    unset($_SESSION[$name . '_class']);
                }

                $_SESSION[$name] = $message;
                $_SESSION[$name . '_class'] = $class;
            }
            else if(empty($message) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
                echo '<div class="' . $class .'" id="msg-flash">' . $_SESSION[$name] . '</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name . '_class']);
            }
        }
    }

    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        else {
            return false;
        }
    }
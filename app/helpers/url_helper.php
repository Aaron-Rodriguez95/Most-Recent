<?php
    // Simple page redirect
    // Helper files are full of helper functions 
    // That we are able to use within the app.
    function redirect($page){
        header('location: ' . URLROOT . '/' . $page);
    }
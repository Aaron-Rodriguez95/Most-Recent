<?php
    class Posts extends Controller{
        public function __construct(){
            if(!isLoggedIn()){
                redirect('Users/login');
            }

            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }

        public function index(){
            // Get Posts
            $posts = $this->postModel->getPosts();
            $data  = [
                'posts' => $posts
            ];

            $this->view('Posts/index', $data);
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanatize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data  = [
                    'title'       => trim($_POST['title']),
                    'body'        => trim($_POST['body']),
                    'user_id'     => $_SESSION['user_id'],
                    'title_error' => '',
                    'body_error'  => ''
                ];

                // Validate title
                if(empty($data['title'])){
                    $data['title_error'] = "Please enter a title for your post";
                }

                // Validate body
                if(empty($data['body'])){
                    $data['body_error'] = "Please enter body text for your post";
                }

                // Make sure no error
                if(empty($data['title_error']) && empty($data['body_error'])){
                    // Validated
                    if($this->postModel->addPost($data)){
                        flash('post_message', 'Post added!');
                        redirect('Posts');
                    }
                    else{
                        die('Something went wrong');
                    }
                }
                else{
                    // Load view with errors
                    $this->view('Posts/add', $data);
                }
            }
            else {
                $data  = [
                    'title' => '',
                    'body'  => ''
                ];
    
                $this->view('Posts/add', $data);
            }
        }

        public function show($id) {
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);

            $data = [
                'post' => $post,
                'user' => $user
            ];

            $this->view('Posts/show', $data);
        }

        public function edit($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanatize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data  = [
                    'id'          => $id,
                    'title'       => trim($_POST['title']),
                    'body'        => trim($_POST['body']),
                    'user_id'     => $_SESSION['user_id'],
                    'title_error' => '',
                    'body_error'  => ''
                ];

                // Validate title
                if(empty($data['title'])){
                    $data['title_error'] = "Please enter a title for your post";
                }

                // Validate body
                if(empty($data['body'])){
                    $data['body_error'] = "Please enter body text for your post";
                }

                // Make sure theres no errors
                if(empty($data['title_error']) && empty($data['body_error'])){
                    // Validated
                    if($this->postModel->updatePost($data)){
                        flash('post_message', 'Post updated!');
                        redirect('Posts');
                    }
                    else{
                        die('Something went wrong');
                    }
                }
                else{
                    // Load view with errors
                    $this->view('Posts/edit', $data);
                }
            }
            else {
                // Get existing post from model
                $post = $this->postModel->getPostById($id);
                // Check if current user is the owner of the post
                if($post->user_id != $_SESSION['user_id']){
                    redirect('Posts');
                }

                $data  = [
                    'id'    => $id,
                    'title' => $post->title,
                    'body'  => $post->body
                ];
    
                $this->view('Posts/edit', $data);
            }
        }

        public function delete($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                 // Get existing post from model
                 $post = $this->postModel->getPostById($id);
                 // Check if current user is the owner of the post
                 if($post->user_id != $_SESSION['user_id']){
                     redirect('Posts');
                 }
                 
                if($this->postModel->deletePost($id)){
                    flash('post_message', 'Post deleted!');
                    redirect('Posts');
                }
                else{
                    die('Something went wrong!');
                }
            }
            else {
                redirect('Posts');
            }
        }
    }
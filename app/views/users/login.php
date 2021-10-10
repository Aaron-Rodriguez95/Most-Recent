<?php require APPROOT . '/views/inc/header.php';?>
<div class="row">
    <div class="col-mid-6 mx_auto">
        <div class="card card-body bg-light mt-5">
            <?php flash('register_success'); ?>
            <h2>Login</h2>
            <p>Please enter your credentials</p>
            <form action="<?php echo URLROOT; ?>/Users/login" method="post">
                <div class="form-group">
                    <label for="name">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_error']?></span>
                </div>
                <div class="form-group">
                    <label for="name">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['password_error']?></span>
                </div>
              
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Login" class="btn btn-success btn-block">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT; ?>/Users/register" class="btn btn-light btn-block">Don't have an account? Register here</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
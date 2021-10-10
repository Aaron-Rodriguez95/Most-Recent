<?php require APPROOT . '/views/inc/header.php';?>
    <a href="<?php echo URLROOT ; ?>/Posts" class="btn btn-light"><i class="fa fa-backward"></i> Go Back</a>
    <div class="card card-body bg-light mt-5">
        <h2>Edit Post</h2>
        <form action="<?php echo URLROOT; ?>/Posts/edit/<?= $data['id']; ?>" method="post">
            <div class="form-group">
                <label for="title">Title: <sup>*</sup></label>
                <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                <span class="invalid-feedback"><?php echo $data['title_error']?></span>
            </div>
            <div class="form-group mt-3">
                <label for="body">Body: <sup>*</sup></label>
                <textarea type="text" name="body" class="form-control form-control-lg <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['body']; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $data['body_error']?></span>
            </div>
            <input type="submit" class="btn btn-success mt-3" value="submit">
        </form>
    </div>
<?php require APPROOT . '/views/inc/footer.php';?>
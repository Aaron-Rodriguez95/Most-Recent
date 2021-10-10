<?php require APPROOT . '/views/inc/header.php';?>
    <a href="<?php echo URLROOT ; ?>/Posts" class="btn btn-light"><i class="fa fa-backward"></i> Go Back</a>
    <br>
    <h1><?= $data['post']->title?></h1>
    <div class="bg-secondary text-white p-2 mb-3">
        Written by <?= $data['user']->name; ?> on <?= $data['post']->created_at; ?>
    </div>
    <p><?= $data['post']->body; ?></p>

    <?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
        <hr>
        <a href="<?= URLROOT; ?>/Posts/edit/<?= $data['post']->id ; ?>" class="btn btn-dark">Edit</a>
       
       <form class="float-end" action="<?= URLROOT; ?>/Posts/delete/<?= $data['post']->id; ?>" method="post">
            <input type="submit" value="Delete" class="btn btn-danger">
       </form>

        <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php';?>
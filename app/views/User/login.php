<div class="col-md-6 offset-md-3 card card-body bg-light mt-3">
    <form class="form" action="" method="post">
        <div class="bg-danger">
            <?= $displayErrors ?>
        </div>
        <h3 class="text-center"><?= $this->__('name_page'); ?></h3>
        <div class="form-group">
            <label for="user_login"><?= $this->__('user_login'); ?></label>
            <input type="text" name="user_login" id="user_login" class="form-control">
        </div>
        <div class="form-group">
            <label for=user_password"><?= $this->__('user_password'); ?></label>
            <input type="password" name="user_password" id="user_password" class="form-control">
        </div>
        <div class="form-group">
            <label for="remember_me"><?= $this->__('remember_me'); ?><input type="checkbox" id="remember_me" name="remember_me" value="on"></label>
        </div>
        <div class="form-group">
            <input type="submit" value="<?= $this->__('button_log_in'); ?>" class="btn btn-large btn-primary">
        </div>
        <div class="text-right">
            <p><?= $this->__('text_befor_button_register'); ?><a href="register" class="text-primary"><?= $this->__('button_register'); ?></a></p>
        </div>
    </form>
</div>
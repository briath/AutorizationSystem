<div class="container">
    <div class="bg-light">
        <h3 class="text-center pt-4 pb-4"><?= $this->__('name_page'); ?></h3>
        <div class="container required d-inline"> - <?= $this->__('required'); ?></div>
        <hr>
        <form class="form needs-validation" action="" method="post" enctype="multipart/form-data" novalidate>
            <div class="container">
                <div class="bg-danger">
                    <?= $displayErrors ?>
                </div>
                <div class="required form-group">
                    <label for="user_login"><?= $this->__('user_login'); ?></label>
                    <input type="text" id="user_login" name="user_login" class="form-control" maxlength="40" value="<?=$posted_values['user_login'];?>" required>
                    <div class="invalid-feedback"><?= $this->__('valid_required'); ?></div>
                </div>
                <div class="required form-group">
                    <label for="email"><?= $this->__('email'); ?></label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= $posted_values['email'];?>" required>
                    <div class="invalid-feedback"><?= $this->__('valid_required'); ?></div>
                    <small id="passwordHelpInline" class="text-muted">
                        <?= $this->__('email_help'); ?>
                    </small>
                </div>
                <div class="required form-group">
                    <label for="user_password"><?= $this->__('user_password'); ?></label>
                    <input type="password" id="user_password" name="user_password" class="form-control" value="<?= $posted_values['user_password'];?>" required>
                    <div class="invalid-feedback"><?= $this->__('valid_required'); ?></div>
                    <small id="passwordHelpInline" class="text-muted">
                        <?= $this->__('password_help'); ?>
                    </small>
                </div>
                <div class="required form-group">
                    <label for="confirm"><?= $this->__('confirm'); ?></label>
                    <input type="password" id="confirm" name="confirm" class="form-control" value="<?= $posted_values['confirm'];?>" required>
                    <div class="invalid-feedback"><?= $this->__('valid_required'); ?></div>
                </div>
            </div>
            <hr><div class="text-center"><a class="collapsed" data-toggle="collapse" href="#collapseRegister" aria-expanded="true" aria-controls="collapseOne">

            </a></div>
            <div class="container">
                <div class="collapse" id="collapseRegister">
                    <div class="form-group row">
                        <label for="input_user_photo" class="col-2 col-form-label"></label>
                        <div class="col-10">
                            <img src="/images/80x80.png" id="preview" class="w-25 img-thumbnail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_photo" class="col-2 col-form-label"><?= $this->__('user_photo'); ?></label>
                        <div class="col-10">
                            <input type="file" name="img[]" class="file" accept="image/*">
                            <div class="input-group">
                                <input type="text" class="form-control" disabled placeholder="<?= $this->__('user_text_photo'); ?>" id="file">
                                <div class="input-group-append">
                                    <button type="button" class="browse btn btn-primary"><?= $this->__('browse'); ?>...</button>
                                </div>
                            </div>
                            <small id="passwordHelpInline" class="text-muted">
                                <?= $this->__('help_user_photo1'); ?>
                            </small><br>
                            <small id="passwordHelpInline" class="text-muted">
                                <?= $this->__('help_user_photo2'); ?>
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_name" class="col-2 col-form-label"><?= $this->__('user_name'); ?></label>
                        <div class="col-10">
                            <input type="text" id="user_name" name="user_name" class="form-control" value="<?=$posted_values['user_name'];?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_birthday"  class="col-2 col-form-label"><?= $this->__('user_birthday'); ?>:</label>
                        <div class="col-10">
                            <input class="form-control" type="date" id="user_birthday" name="user_birthday" value="<?=$posted_values['user_birthday'];?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="about_myself" class="col-2 col-form-label"><?= $this->__('about_myself'); ?></label>
                        <div class="col-10">
                            <textarea class="form-control" id="about_myself" name="about_myself" rows="3" ><?=$posted_values['about_myself'];?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <input type="submit" class="btn btn-primary btn-large" value="<?= $this->__('button_register'); ?>">
                </div>
            </div>
        </form>
    </div>
</div>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<link href="/css/main.css" rel="stylesheet">

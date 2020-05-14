<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login.try</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/css/main.css" rel="stylesheet">
</head>
<body>
    <header class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="/">Login.Try</a>

                <form class="form-inline my-2 my-lg-0 ml-auto">
                <?php if(!empty($_SESSION)): ?>
                    <div><a class="btn btn-outline-success my-2 my-sm-0 rounded-pill btn-sm mx-md-1" href="/user/logout"><?= $this->__('button_logout'); ?></a></div>
                <?php else: ?>
                    <div><a class="btn btn-outline-success my-2 my-sm-0 rounded-pill btn-sm mx-md-1" href="/user/login"><?=$this->__('button_login'); ?></a></div>
                    <div><a class="btn btn-outline-success my-2 my-sm-0 rounded-pill btn-sm mx-md-1" href="/user/register"><?=$this->__('main_button_register'); ?></a></div>
                <?php endif; ?>
                </form>
                <?php $languages->getHtml(); ?>
            </nav>
    </header>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <?= $content; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="/js/lang.js"></script>
    <script src="/js/register.js"></script>
</body>
</html>
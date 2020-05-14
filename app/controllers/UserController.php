<?php


namespace app\controllers;


use app\models\User_info;
use app\models\Users;
use vendor\core\Input;
use vendor\core\Lang;
use vendor\core\Router;
use vendor\core\Validate;

/*
 * Controller отвечающий за вход, выход и регистрацию пользователя.
 * Загружаем модель Users.
 */

class UserController extends AppController
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->load_model(Users::class);
    }

    /*
     * Вход пользователя.
     * Валидируем логин и пароль.
     * При успешной валидации, получаем данные пользователя из бд.
     * Проверяем правильность пароля.
     * Выполняем вход пользователя.
     * Ридерект на главную страницу.
     * Либо передаем view ошибки валидации.
     */
    public function loginAction($params = null){
        $valadation = new Validate();
        if($_POST){
            $valadation->check($_POST, [], [
                'user_login'        => [
                    'display'       => "User_login",
                    'required'      => true,
                    'min'           => 3,
                    'max'           => 40,
                ],
                'user_password'     => [
                    'display'       => 'User_password',
                    'required'      => true,
                    'min'           => 6,
                    'max'           => 40,
                ],
            ]);
            if($valadation->passed() === true){
                $user = $this->{Users::class.'Model'}->findByUsername($_POST['user_login']);
                if(!empty($user) && password_verify(Input::get('user_password'), $user['user_password'])){
                    $newUser = new Users(intval($user['id']));
                    $newUser->login();
                    Router::redirect('/');
                } else {
                    $valadation->addError(Lang::get('error'));
                }
            }
        }
        $displayErrors = $valadation->displayErrors();
        $this->set(compact(['displayErrors']));
    }

    /*
     * Выход пользователя.
     * Ридерект на главную страницу.
     */
    public function logoutAction(){
        if(Users::currentLoggedInUser()){
            Users::currentLoggedInUser()->logout();
        }

        Router::redirect('/');
    }

    /*
     * Регистрация нового пользователя.
     * Валидация данных.
     * Регистрация пользователя.
     * Вход пользователя.
     * Ридерект на главную страницу.
     * Либо передаем view ошибки валидации.
     */
    public function registerAction($params = null){
        $valadation = new Validate();
        $file = [];
        $posted_values = ['user_login'=>'', 'email'=>'', 'user_password'=>'', 'confirm'=>'', 'user_photo' => '', 'user_name' => '', 'user_birthday' => '', 'about_myself' => ''];
        if($_POST){
            $posted_values = $this->posted_values($_POST);
            if($_FILES['img']['name'][0]){
                $file['filename'] = $_FILES['img']['name'];
                $file['filesize'] = $_FILES['img']['size'];
                $file['filetype'] = $_FILES['img']['type'];
                $file['filedata'] = fread(fopen($_FILES['img']['tmp_name'][0], "r"),$file['filesize'][0]);
                $file['item'] = [
                    'display'       => Lang::get('img'),
                    'filesize'       => 2,
                    'filetype'       => ['jpg', 'jpeg', 'png', 'gif'],
                ];
            }
            $valadation->check($_POST, $file, [
                'user_login'=> [
                    'display'       => 'User_login',
                    'required'      => true,
                    'unique'        => 'users',
                    'min'           => 3,
                    'max'           => 40,
                ],
                'email'=>[
                    'display'       => Lang::get('email'),
                    'required'      => true,
                    'unique'        => 'users',
                    'max'           => 100,
                    'valid_email'   => true,
                ],
                'user_password'=> [
                    'display'       => 'User_password',
                    'required'      => true,
                    'min'           => 6,
                    'max'           => 40,
                ],
                'confirm'=> [
                    'display'       => Lang::get('confirm'),
                    'required'      => true,
                    'matches'       =>'user_password'
                ]
            ]);
            if($valadation->passed()){
                $newUser = new Users();
                $newUser->registerNewUser(array_merge($_POST, isset($file)? $file : []));
                if($file || $_POST['user_name'] || $_POST['user_birthday'] || $_POST['about_myself']){
                    $user_info = new User_info();
                    $user_info->registerNewuser(['user_id'  => $newUser->id,
                                                'full_name' => $_POST['user_name'],
                                                'birthday'  => $_POST['user_birthday'],
                                                'about'     => $_POST['about_myself'],
                                                'filename'  => $file['filename'][0],
                                                'filesize'  => $file['filesize'][0]]);
                }
                $newUser->login();
                Router::redirect('/');
            }
        }

        $displayErrors = $valadation->displayErrors();
        $this->set(compact(['posted_values', 'displayErrors']));
    }
}
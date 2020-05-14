<?php


namespace app\models;


use vendor\core\Cookie;
use vendor\core\Model;
use vendor\core\Session;

class Users extends Model
{
    private $_isLoggedIn, $_sessionName, $_cookieName;
    public static $currentLoggedInUser = null;
    public $table = 'users';

    public function __construct($user = '')
    {
        parent::__construct();
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;

        if($user != ''){
            if(is_int($user)){
                $u = $this->findFirst($user, 'id');
            } else {
                $u = $this->findFirst($user, 'user_login');
            }
            if($u){
                foreach ($u as $key => $value){
                    $this->$key = $value;
                }
            }
        }
    }

    /*
     * Поиск пользователя по username.
     */
    public function findByUsername($username){
        return $this->findFirst($username, 'user_login');
    }

    /*
     * Создаем пользователя, который сейчас авторизирован.
     */
    public static function currentLoggedInUser() {
        if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)){
            $U = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedInUser = $U;
        }
        return self::$currentLoggedInUser;
    }

    /*
     * Вход пользователя.
     */
    public function login(){
        Session::set($this->_sessionName, $this->id);
    }

    /*
     * Выход пользователя.
     * Удаляем сессию.
     */
    public function logout(){
        Session::delete(CURRENT_USER_SESSION_NAME);
        self::$currentLoggedInUser = null;
        return true;
    }

    /*
     * Регистрация нового пользователя.
     * var $params - данные пользователя.
     */
    public function registerNewUser($params)
    {
        $this->assign($params);
        $this->user_password = password_hash($this->user_password, PASSWORD_DEFAULT);
        $this->save();
        $u = $this->findFirst($this->user_login, 'user_login');
        $this->id = $u['id'];
    }
}
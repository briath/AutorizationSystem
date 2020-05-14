<?php


namespace app\models;


use vendor\core\Model;

/*
 * Регистрируем информацию об пользователе.
 */

class User_info extends Model
{
    public $table = 'user_info';

    /*
     * Добавили в таблицу user_info информацию об пользователи.
     * Файл храниться на сервере путь public/images/user_photo/ в папке с название id пользователя
     */
    public function registerNewUser($source){
        $this->insert($source);
        if($_FILES){
            mkdir(WWW . '/images/user_photo/' . $source['user_id']);
            copy($_FILES['img']['tmp_name'][0],WWW . '/images/user_photo/' . $source['user_id'] . '/' . $_FILES['img']['name'][0]);
        }
    }
}
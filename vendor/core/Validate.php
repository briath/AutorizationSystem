<?php


namespace vendor\core;


class Validate
{
    private $_passed=false, $_errors=[], $_db=null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $source_file = [], $items=[]){
        $this->_errors = [];

        if(isset($source_file['filename'])) $this->checkFile($source_file);

        foreach ($items as $item => $rules) {
            $item = Input::sanitize($item);
            $display = $this->displayName($rules['display']);
            foreach ($rules as $rule => $rule_value){
                $value = Input::sanitize(trim($source[$item]));

                if($rule === 'required' && empty($value)){
                    $this->addError([$display . Lang::get('error_required'), $item]);
                } elseif (!empty($value)){
                    switch ($rule) {
                        case  'min':
                            if(strlen($value) < $rule_value){
                                $this->addError([$display . Lang::get('error_min')[0] . $rule_value . Lang::get('error_min')[1], $item]);
                            }
                            break;

                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addError([$display . Lang::get('error_max')[0] . $rule_value . Lang::get('error_max')[1], $item]);
                            }
                            break;

                        case 'matches':
                            if($value != $source[$rule_value]){
                                $matchDisplay = $this->displayName($items[$rule_value]['display']);
                                $this->addError([Lang::get('error_matches')[0] . mb_strtolower($matchDisplay, 'UTF-8') . Lang::get('error_matches')[1] . mb_strtolower($display, 'UTF-8') . Lang::get('error_matches')[2], $item]);
                            }
                            break;

                        case 'unique':
                            $check = $this->_db->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?", [$value]);
                            if($this->_db->count()) {
                                $this->addError([$display . Lang::get('error_unique'), $item]);
                            }
                            break;

                        case 'unique_update':
                            $t = explode(',', $rule_value);
                            $table = $t[0];
                            $id = $t[1];
                            $query = $this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item} =?", [$id, $value]);
                            if($this->_db->count()) {
                                $this->addError([$display . Lang::get('error_unique_update'), $item]);
                            }
                            break;

                        case 'is_numeric':
                            if(!is_numeric($value)){
                                $this->addError(["{$display} has to be a number. Please use a numeric value.", $item]);
                            }
                            break;

                        case 'valid_email':
                            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                                $this->addError([$display . Lang::get('error_valid_email'), $item]);
                            }
                            break;

                        case 'valid_url':
                            if(!filter_var($value, FILTER_VALIDATE_URL)){
                                $this->addError(["{$display} must be a valid url.", $item]);
                            }
                            break;
                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed = true;
        }
        return $this;
    }

    private function checkFile($source){
        if($source['item']['filesize']*1024*1024 < $source['filesize'][0]){
            $this->addError([Lang::get('error_filesize')[0] . $source['item']['filesize'] . Lang::get('error_filesize')[1], 'user_photo']);
        }

        if(!in_array(explode('/', $source['filetype'][0])[1], $source['item']['filetype'])){
            $this->addError([Lang::get('error_filetype'), 'user_photo']);
        }
    }

    public function displayName($display){
        if($display === 'User_login'){
            return Lang::get('user_login');
        } elseif ($display === 'User_password') {
            return Lang::get('user_password');
        } else {
            return $display;
        }
    }

    public function addError($error){
        $this->_errors[] = $error;
        if(empty($this->_errors)){
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

    public function displayErrors() {
        $html = '<ul class="bg-danger">';
        foreach ($this->_errors as $error){
            if(is_array($error)) {
                $html .= '<li class="text-light">' . $error[0] . '</li>';
                $html .= '<script>$(document).ready(function() {$("#' . $error[1] . '").parent().closest("div").addClass("has-error");})</script>';
            } else {
                $html .= '<li class="text-light">'.$error.'</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}
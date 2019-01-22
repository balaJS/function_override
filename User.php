<?php

Class User extends Db{

    public function login() {

    }

    public function register() {

    }

    public function authentication() {

    }

    public function update_data() {

    }

    public function get_data($args = '') {
        #$this->args = $args;
        return $this->select('users', "where email='vvbala1995@gmail.com'", 'uname,email,create_at');
    }
}

?>
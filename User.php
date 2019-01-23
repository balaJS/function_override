<?php

Class User extends Generic {
    private $email;
    private $pwd;
    protected $result;
    public $error;
    public $session;
    
    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $this->email = 'vvbala1995@gmail.com';
        $this->pwd = 'fdfd';
        $this->result = $this->select('users', "where email='$this->email' && pwd='$this->pwd'", 'id,uname,email');

        if(!$this->result['status']) {
            $this->error = ['element'=> 'email element', 'error'=> 'Please check your credential'];
            $this->_error_handler($this->error);
        }
        $this->session['demo'] = $this->result;
        $this->_redirect(['url'=> 'success.php','query'=> 'success']);
        #return $this->session['demo'];
    }

    public function register() {

    }

    public function auth() {
        if(!isset($this->session['demo'])) {
            $this->_redirect(['url'=> 'register.php','query'=> 'register']);
        }
        return $this->session['demo']['status'];
    }

    public function update_data() {

    }

    public function get_data($args = '') {
        return $this->select('users', "where email='vvbala1995@gmail.com'", 'uname,email,create_at');
    }

}

?>
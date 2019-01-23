<?php

Class Generic extends Db {
	
	public function __construct() {
        parent::__construct();
    }

    public function _error_handler($args = false) {
        if($args) $this->error = $args;
        return $this->error['element'].$this->error['error'];
    }

    public function _redirect($args) {
        if(!isset($args['url'])) {
            return $this->_error_handler(['element'=>'redirect','error'=>'url missing']);
        }
        $url = $args['url'];
        $url .= isset($args['query']) ? '?'.$args['query'] : '';
        header("location: $url");
        exit;
    }
}

?>
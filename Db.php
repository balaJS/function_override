<?php

Class Db {
	protected $conn;

	public function __construct() {
		try {
			$this->conn = new PDO("mysql:host=localhost;dbname=svengine_core", 'root', '');
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}

	}

	protected function insert($table, $keys, $values) {
	    if(!$table || count($keys) !== count($values)) { return ['status'=>false,'data'=>null];}
	    global $conn;

	    $key_str = implode(',',$keys);
	    $data = array_combine($keys, $values);
	    $formatted_keys = implode(", :",$keys);

	    $sql = "insert into $table ($key_str) values(:$formatted_keys)";
	        # return $sql; # for debugging purpose
	    $pdo = $conn->prepare($sql)->execute($data);
	    $last_ins_id = $conn->lastInsertId();
	    return ['status'=> boolval($last_ins_id),'data'=> ['insert_id'=> $last_ins_id]];
	}

	protected function update($table, $keys, $values, $condition = false) {
	    if(!$table || count($keys) !== count($values) || !$condition) { return ['status'=>false,'data'=>null];}
	    global $conn;
	    $query = '';
	    
	    $data = array_combine($keys, $values);
	    $length = count($data);
		foreach($data as $key => $value) {
		    $query .= "$key = '$value'";
	        if( $length > 1) $query .= ", ";
	        --$length;
	    }

	    $sql = "update $table set $query $condition";
	    $pdo = $conn->prepare($sql);
	    $pdo->execute();
	    $rowCount = $pdo->rowCount();
	    return ['status'=> boolval($rowCount),'data'=> ['count'=> $rowCount]];
	}

	protected function select($table, $condition, $return_cols = '*', $matchval = false) {
	    if(!$table) { return ['status'=>false,'data'=>null]; }
	    global $conn;
	    $output = array();
	    $sql = "select $return_cols from $table $condition";
	    //$sql = mysqli_query($conn, $query);
	    $pdo = $this->conn->prepare($sql);
	    $pdo->execute();
	    while($data = $pdo->fetch(PDO::FETCH_ASSOC)) {
	        $output[] = $data;
	    }
	    $rowCount = $pdo->rowCount();

	    if($matchval || $matchval === 0) return check_unique($table, $condition, $return_cols = '*', $matchval);
	    
	    return ['status'=> boolval($rowCount), 'data'=> ['result'=> $output, 'count'=> $rowCount]];
	}

	protected function deleted($table, $condition, $type = 'delete') {
	    if(!$table) { return ['status'=>false,'data'=>null]; }
	    global $conn;
	    if($type === 'inactive') { return update($table, ['status'], [0], $condition);}

	    $sql = "delete from $table $condition";
	    $pdo = $conn->prepare($sql);
	    $pdo->execute();
	    $rowCount = $pdo->rowCount();
	    return ['status'=> boolval($rowCount),'data'=> ['count'=> $rowCount]];
	}
}

?>
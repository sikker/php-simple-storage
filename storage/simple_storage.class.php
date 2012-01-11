<?php

// very simple flat file storage system

class SimpleStorage {

	private $file = "storage.json";
	private $data = array("updated" => "", "checksum" => "", "data" => array("foo" => "bar"));
	private $dirty = FALSE;
	
	public function __construct() {
		// load data
		if ( file_exists($this->file) ) {
			$json = file_get_contents($this->file);
			if ( strlen($json) == 0 ) return;
			if ( ($this->data = json_decode($json,$assoc = TRUE)) === NULL ) throw new Exception("Unable to decode $this->file.");
			// verify data integrity
			if ( $this->data["checksum"] != md5($this->data["data"]) ) throw new Exception("Data from $this->file is not valid. Fails checksum.");
			// import data
			if ( ($this->data["data"] = json_decode($this->data["data"],$assoc = TRUE)) === NULL ) throw new Exception("Unable to unserialize data from $file.");	
		}
	}
	
	public function __destruct() {
		// flush data
		$this->flush();
	}
	
	public function flush() {
		// check if writeback is needed
		if ( $this->dirty == FALSE ) return TRUE;
		// prepare to writeback to file
		$data = $this->data;
		$data["updated"] = date("c");;
		$data["data"] = json_encode($this->data["data"]);
		$data["checksum"] = md5($data["data"]);
		// overwrite existing data
		if ( file_put_contents($this->file,json_encode($data)) ) return TRUE;
		else throw new Exception("Unable to write back to $this->file. Data will be lost.");
	}

	public function put($key,$value) {
		if ( is_string($key) ) {
			$this->data["data"][$key] = $value;
			$this->dirty = TRUE;
			return TRUE;
		} else return FALSE;
	}
	
	public function get($key) {
		if ( is_string($key) ) {
			if ( array_key_exists($key,$this->data["data"]) ) {
				return $this->data["data"][$key];
			}	
		}
		return FALSE;
	}

}

?>
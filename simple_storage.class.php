<?php

// very simple flat file storage system

class SimpleStorage {

	private $file = "/volume1/web/storage-test/php-simple-storage/storage.json";
	private $dirty = FALSE;
	private $domain = "default";
	private $data = array(
		"meta" => array(
			"updated" => "", 
			"checksum" => ""
		),
		"domains" => array(
			"default" => array(
				"foo" => "bar"
			)
		)
	);
	
	public function __construct($domain = NULL) {
		// load data
		if ( file_exists($this->file) ) {
			$json = file_get_contents($this->file);
			if ( strlen($json) == 0 ) return;
			if ( ($this->data = json_decode($json,$assoc = TRUE)) === NULL ) throw new Exception("Unable to decode $this->file.");
			// verify data integrity
			if ( $this->data["meta"]["checksum"] != md5($this->data["domains"]) ) throw new Exception("Data from $this->file is not valid. Fails checksum.");
			// import data
			if ( ($this->data["domains"] = json_decode($this->data["domains"],$assoc = TRUE)) === NULL ) throw new Exception("Unable to unserialize data from $file.");	
		}
		// setup domain
		if ( $domain ) {
			if ( $this->domain_exists($domain) == FALSE ) $this->domain_add($domain);
			$this->domain = $domain;
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
		$data["domains"] = json_encode($this->data["domains"]);
		$data["meta"]["updated"] = date("c");
		$data["meta"]["checksum"] = md5($data["domains"]);
		// overwrite existing data
		if ( file_put_contents($this->file,json_encode($data)) ) return TRUE;
		else throw new Exception("Unable to write back to $this->file. Data will be lost.");
	}

	// save data
	public function put($key,$data,$domain = NULL) {
		if ( $domain == NULL ) $domain = $this->domain;
		if ( is_string($key.$domain) AND $this->domain_exists($domain) ) {
			$this->data["domains"][$domain][$key] = $data;
			$this->dirty = TRUE;
			return TRUE;
		} 
		return FALSE;
	}
	
	// retrieve data
	public function get($key,$domain = NULL) {
		if ( $domain == NULL ) $domain = $this->domain;
		if ( is_string($key.$domain) AND $this->domain_exists($domain) ) {
			if ( array_key_exists($key,$this->data["domains"][$domain]) ) {
				return $this->data["domains"][$domain][$key];
			}	
		}
		return NULL;
	}
	
	// check if a domain exists
	public function domain_exists($domain) {
		return array_key_exists($domain,$this->data["domains"]);
	}
	
	// add a new domain
	public function domain_add($domain) {
		if ( $this->domain_exists($domain) ) return FALSE;
		$this->data["domains"][$domain] = array();
		$this->dirty = TRUE;
	}
	
	// remove an existing domain and all associated data
	public function domain_remove($domain) {
		if ( $this->domain_exists($domain) ) {
			unset($this->data["domains"][$domain]);
			$this->dirty = TRUE;
			return TRUE;
		}	
		return FALSE;
	}	

}

?>
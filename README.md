#Simple Key:Value Flat File Storage Class

This class provides an interface to a very simple key:value based storage system. All data is 
serialized and saved to a flat file. 

##FEATURES

- Provides a key:value storage system. Supports most PHP objects including multidimensional arrays.

##DEPENDENCIES

- Apache must have R+W access to the storage.php.serial file.

##USAGE

1. Move the storage folder into your web area.
2. Link the class into your existing project.
``````````````````````````
require_once "storage/simple_storage.class.php";
``````````````````````````
3. Create an instance of the class.
``````````````````````````
$storage = new SimpleStorage();
``````````````````````````
4. Put and get content as needed. Note that the storage key must be a string!.
::php
$book = array(														
		"title" => "A Day In The Life",									
		"author" => "John Smith",										
		"date" => date("c"),											
		"pages" => 428,												
		"contents" => array(
			"chapter1" => "One upon a time...",
			"chapter2" => "...a toad...",
			"chapter3" => "found a home in the forest.".
		)
	);
	$storage->put("book",$book);
	$stored_book = $storage->get("book");
	print_r($stored_book);

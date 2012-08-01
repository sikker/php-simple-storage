Simple Key:Value Flat File Storage Class
========================================

This class provides an interface to a very simple key:value based storage system. All data is 
stored in a flat file using JSON.

Features
--------

- Provides a key:value storage system. Supports most PHP objects including multidimensional arrays.
- Ability to divide data into domains.

Dependencies
------------

- Apache must have R+W access to the storage.json file.

Reference
---------

- 	SimpleStorage::__construct($your_default_domain = "default")

	Throws an ```exception()``` upon error.

- 	SimpleStorage::flush()

	Writes all stored data back to file. Throws an ```exception()``` on error.

- 	SimpleStorage::put($key,$data,$domain = "YOUR_DEFAULT_DOMAIN")

	Stores new data under your selected domain (must already be created) that can later be referenced by ```$key```.

- 	SimpleStorage::get($key,$domain = "YOUR_DEFAULT_DOMAIN")

	Retrieves data you have already stored within ```$domain```.
	
- 	SimpleStorage::domain_exists($domain)

	Check to see if a domain exists. Returns ```TRUE``` or ```FALSE```.
	
- 	SimpleStorage::domain_add($domain)

	Adds a new domain. Returns ```FALSE`` on error.

- 	SimpleStorage::domain_remove($domain)

	Remove an existing domain and delete all associated data. Returns ```FALSE``` on error.

Usage
-----

1. Move the storage folder into your web area.
2. Link the class into your existing project.

	```
	require_once "storage/simple_storage.class.php";
	```

3. Create an instance of the class.

	```
	$storage = new SimpleStorage();
	\\ or
	$storage = new SimpleStorage("YOUR_DOMAIN_NAME");
	```

4. Put and get content as needed. Note that the storage key must be a string!.

	```
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
	\\ or
	$storage->put("book",$book,"YOUR_DOMAIN_NAME");
	$stored_book = $storage->get("book","YOUR_DOMAIN_NAME");
	
	print_r($stored_book);
	```

Legal
-----

Copyright 2011 Matthew Colf mattcolf@mattcolf.com

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
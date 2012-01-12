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
	```
	
	or
	
	```
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
	```
	
	
	```
	$storage->put("book",$book);
	$stored_book = $storage->get("book");
	```
	
	or
	
	```
	$storage->put("book",$book,"YOUR_DOMAIN_NAME");
	$stored_book = $storage->get("book","YOUR_DOMAIN_NAME");
	```
	
	
	```
	print_r($stored_book);
	```

Legal
-----

Copyright (c) 2011, Matt Colf

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted, provided that the above
copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
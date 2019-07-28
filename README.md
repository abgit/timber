This library provides an API to send logging to timber.io services.

Install with Composer
------------
Add `abgit/timber` as a dependency and run composer update:

```
"require": {
    ...
    "abgit/timber" : "0.1.*"
    ...
}
```

Create a timber.io source
------------
Create a "HTTP API" source and find source credentials "Source ID" and "Api KEY".

Send messages to timber.io
------------

```php
<?php

// import dependencies
require 'vendor/autoload.php';

// get the timber class instance
$timber = new timber\log( YOUR_SOURCE_ID, YOUR_SOURCE_APIKEY );

// Add messages
$timber->warning( 'some warning message' )
       ->error( 'some error message' )
       ->info( 'some info message' )
       ->debug( 'some debug message' );

// Send messages to timber
$timber->send(); 
```

Add messages with custom meta tags
```php
// Add messages with custom tags
$timber->warning( 'some warning message', [ 'extrainfo' => 2 ] )
       ->error( 'some error message', [ 'otherinfo' => 4 ] )

// Send messages to timber
$timber->send(); 
```
Add messages with custom meta tags and custom date
```php
// Add messages with custom tags and custom unixtimestamp
$timber->error( 'some error message', [ 'extrainfo' => 2, 'otherinfo' => 4 ], time() - 86400 )

// Send messages to timber
$timber->send(); 
```

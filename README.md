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


```php
<?php

// import dependencies
require 'vendor/autoload.php';

// get the timber class instance
$timber = new timber\log( YOUR_SOURCE_ID, YOUR_SOURCE_APIKEY );

// Add messages
$timber->warning('another message', ['code' => 45 ] )
       ->error('another message', ['code' => 46 ] )
       ->info('another message', ['code' => 46 ] )
       ->debug('another message', ['code' => 46 ] );

// Send messages to timber
$timber->send(); 
```

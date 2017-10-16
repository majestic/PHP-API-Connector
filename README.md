PHP-API-Connector(for PHP 7+)
====================

Use the https://majestic.com connectors to access web data from one of the largest web indexes available. 
The Majestic® search engine is mainly used to instantly provide Flow Metrics® which evaluate the any page on the Internet in scores between 0 and 100.
 
For set up:
---------------
You will need PHP7 for this. Also you may need to configer your evirormental variables so that PHP is in your PATH.\
This is so that you can run the examples via the terminal e.g php somefile.php

To use the API call the flowing in your project
```
require_once 'majesticseo-external-rpc/APIService.php';
```
The code below is taken from GetIndexItemInfo.php, it is demonstrate how you may use it 
```
$api_service = new APIService($app_api_key, $endpoint);
$response = $api_service->executeCommand("GetIndexItemInfo", $parameters);
```

Examples
-------------
There are a few examples of the API-Connector as follows:

* GetIndexItemInfo.php 
  * The GetIndexItemInfo command provides data on the number of backlinks to any web page or site, linking domains and the main topics for that page or web site
* GetBackLinkData.php 
  * GetBacklinkData will return rows of data with information about all the pages linking to a given URL or domain
  
Further notes  
------------------

For further information see api documentation @ https://developer-support.majestic.com/


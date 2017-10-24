PHP-API-Connector (for PHP 7+)
====================

Use the https://majestic.com connectors to access web data from one of the largest web indexes available. 
The Majestic® search engine is mainly used to instantly provide Flow Metrics® which evaluate the any page on the Internet in scores between 0 and 100.
 
For set up
---------------
You will need PHP7 for this API-Connector. Also you may need to configure your Environment variables so that PHP is in your PATH.\

To use the API call the following in your project:
```
require_once 'majesticseo-external-rpc/APIService.php';
```
Examples
-------------
There are a few examples of using the API-Connector in the following scripts:

* GetIndexItemInfo.php 
  * The GetIndexItemInfo command provides data on the number of backlinks to any web page or site, linking domains and the main topics for that page or web site
* GetBackLinkData.php 
  * GetBacklinkData will return rows of data with information about all the pages linking to a given URL or domain
  
You can run the examples via the terminal like this ```>php GetIndexItemInfo.php```   
  
Further notes  
------------------
The API returns data in UTF-8 format this may have issues with printing non unicode characters when using version of PHP earlier than 7.


For further information see api documentation @ https://developer-support.majestic.com/


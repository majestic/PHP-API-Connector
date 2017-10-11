PHP-API-Connector
=================

This is the Connector code for using Majestic API in PHP. 

There are examples of use in the majesticseo_external_rpc directory feel free to use it.
>Note: GetIndexItemInfo.php,GetTopBackLinks.php and OpenAppGetIndexItemInfo.php are examples of the Connector.\
>Also you may need to configer your evirormental variables so that PHP is in your PATH.\
>This is so that you can run the examples via the terminal e.g php somefile.php

An example of use may look like the following:


```
require_once 'majesticseo-external-rpc/APIService.php';

$api_service = new APIService($app_api_key, $endpoint);
$response = $api_service->executeCommand("GetIndexItemInfo", $parameters);

```

For more information see  api documentation @ https://developer-support.majestic.com/

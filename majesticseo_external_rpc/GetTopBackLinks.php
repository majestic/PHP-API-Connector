<?php

/*
 * Copyright 2015, Majestic-12 Ltd trading as Majestic
 * https://majestic.com
 * 
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 * 
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 * 
 *     * Neither the name of Majestic-12 Ltd, its trademarks, nor any contributors
 *       to the software may be used to endorse or promote products derived from
 *       this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL Majestic-12 Ltd BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

// NOTE: The code below is specifically for the GetTopBackLinks API command.
//       For other API commands, the arguments required may differ.
//       Please refer to the Majestic SEO Developer Wiki for more information
//       regarding other API commands and their arguments.

require_once 'majesticseo-external-rpc/APIService.php';


$endpoint = "http://enterprise.majesticseo.com/api_command";

fwrite(STDOUT, "\n***********************************************************" .
    "*****************");

fwrite(STDOUT, "\n\nEndpoint: $endpoint");

if("http://enterprise.majesticseo.com/api_command" == $endpoint) {
    fwrite(STDOUT, "\n\nThis program is hard-wired to the Enterprise API.");
    fwrite(STDOUT, "\n\nIf you do not have access to the Enterprise API, " .
        "change the endpoint to: \nhttp://developer.majesticseo.com/api_command.");
} else {
    fwrite(STDOUT, "\n\nThis program is hard-wired to the Developer API " .
        "and hence the subset of data \nreturned will be substantially " .
        "smaller than that which will be returned from \neither the " .
        "Enterprise API or the Majestic SEO website.");

    fwrite(STDOUT, "\n\nTo make this program use the Enterprise API, change " .
        "the endpoint to: \nhttp://enterprise.majesticseo.com/api_command.");
}

fwrite(STDOUT, "\n\n***********************************************************" .
    "*****************");

fwrite(STDOUT, "\n\n\nThis example program will return key information about \"index items\"." .
        "\n\nThe following must be provided in order to run this program: " .
        "\n1. API key \n2. List of items to query" .
        "\n\nPlease enter your API key:\n");

$app_api_key = fgets(STDIN);

fwrite(STDOUT, "\nPlease enter a URL, domain or subdomain to query:\n");

$itemToQuery = fgets(STDIN);

$parameters = array();
$parameters["MaxSourceURLs"] = 10;
$parameters["URL"] = $itemToQuery;
$parameters["GetUrlData"] = 1;
$parameters["MaxSourceURLsPerRefDomain"] = 1;
$parameters["datasource"] = "fresh";

$api_service = new APIService($app_api_key, $endpoint);
$response = $api_service->executeCommand("GetTopBackLinks", $parameters);

if($response->isOK() == "true") {
    $results = $response->getTableForName("URL");
    foreach($results->getTableRows() as $row) {
        fwrite(STDOUT, "\nURL: ".$row['SourceURL']);
        fwrite(STDOUT, "\nACRank: ".$row['ACRank']."\n");
    }

    if("http://developer.majesticseo.com/api_command" == $endpoint) {
        fwrite(STDOUT, "\n\n***********************************************************" .
            "*****************");

        fwrite(STDOUT, "\n\nEndpoint: " . $endpoint);

        fwrite(STDOUT, "\n\nThis program is hard-wired to the Developer API " .
            "and hence the subset of data \nreturned will be substantially " .
            "smaller than that which will be returned from \neither the " .
            "Enterprise API or the Majestic SEO website.");

        fwrite(STDOUT, "\n\nTo make this program use the Enterprise API, change " .
            "the endpoint to: \nhttp://enterprise.majesticseo.com/api_command.");

        fwrite(STDOUT, "\n\n***********************************************************" .
            "*****************\n");
    }
} else {
    fwrite(STDOUT, "\nERROR MESSAGE:");
    fwrite(STDOUT, "\n" . $response->getErrorMessage());

    fwrite(STDOUT, "\n\n\n***********************************************************" .
        "*****************");

    fwrite(STDOUT, "\n\nDebugging Info:");
    fwrite(STDOUT, "\n\n  Endpoint: \t" . $endpoint);
    fwrite(STDOUT, "\n  API Key: \t" . $app_api_key);

    if("http://enterprise.majesticseo.com/api_command" == $endpoint) {
        fwrite(STDOUT, "\n  Is this API Key valid for this Endpoint?");

        fwrite(STDOUT, "\n\n  This program is hard-wired to the Enterprise API.");

        fwrite(STDOUT, "\n\n  If you do not have access to the Enterprise API, " .
            "change the endpoint to: \n  http://developer.majesticseo.com/api_command.\n");
    }

    fwrite(STDOUT, "\n***********************************************************" .
        "*****************\n");
}

?>

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

require_once dirname(__FILE__).'/Response.php';

class APIService
{
    protected $application_id, $endpoint;

    public function __construct($application_id, $endpoint)
    {
	    $this->application_id = $application_id;
        $this->endpoint = $endpoint;
    }

	// JL executes an api command.
    final public function executeCommand($command_name, $parameters, $timeout = 5)
    {
        $parameters["app_api_key"] = $this->application_id;
        $parameters["cmd"] = $command_name;
        
        return $this->executeRequest($parameters, $timeout);
    }
    
    // JL executes an OpenApp request.
    final public function executeOpenAppRequest($command_name, $parameters, $access_token, $timeout = 5)
    {
        $parameters["accesstoken"] = $access_token;
        $parameters["cmd"] = $command_name;
        $parameters["privatekey"] = $this->application_id;
        
        return $this->executeRequest($parameters, $timeout);
    }
    
    private function executeRequest($parameters, $timeout)
    {
        $query_string = http_build_query($parameters);
        $xml_data = $this->endpoint."?".$query_string;

        return new Response($xml_data, $timeout);
    }
}

?>

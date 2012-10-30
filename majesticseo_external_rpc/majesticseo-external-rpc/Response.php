<?php

/*
 * Version 0.9.3
 *
 * Copyright (c) 2011, Majestic-12 Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *   1. Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *   2. Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the
 *      documentation and/or other materials provided with the distribution.
 *   3. Neither the name of the Majestic-12 Ltd nor the
 *      names of its contributors may be used to endorse or promote products
 *      derived from this software without specific prior written permission.
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

require_once '/DataTable.php';

class Response {

    protected $responseAttributes;
    protected $params;
    protected $tables;

    # Constructs a new instance of the Response class
    public function __construct($xml_data = NULL, $timeout = 5) {
        $this->responseAttributes = array();
        $this->params = array();
        $this->tables = array();

        if ($xml_data != NULL) {
            $this->importData($xml_data, $timeout);
        }
    }

    # Failed response constructor
    public function constructFailedResponse($code = NULL, $errorMessage = NULL) {
        $this->responseAttributes = array();
        $this->params = array();
        $this->tables = array();
        
        if ($code != NULL && $errorMessage != NULL) {
            $this->responseAttributes["Code"] = $code;
            $this->responseAttributes["ErrorMessage"] = $errorMessage;
            $this->responseAttributes["FullError"] = $errorMessage;
        }
    }

    # Parses the response xml, storing the result internally
    private function importData($xml_data, $timeout) {
        $reader = new XMLReader();
        $reader->open($xml_data, "UTF-8");
        $dataTable = null;

        $start = time();
        $end = $start + $timeout;

        while ($reader->read()) {
            if(time() <= $end) {
                if($reader->nodeType == XMLREADER::ELEMENT) {
                    switch ($reader->name) {
                       case "Result":
                           $this->responseAttributes["Code"] = $reader->getAttribute("Code");
                           $this->responseAttributes["ErrorMessage"] = $reader->getAttribute("ErrorMessage");
                           $this->responseAttributes["FullError"] = $reader->getAttribute("FullError");
                           break;

                       case "GlobalVars":
                           if($reader->hasAttributes) {
                               while($reader->moveToNextAttribute()) {
                                   $this->params[$reader->name] = $reader->value;
                               }
                           }
                           break;

                       case "DataTable":
                           $dataTable = new DataTable();
                           $dataTable->setTableName($reader->getAttribute("Name"));
                           $dataTable->setTableHeaders($reader->getAttribute("Headers"));

                           while($reader->moveToNextAttribute()) {
                               if ("Name" != $reader->name && "Headers" != $reader->name) {
                                   $dataTable->setTableParams($reader->name, $reader->value);
                               }
                           }

                           $this->tables[$dataTable->getTableName()] = $dataTable;
                           break;

                       case "Row":
                           $row = $reader->readString();
                           $dataTable->setTableRow($row);
                           break;
                    }
                }
            } else {
                $this->constructFailedResponse("ConnectionError", "Problem connecting to data source");
            }
        }
    }

    # Returns the response's attributes
    public function getResponseAttributes() {
        return $this->responseAttributes;
    }

    # Indicates whether the response is OK
    public function isOK() {
        if ("OK" == $this->responseAttributes["Code"]) {
            return "true";
        }

        return "false";
    }

    # Returns the response's code - "OK" represents predicted state, all else represents an error
    public function getCode() {
        return $this->responseAttributes["Code"];
    }

    # Returns the response's error message if any
    public function getErrorMessage() {
        return $this->responseAttributes["ErrorMessage"];
    }

    # Returns the response's full error message if any
    public function getFullError() {
        return $this->responseAttributes["FullError"];
    }

    # Returns the response global parameters
    public function getGlobalParams() {
        return $this->params;
    }

    # Returns a specific parameter from the global parameters
    public function getParamForName($name) {
        if (!array_key_exists($name, $this->params)) {
            return NULL;
        }

        return $this->params[$name];
    }

    # Returns the response's data tables
    public function getTables() {
        return $this->tables;
    }

    # Returns a specific data table from the response's data tables
    public function getTableForName($name) {
        if (!array_key_exists($name, $this->tables)) {
            return new DataTable();
        }

        return $this->tables[$name];
    }

}

?>

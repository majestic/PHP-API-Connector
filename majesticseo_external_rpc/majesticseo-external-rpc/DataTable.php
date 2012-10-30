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

class DataTable {

    protected $tableName;
    protected $tableHeaders;
    protected $tableParams;
    protected $tableRows;

    # Constructs a new instance of the DataTable class.
    public function __construct() {
        $this->tableName = "";
        $this->tableHeaders = array();
        $this->tableParams = array();
        $this->tableRows = array();
    }

    # Set table's name
    public function setTableName($name) {
        $this->tableName = $name;
    }

    # Set table's headers
    public function setTableHeaders($headers) {
        $this->tableHeaders = $this->split($headers);
    }

    # Set table's parameters
    public function setTableParams($name, $value) {
        $this->tableParams[$name] = $value;
    }

    # Set table's rows
    public function setTableRow($row) {
        $rowsHash = array();
        $elements = $this->split($row);
        for ($i = 0; $i < count($elements); $i++) {
            if ($elements[$i] == " ") {
                $elements[$i] = "";
            }

            $rowsHash[$this->tableHeaders[$i]] = $elements[$i];
        }

        array_push($this->tableRows, $rowsHash);
    }

    # Splits the input from pipe separated form into an array.
    private function split($value) {
        $array = preg_split("/(?<!\|)\|(?!\|)/", $value, -1);

        for ($i = 0; $i < count($array); $i++) {
            $array[$i] = str_replace("||", "|", $array[$i]);
        }

        return $array;
    }

    # Returns the table's name
    public function getTableName() {
        return $this->tableName;
    }

    # Returns the table's headers
    public function getTableHeaders() {
        return $this->tableHeaders;
    }

    # Returns the table's parameters
    public function getParams() {
        return $this->tableParams;
    }

    # Returns a specific parameter from the table's parameters
    public function getParamForName($name) {
        if (!array_key_exists($name, $this->tableParams)) {
            return NULL;
        }

        return $this->tableParams[$name];
    }

    # Returns the number of rows in the table
    public function getRowCount() {
        return count($this->tableRows);
    }

    # Returns the table's rows
    public function getTableRows() {
        return $this->tableRows;
    }

}

?>

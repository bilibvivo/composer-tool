<?php
namespace Dtool;

use SQLite3 as SQLite3Alias;

class SqliteDb extends SQLite3Alias
{
    public function __construct($filename)
    {
        $this->open($filename);
    }
}
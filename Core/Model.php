<?php

namespace Core;

abstract class Model
{
    protected $db;

    public function __construct()
    {
        global $_DB;
        $this->db = $_DB;
    }
}
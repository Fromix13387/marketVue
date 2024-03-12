<?php

class User
{
    private Db $db;
    public function __construct($db)
    {
        $this->db = $db;
    }



    public function registration($data)
    {
        return "good";
    }
}
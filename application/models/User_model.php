<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    
    private $table = 'users';

    public function get_by_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->where('status', 1)
            ->get($this->table)
            ->row();
    }

    
}
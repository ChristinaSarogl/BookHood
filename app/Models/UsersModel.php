<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
	protected $table = 'users';
    
    protected $allowedFields = ['username','email','password',
		'profilePic','created_at'];
	
	public function getLastIndex()
	{
		return $this->countAll();
	}
	
	public function getUser($id)
	{
		return $this->where(['id' => $id])->first();
	}
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ToReadModel extends Model
{
	protected $table = 'want_to_read';
	
	protected $allowedFields = ['book_id', 'user_id'];
	
	public function getList($userID)
	{
		return $this->where(['user_id' => $userID])->findAll();
	}
	
	public function deleteBook($bookId)
	{
		$this->where(['book_id' => $bookId])->delete();
	}
	
}
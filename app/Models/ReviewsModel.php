<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewsModel extends Model
{
    protected $table = 'reviews';
	
	protected $allowedFields = ['title','review','rating','created_at','book_id','user_id'];
	
	public function getReviews($bookId)
	{
		return $this->where(['book_id' => $bookId])->orderBy('created_at', 'DESC')->findAll();
	}
	
	public function getUserReviews($userID)
	{
		return $this->where(['user_id' => $userID])->findAll();
	}
	
	public function getRecent($amount)
	{
		return $this->orderBy('created_at', 'DESC')->findAll($amount);
	}
	
	public function getReview($userId,$bookId)
	{
		return $this->where(['user_id' => $userId, 'book_id' => $bookId])->first();
	}
	
	public function deleteBook($bookId)
	{
		$this->where(['book_id' => $bookId])->delete();
	}
}
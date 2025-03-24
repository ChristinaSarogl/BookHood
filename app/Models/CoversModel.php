<?php

namespace App\Models;

use CodeIgniter\Model;

class CoversModel extends Model
{
    protected $table = 'book_covers';
	
	protected $allowedFields = ['file_name', 'file_type','category'];
	
	public function getLastIndex()
	{
		return $this->orderBy('id', 'DESC')->first();
	}
	
	public function getCover($id)
	{
		return $this->where(['id' => $id])->first();
	}
	
	public function getRecent($amount, $category = false)
	{
		if ($category === false) {
			return $this->orderBy('id', 'DESC')->findAll($amount);
		}
		return $this->where(['category' => $category])->orderBy('id', 'DESC')->findAll($amount);
	}
	
	public function getCategory($category)
	{
		return $this->where(['category' => $category])->orderBy('id', 'DESC')->findAll();
	}
	
	public function getSimilar($id, $category)
	{
		$booksInCategory = $this->where(['category' => $category])->findAll();
		if ($id == end($booksInCategory)['id']){
			return $this->where(['category' => $category,'id <' => $id])->orderBy('id', 'DESC')->findAll(6);
		} else {
			$similarBooks = $this->where(['category' => $category,'id >' => $id])->orderBy('id', 'DESC')->findAll(6);
			if(count($similarBooks) < 6){
				$remaining = 6-count($similarBooks);
				$restSimilar = $this->where(['category' => $category,'id <' => $id])->orderBy('id', 'DESC')->findAll($remaining);
				foreach ($restSimilar as $book){
					array_push($similarBooks,$book);
				}
				return $similarBooks;
			} else {
				return $similarBooks;
			}				
		}
	}
	
}
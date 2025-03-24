<?php

namespace App\Models;

use CodeIgniter\Model;

class BooksModel extends Model
{
    protected $table = 'books';
	
	protected $allowedFields = ['title', 'author', 'summary',
		'publisher','release_date','slug', 'isbn', 'cover','category', 'added_by'];
	
	public function getBook($id)
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
	
	public function getAddedByUser($userId)
	{
		return $this->where(['added_by' => $userId])->orderBy('title', 'ASC')->findAll();
	}
	
	public function sortCategoryByName($category)
	{
		return $this->where(['category' => $category])->orderBy('title', 'ASC')->findAll();
	}
	
	public function searchTitle($input)
	{
		return $this->like('title',$input)->findAll();
	}
	
	public function searchAuthor($input)
	{
		return $this->like('author',$input)->findAll();
	}
	
	public function searchPublisher($input)
	{
		return $this->like('publisher',$input)->findAll();
	}
	
	
	
}
<?php

namespace App\Controllers;

class Book extends BaseController
{
	public function addBook()
	{		
		$modelBooks = model(BooksModel::class);
		$modelCover = model(CoversModel::class);
		
		if ($this->request->getMethod() === 'post' && $this->validate([
			'title' => 'required|min_length[2]',
			'author' => 'required',
			'summary' => 'required',
			'publisher' => 'required|min_length[3]',
			'release' => 'required|valid_date',
			'isbn' => 'required|is_unique[books.isbn]',
			'category' => 'required',
			'bookCover' => 'uploaded[bookCover]',
		])){					
			$coverImage = $this->request->getFile('bookCover');	
			$coverImage->move(ROOTPATH.'public/covers');
			
			$modelCover->save([
				'file_name' => $coverImage->getName(),
				'file_type' => $coverImage->getClientMimeType(),
				'category' => $this->request->getPost('category')
			]);
			
			$cover_id = $modelCover->getLastIndex();
			
			$modelBooks->save([
				'title' => $this->request->getPost('title'),
				'author' => $this->request->getPost('author'),
				'summary' => $this->request->getPost('summary'),
				'publisher' => $this->request->getPost('publisher'),
				'release_date' => $this->request->getPost('release'),
				'isbn' => $this->request->getPost('isbn'),
				'slug'  => url_title($this->request->getPost('title'), '-', true),
				'cover' => $cover_id['id'],
				'category' => $this->request->getPost('category'),
				'added_by' => session()->get('id'),
			]);
			
			return redirect()->to('/home');
		} else {
			echo view('templates/header');
			echo view('book/addBook');
			echo view('templates/footer');
		}	
	}
	
	public function view($id,$slug)
	{
		$modelBooks = model(BooksModel::class);
		$modelCovers = model(CoversModel::class);
		$modelReviews = model(ReviewsModel::class);
		$modelUsers = model(UsersModel::class);
		
		$data['book'] = $modelBooks->getBook($id);	
		$url = "https://openlibrary.org/isbn/"
			.$data['book']['isbn']
			.".json";
		$json_data = file_get_contents($url);
		$data['info'] = json_decode($json_data);
		
		$data['cover'] = $modelCovers->getCover($data['book']['cover']);
		
		$reviews = $modelReviews->getReviews($id);
		if (!empty($reviews)){
			$data['reviews'] = $reviews;
			$totalRat = 0;
			$users = array();
			$index = 0;
			foreach($reviews as $review){
				$user = $modelUsers->getUser($review['user_id']);
				$users[$index] = $user;
				$totalRat = $totalRat + $review['rating'];
				$index++;
			}
			$data['users'] = $users;
			$data['rating'] = ($totalRat/count($reviews));			
		} else {
			$data['reviews'] = array();
			$data['users'] = array();
			$data['rating'] = "none";
		}
		
		$data['similarBooks'] = $modelBooks->getSimilar($id,$data['book']['category']);
		$data['similarCovers'] = $modelCovers->getSimilar($id,$data['book']['category']);
		
		echo view('templates/header');
		echo view('book/bookInfo', $data);
		echo view('templates/footer');
	}
	
	
	public function postReview($bookId)
	{
		$modelReviews = model(ReviewsModel::class);
		$modelBooks = model(BooksModel::class);
		$session = session();
		
		if ($this->request->getMethod() === 'post' && $this->validate([
			'title' => 'required|max_length[255]',
			'review' => 'required',			
		])){
			$modelReviews->save([
				'title' => $this->request->getPost('title'),
				'review' => $this->request->getPost('review'),
				'rating' => $this->request->getPost('userRating'),
				'created_at' => date('y-m-d'),				
				'book_id' => $bookId,
				'user_id' => $session->get('id'),
			]);
			
			$book = $modelBooks->getBook($bookId);
			return redirect()->to('/book/'.$bookId.'/'.$book['slug']);
			
		} 
	}
	
	public function updateReview($bookId)
	{
		$modelReviews = model(ReviewsModel::class);
		$modelBooks = model(BooksModel::class);
		$session = session();
		
		$review = $modelReviews->getReview($session->get('id'),$bookId);
		
		if ($this->request->getMethod() === 'post' && $this->validate([
			'title' => 'required|max_length[255]',
			'review' => 'required',			
		])){
			$data = [	
				'title' => $this->request->getPost('title'),
				'review' => $this->request->getPost('review'),
				'rating' => $this->request->getPost('userRating')
			];
			
			$modelReviews->update($review['id'],$data);
			
			$book = $modelBooks->getBook($bookId);
			return redirect()->to('/book/'.$bookId.'/'.$book['slug']);
		}
	}
	
	public function deleteBook($bookId)
	{		
		$modelToRead = model(ToReadModel::class);
		$modelReading = model(ReadingModel::class);
		$modelComplete = model(CompleteModel::class);
		$modelReviews = model(ReviewsModel::class);
		$modelBooks = model(BooksModel::class);
		$modelCover = model(CoversModel::class);
		
		$book = $modelBooks->getBook($bookId);
		$cover = $modelCover->getCover($book['cover']);
		
		$modelToRead->deleteBook($bookId);
		$modelReading->deleteBook($bookId);
		$modelComplete->deleteBook($bookId);
		$modelReviews->deleteBook($bookId);
		
		unlink(ROOTPATH.'public/covers/'.$cover['file_name']);		
		$modelCover->where('id', $cover['id'])->delete();
		
		return redirect()->to('/profile/'.session()->get('id'));
	}
	
}
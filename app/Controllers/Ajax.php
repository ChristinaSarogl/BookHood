<?php

namespace App\Controllers;

use App\Models\NewsModel;

class Ajax extends BaseController
{
	public function getLists($category,$userID)
	{
		if ($category == 4){
			$modelReviews = model(ReviewsModel::class);
			$modelBooks = model(BooksModel::class);
			
			$reviews = $modelReviews->getUserReviews($userID);
			
			if(empty($reviews)){
				$passdata['result'] = 'none';
			} else {
				$passdata = array();
				$index = 0;
				foreach($reviews as $review){
					$bookInfo = $modelBooks->getBook($review['book_id']);
					$passdata[$index] = [
						'created_at' => $review['created_at'],
						'review' => $review['review'],
						'title' => $review['title'],
						'book_id' => $review['book_id'],
						'book_title' => $bookInfo['title'],
						'book_slug' => $bookInfo['slug'],
					];
					$index++;
				}
			}
			
		} else if ($category == 5) {
			$modelBook = model(BooksModel::class);
			$modelCover = model(CoversModel::class);
			
			$addedBooks = $modelBook->getAddedByUser($userID);
			if(!empty($addedBooks)){
				$index = 0;
				foreach($addedBooks as $bookEntry){
					$book = $modelBook->getBook($bookEntry['id']);
					$cover = $modelCover->getCover($book['cover']);
					$passdata[$index] = [
						'book_id' => $book['id'],
						'book_slug' => $book['slug'],
						'book_title' => $book['title'],
						'book_cover' => $cover['file_name'],
					];
					$index++;
				}	
			} else {
				$passdata['result'] = 'none';
			}
			
		} else {
			if ($category == 1){
				$model = model(ToReadModel::class);
			} elseif ($category == 2){
				$model = model(ReadingModel::class);
			} elseif ($category == 3){
				$model = model(CompleteModel::class);
			}
			
			$modelBook = model(BooksModel::class);
			$modelCover = model(CoversModel::class);
			
			$books = $model->getList($userID);
			if (empty($books)){
				$passdata['result'] = 'none';
			} else {	
				$index = 0;
				foreach($books as $bookEntry){
					$book = $modelBook->getBook($bookEntry['book_id']);
					$cover = $modelCover->getCover($book['cover']);
					$passdata[$index] = [
						'book_id' => $book['id'],
						'book_slug' => $book['slug'],
						'book_title' => $book['title'],
						'book_cover' => $cover['file_name'],
					];
					$index++;
				}	
			}
		}

		print(json_encode($passdata));
	}
	
	public function updateList($bookId,$list,$userId)
	{		
		if($list == 1){
			$modelRead = model(ToReadModel::class);
			$books = $modelRead->getList($userId);
			
			$inList = false;
			foreach($books as $book){
				if ($book['book_id'] === $bookId){
					$inList = true;
					break;
				}
			}
				
			if (empty($books) || !$inList){
				$modelRead->save([
					'book_id' => $bookId,
					'user_id' => $userId,
				]);
				
				$passdata['action'] = 1;					
			} else {
				$passdata['action'] = 0;
				$modelRead->where(['book_id' => $bookId])->delete();			
			}	
			
			$passdata['list'] = 'Want to Read';	
			
		} elseif ($list == 2){
			$modelReading  = model(ReadingModel::class);
			$books = $modelReading->getList($userId);
			
			$inList = false;
			foreach($books as $book){
				if ($book['book_id'] === $bookId){
					$inList = true;
					break;
				}
			}
				
			if (empty($books) || !$inList){
				$modelReading->save([
					'book_id' => $bookId,
					'user_id' => $userId,
				]);
				
				$passdata['action'] = 1;		
			} else {
				$passdata['action'] = 0;
				$modelReading->where(['book_id' => $bookId])->delete();			
			}
			
			$passdata['list'] = 'Reading';
			
		} elseif ($list == 3){
			$modelComplete  = model(CompleteModel::class);
			$books = $modelComplete->getList($userId);
			
			$inList = false;
			foreach($books as $book){
				if ($book['book_id'] === $bookId){
					$inList = true;
					break;
				}
			}
				
			if (empty($books) || !$inList){
				$modelComplete->save([
					'book_id' => $bookId,
					'user_id' => $userId,
				]);
				
				$passdata['action'] = 1;		
			} else {
				$passdata['action'] = 0;
				$modelComplete->where(['book_id' => $bookId])->delete();			
			}
			
			$passdata['list'] = 'Completed';
		}
		
		print(json_encode($passdata));	
	}
	
	public function getBookInLists($userId,$bookId)
	{
		$modelRead = model(ToReadModel::class);
		$modelReading = model(ReadingModel::class);
		$modelComplete = model(CompleteModel::class);
		
		$passdata['nolist'] = true;
		
		$wants = $modelRead->getList($userId);		
		foreach($wants as $book){
			if ($book['book_id'] === $bookId){
				$passdata['want'] = true;
				$passdata['nolist'] = false;
				break;
			}
		}		
		
		$reading = $modelReading->getList($userId);
		foreach($reading as $book){
			if ($book['book_id'] === $bookId){
				$passdata['reading'] = true;
				$passdata['nolist'] = false;
				break;
			}
		}		
		
		$completes = $modelComplete->getList($userId);
		foreach($completes as $book){
			if ($book['book_id'] === $bookId){
				$passdata['complete'] = true;
				$passdata['nolist'] = false;
				break;
			}
		}
		
		
		print(json_encode($passdata));
	}
	
	public function sortCategory($sortBy, $category){
		$modelBooks = model(BooksModel::class);
		$modelCovers = model(CoversModel::class);
		$modelReviews = model(ReviewsModel::class);
		
		if ($sortBy == 2) {
			$data['books'] = $modelBooks->sortCategoryByName($category);
			
			$covers= array();
			foreach($data['books'] as $book){
				$cover = $modelCovers->getCover($book['cover']);
				array_push($covers,$cover);
			}
			$data['covers'] = $covers;
			
		} else {
			$data['books'] = $modelBooks->getCategory($category);
			$data['covers'] = $modelCovers->getCategory($category);
		}
		
		$ratings = array();
		$index = 0; 
		foreach($data['books'] as $book){
			$reviews = $modelReviews->getReviews($book['id']);
			if (!empty($reviews)){
				$bookRating = 0;
				foreach($reviews as $review){
					$bookRating = $bookRating + $review['rating'];
				}
				$ratings[$index]['rating'] = ($bookRating/count($reviews));
			} else{
				$ratings[$index]['rating'] = 0;
			}	
			$ratings[$index]['book'] = $book['id'];
			$index++;			
		}
		$data['ratings'] = $ratings;
		
		print(json_encode($data));
		
	}
}
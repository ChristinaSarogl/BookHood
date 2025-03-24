<?php

namespace App\Controllers;

class User extends BaseController
{
	public function profile($id)
    {
		$modelUsers = model(UsersModel::class);
		$modelReviews = model(ReviewsModel::class);
		$modelBooks = model(BooksModel::class);
		
		$user = $modelUsers->getUser($id);
		$reviews = $modelReviews->getUserReviews($id);
		$data = [
			'username' => $user['username'],
			'email' => $user['email'],
			'joined' => $user['created_at'],
			'profileImage' => $user['profilePic'],
		];
		
		if(!empty($reviews)){
			$data['reviewCount'] = count($reviews);
		} else{
			$data['reviewCount'] = 0;
		}
		
		$addedBooks = $modelBooks->getAddedByUser($id);
		if(!empty($addedBooks)){
			$data['addedBooks'] = count($addedBooks);
		} else {
			$data['addedBooks'] = 0;
		}
		
        echo view('templates/header');
		echo view('user/profile',$data);
		echo view('templates/footer');
    }
	
	public function update($id)
	{
		$modelUsers = model(UsersModel::class);
		$user = $modelUsers->getUser($id);
		
		if($this->request->getMethod() === 'post' && $this->validate([
			'username' => 'required|max_length[80]',
			'email' => 'required|valid_email',
		])){
			$profile = $this->request->getFile('profile');
			if(!$_FILES['profile']['size'] == 0){
				$profile->move(ROOTPATH.'public/profilePics');
				$data['profilePic'] = $profile->getName();
			}
			
			$username = $this->request->getPost('username');
			if($username !== $user['username']){
				$data['username'] = trim($username);
			}
			
			$email = $this->request->getPost('email');
			if($email !== $user['email']){
				$data['email'] = trim($email);
			}
			
			if (count($data) != 0){
				$modelUsers->update($id, $data);
				return redirect()->to('/profile/'.$id);
			} 
			
		} else {			
			$data = [
				'username' => $user['username'],
				'email' => $user['email'],
			];
			echo view('templates/header');
			echo view('user/editProfile',$data);
			echo view('templates/footer');
		}
	}
}
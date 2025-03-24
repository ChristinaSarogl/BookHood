<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function login()
    {
		$modelUsers = model(UsersModel::class);
		$session = session();
		
		if ($this->request->getMethod() === 'post' && $this->validate([
			'email' => 'required|valid_email',
			'password' => 'required|max_length[100]'
		])){
			$email = $this->request->getVar('email');
			$password = $this->request->getVar('password');
			
			$info = $modelUsers->where(['email' => $email])->first();
			if($info){
				if(password_verify($password,$info['password'])){
					$ses_data = [ 'id' => $info['id'],'isLoggedIn' => TRUE ];
					$session->set($ses_data);
					return redirect()->to('/profile/'.$info['id']);
				} else {
					$session->setFlashdata('msg', 'Password is incorrect.');
					return redirect()->to('/login'); 
				}
				
			} else {
				$session->setFlashdata('msg', 'Email does not exist.');
				return redirect()->to('/login'); 
			} 
				
		} else {
			echo view('templates/header');
			echo view('login/login');
			echo view('templates/footer');
		}
    }
	
	public function logout()
	{
		$session = session();
        $session->destroy();
		return redirect()->to('/login');
	}
	
	public function register()
    {
		$modelUsers = model(UsersModel::class);
		$session = session();
		
		if ($this->request->getMethod() === 'post' && $this->validate([
			'username' => 'required|max_length[80]|is_unique[users.username]',
			'email' => 'required|valid_email|is_unique[users.email]',
			'password' => 'required|max_length[100]',
			'repeat' => 'required|matches[password]'
		])){
			$modelUsers->save([
				'username' => $this->request->getPost('username'),
				'email' => $this->request->getPost('email'),
				'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
				'created_at' => date('y-m-d'),
			]);
			
			$id = $modelUsers->getLastIndex();
			
			$ses_data = [ 'id' => $id, 'isLoggedIn' => TRUE ];
			$session->set($ses_data);
			
			return redirect()->to('/home');
		} else {
			echo view('templates/header');
			echo view('login/register');
			echo view('templates/footer');
		}
    }
}
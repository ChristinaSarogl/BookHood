<?php

namespace App\Controllers;

class Location extends BaseController
{
	public function view()
    {
		echo view('templates/header');
		echo view('location/bookstore');
		echo view('templates/footer');
	}
}
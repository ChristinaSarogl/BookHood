<?php

namespace App\Controllers;

class AjaxSearch extends BaseController
{
	function fetch($input)
	{
		$modelBooks = model(BooksModel::class);
		$results['books'] = $modelBooks->searchTitle($input);
		
		$dataAuthors = $modelBooks->searchAuthor($input);
		$authors = array();		
		foreach($dataAuthors as $author){
			array_push($authors,$author['author']);
		}
		$results['authors'] = (array_values(array_unique($authors)));
		
		$dataPublishers = $modelBooks->searchPublisher($input);
		$publishers = array();		
		foreach($dataPublishers as $publisher){
			array_push($publishers,$publisher['publisher']);
		}
		$results['publishers'] = (array_values(array_unique($publishers)));
		
		print(json_encode($results));
	}
 
}
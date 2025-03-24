<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"> 
	
	<!-- Font Awesome Icon Library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="<?php echo base_url('css/main.css'); ?>">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	<script>
		$(document).ready(function() {
			var typingTimer;               
			var doneTypingInterval = 500;  
			
			$("#searchBox").keyup(function () {				
				clearTimeout(typingTimer);
				if ($('#searchBox').val()) {
					typingTimer = setTimeout(doneTyping,doneTypingInterval,'searchBox','searchResults');
				} else {
					resultsDiv.hide();
				}
			});
			
			$("#searchBoxMob").keyup(function () {				
				clearTimeout(typingTimer);
				if ($('#searchBoxMob').val()) {
					typingTimer = setTimeout(doneTyping,doneTypingInterval,'searchBoxMob','searchResultsMob');
				} else {
					resultsDiv.hide();
				}
			});

			function doneTyping(searchId,resultsContainer) {
				//Clear space
				resultsDiv = document.getElementById(resultsContainer);
				while (resultsDiv.firstChild) {
					resultsDiv.removeChild(resultsDiv.lastChild);
				}
				resultsDiv =$('#' + resultsContainer);
				searchValue = document.getElementById(searchId).value;				
				fetch('https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/search/' + searchValue)
					.then(response => response.json())
					.then(response => {						
						resultBooks = document.createElement('p');
						resultBooks.setAttribute('class','my-2 px-3 bg-secondary text-white fst-italic');
						resultBooks.innerHTML = "Books";
						resultsDiv.append(resultBooks);
						if(response['books'].length > 5){
							for(let i=0; i < 5; i++){
								resultLink = document.createElement('a');
								resultLink.setAttribute('class','link-dark');
								resultLink.setAttribute('href',"<?php echo base_url() ?>/book/" + response['books'][i].id + "/" + response['books'][i].slug);
								
								title = document.createElement('p');
								title.setAttribute('class','px-3 mb-2');
								title.innerHTML = response['books'][i].title;
								
								resultLink.append(title);
								resultsDiv.append(resultLink);
							}
							
							moreLink = document.createElement('a');
							moreLink.setAttribute('href','<?php echo base_url()?>/search=' + searchValue + '/opt=1');
							moreLink.setAttribute('class','d-flex justify-content-end me-3');
							moreLink.innerHTML = '[show all]';
							
							resultsDiv.append(moreLink);
						} else {
							response['books'].forEach(function(result,index){
								resultLink = document.createElement('a');
								resultLink.setAttribute('class','link-dark');
								resultLink.setAttribute('href',"<?php echo base_url() ?>/book/" + result.id + "/" + result.slug);
								
								title = document.createElement('p');
								title.setAttribute('class','px-3 mb-2');
								title.innerHTML = result.title;
								
								resultLink.append(title);
								resultsDiv.append(resultLink);
							});	
						}
						
						resultAuthors = document.createElement('p');
						resultAuthors.setAttribute('class','my-2 px-3 bg-secondary text-white fst-italic');
						resultAuthors.innerHTML = "Authors";
						resultsDiv.append(resultAuthors);				
						if(response['authors'].length > 5){
							for(let i=0; i < 5; i++){
								resultLink = document.createElement('a');
								resultLink.setAttribute('class','link-dark');
								
								author = document.createElement('p');
								author.setAttribute('class','px-3 mb-2');
								author.innerHTML = response['authors'][i];
								
								resultLink.append(author);
								resultsDiv.append(resultLink);
							}
							moreLink = document.createElement('a');
							moreLink.setAttribute('href','<?php echo base_url()?>/search=' + searchValue + '/opt=2');
							moreLink.setAttribute('class','d-flex justify-content-end me-3');
							moreLink.innerHTML = '[show all]';
							
							resultsDiv.append(moreLink);
						} else {
							response['authors'].forEach(function(result,index){
								resultLink = document.createElement('a');
								resultLink.setAttribute('class','link-dark');
								
								author = document.createElement('p');
								author.setAttribute('class','px-3 mb-2');
								author.innerHTML = result;
								
								resultLink.append(author);
								resultsDiv.append(resultLink);
							});	
						}
						
						resultPublishers = document.createElement('p');
						resultPublishers.setAttribute('class','my-2 px-3 bg-secondary text-white fst-italic');
						resultPublishers.innerHTML = "Publishers";
						resultsDiv.append(resultPublishers);
						if(response['publishers'].length > 5){
							for(let i=0; i < 5; i++){
								resultLink = document.createElement('a');
								resultLink.setAttribute('class','link-dark');
								
								publisher = document.createElement('p');
								publisher.setAttribute('class','px-3 mb-2');
								publisher.innerHTML = response['publishers'][i];
								
								resultLink.append(publisher);
								resultsDiv.append(resultLink);
							}
							moreLink = document.createElement('a');
							moreLink.setAttribute('href','<?php echo base_url()?>/search=' + searchValue + '/opt=3');
							moreLink.setAttribute('class','d-flex justify-content-end me-3');
							moreLink.innerHTML = '[show all]';
							
							resultsDiv.append(moreLink);
						} else {
							response['publishers'].forEach(function(result,index){
								resultLink = document.createElement('a');
								resultLink.setAttribute('class','link-dark');
								
								publisher = document.createElement('p');
								publisher.setAttribute('class','px-3 mb-2');
								publisher.innerHTML = result;
								
								resultLink.append(publisher);
								resultsDiv.append(resultLink);
							});	
						}
						
						resultsDiv.show();
					})
					.catch(err => {
						console.log(err);
					});	
			}
			
			$(document).click(function() {
				var results = $("#searchResults");
				var resultsMob = $("#searchResultsMob");
				
				if (!results.is(event.target) && !results.has(event.target).length) {
					results.hide();
				}
				
				if (document.activeElement.tagName === "INPUT") {
					searchValue = document.getElementById('searchBox').value;
					searchValueMob = document.getElementById('searchBoxMob').value;
					if(searchValue != ""){
						results.show();
					}
					if(searchValueMob != ""){
						resultsMob.show();
					}						
					
					
				}
			});
			
		});		
	</script>
	
    <title>BookHood</title>
  </head>
  
  <body>
    <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark px-1">
      <div class="container-fluid d-flex">
        <a class="navbar-brand" href="<?php echo base_url() ?>/home">BookHood</a>
		
		<div class="nav-item pe-1 ms-auto">
			<button type="button" class="btn btn-outline-light d-block d-md-none" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-search"></i></button>
		</div>
		<?php if(!session()->get('isLoggedIn')): ?>
			<div class="nav-item pe-1">
				<a href="<?php echo base_url() ?>/login" class="btn btn-outline-secondary d-block d-md-none"><i class="bi bi-box-arrow-in-right"></i></i></a>
			</div>
		<?php else: ?>
			<div class="nav-item pe-1">
				<a href="<?php echo base_url() ?>/profile/<?php echo session()->get('id') ?>" class="btn btn-outline-secondary d-block d-md-none"><i class="bi bi-person-circle"></i></i></a>
			</div>
		<?php endif ?>
		
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
		
        <div class="collapse navbar-collapse" id="navbarContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="<?php echo base_url() ?>/home">Home</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="broswe" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Categories
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
					<ul class="list-group list-group-horizontal"></ul>                            
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Adventure">Adventure</a></li>
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Crime-Mystery">Crime & Mystery</a></li>
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Fantasy">Fantasy</a></li>
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Historical">Historical Fiction</a></li>
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Horror-Thriller">Horror & Thriller</a></li>
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Lgbtq">LGBTQ+</a></li>                            
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Romance">Romance</a></li>
						<li><a class="dropdown-item" href="<?php echo base_url() ?>/browse/Sci-fi">Science Fiction</a></li>
					</ul>
				</li> 
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="<?php echo base_url() ?>/find-bookstore">Find Bookstore</a>
				</li>
				<?php if(!session()->get('isLoggedIn')): ?>
					<li class="nav-item d-none d-md-flex">
						<a class="nav-link" aria-current="page" href="<?php echo base_url() ?>/login">Login</a>
					</li>
				<?php else: ?>
					<li class="nav-item d-none d-md-flex">
						<a class="nav-link" aria-current="page" href="<?php echo base_url() ?>/profile/<?php echo session()->get('id') ?>">Profile</a>
					</li>
				<?php endif ?>
			</ul>
			<form action="<?php echo base_url()?>/search" method="post" class="d-none d-md-flex">
				<?= csrf_field() ?>
				<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="searchBox" id="searchBox">				
				<button class="btn btn-outline-light" type="submit">Search</button>
			</form>
			<div class="container-fluid w-25 me-5 p-0 border border-secondary bg-white" id="searchResults"></div>
        </div>
      </div>
    </nav>
	
	<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="searchBoxMob" id="searchBoxMob">
					<div class="container-fluid p-0 border border-secondary bg-white" id="searchResultsMob"></div>
				</div>
			</div>
		</div>
	</div>
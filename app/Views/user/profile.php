<div class="container pb-3" style="background: #ebebeb;">
	<p class="display-6 pt-3 text-center">Profile</p>
	<hr>
	<div class="d-flex flex-column flex-md-row align-items-center mt-3">
		<?php if($profileImage == NULL): ?>
			<img class="rounded-circle p-2" src="<?=base_url('profilePics')?>/default_profile.jpg" width="180px" height="180px">
		<?php else: ?>
			<img class="rounded-circle p-2" src="<?=base_url('profilePics')?>/<?php print_r($profileImage)?>" width="180px" height="180px">
		<?php endif ?>
		<div class="d-flex flex-grow-1">
			<table class="table table-sm mx-3">
				<tbody>
					<tr>
						<th>Username:</th>
						<td><?= esc($username) ?></td>
					</tr>
					<tr>
						<th>Email:</th>
						<td><?= esc($email) ?></td>
					</tr>
					<tr>
						<th>Joined:</th>
						<td><?= esc($joined) ?></td>
					</tr>
					<tr>
						<th>Reviews:</th>
						<td><?= esc($reviewCount) ?></td>
					</tr>
					<tr>
						<th>Added books:</th>
						<td><?= esc($addedBooks) ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="d-flex flex-row flex-md-column">
			<a class="btn btn-outline-secondary m-2" href="<?php echo base_url() ?>/update/<?php echo session()->get('id') ?>"><i class="bi bi-pencil-square"></i> Edit profile</a>
			<a class="btn btn-outline-success m-2" href="<?php echo base_url() ?>/add_book"><i class="bi bi-plus-square"></i> Add book</a>
			<a class="btn btn-outline-danger m-2" href="<?php echo base_url() ?>/logout"><i class="bi bi-box-arrow-right"></i> Disconnect</a>
		</div>            
	</div>      
	
	<div class="d-none d-md-inline">
		<ul class="nav nav-tabs mx-5 mt-4">
			<li class="nav-item">
			  <button class="nav-link active" id="prof-want-link" onclick="setActive(1)">Want to Read</button>
			</li>
			<li class="nav-item">
				<button class="nav-link link-dark" id="prof-read-link" onclick="setActive(2)">Reading</button>
			</li>
			<li class="nav-item">
				<button class="nav-link link-dark" id="prof-complete-link" onclick="setActive(3)">Completed</button>
			</li>
			<li class="nav-item">
				<button class="nav-link link-dark" id="prof-reviews-link" onclick="setActive(4)">My Reviews</button>
			</li>
			<li class="nav-item">
				<button class="nav-link link-dark" id="prof-added-link" onclick="setActive(5)">Added Books</button>
			</li>
		</ul>
	</div>
	
	<!-- Mobile -->
	<div class="d-md-none bg-white mt-2 mx-1">
		<select class="form-select" id="mobileSelect">
			<option value="1" selected>Want to Read</option>
			<option value="2">Reading</option>
			<option value="3">Completed</option>
			<option value="4">My Reviews</option>
			<option value="5">Added Books</option>
		</select> 
	</div>
	
	<div class="mx-md-5 mx-1 pt-2 bg-white">  
		<div class="row mx-md-2 mx-1" id='ajax-lists'></div>
		<div class="accordion accordion-flush" id="ajax-reviews"></div>
	</div>
	
</div>

<!-- Delete modal --->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Book</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p id="modal-book-info"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a class="btn btn-danger" id="modal-delete-book">Delete book</a>
			</div>
		</div>
	</div>
</div>

<script>
	function getReviews(userId){
		var resultDiv = document.getElementById('ajax-reviews');
		if(resultDiv != null){
			// Fetch data
			fetch('https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/getlists/4/' + userId)
			.then(response => response.json())
			.then(response => {		
				if (response.result == undefined){
					response.forEach(function(review,index){
						item = document.createElement('div');
						item.setAttribute('class','accordion-item');
						
						header = document.createElement('h2');
						header.setAttribute('class','accordion-header');
						header.setAttribute('id','header-' + review.book_slug);
						
						headerBtn = document.createElement('button');
						headerBtn.setAttribute('class','accordion-button collapsed');
						headerBtn.setAttribute('type','button');
						headerBtn.setAttribute('data-bs-toggle','collapse');
						headerBtn.setAttribute('data-bs-target','#info-' + review.book_slug);
						headerBtn.setAttribute('aria-expanded','false');
						headerBtn.setAttribute('aria-controls','info-' + review.book_slug);
						
						btnTitleDiv = document.createElement('div');
						btnTitleDiv.setAttribute('class','d-flex justify-content-between w-100 me-3');
						
						title = document.createElement('p');
						title.setAttribute('class','m-0');
						title.innerHTML = review.book_title;
						
						date = document.createElement('p');
						date.setAttribute('class','m-0 text-small text-secondary');
						date.innerHTML = review.created_at;
						
						infoDiv = document.createElement('div');
						infoDiv.setAttribute('id','info-' + review.book_slug);
						infoDiv.setAttribute('class','accordion-collapse collapse');
						infoDiv.setAttribute('aria-labelledby','header-' + review.book_slug);
						infoDiv.setAttribute('data-bs-parent','#ajax-results-true');
						
						
						infoBody = document.createElement('div');
						infoBody.setAttribute('class','accordion-body py-2');
						
						reviewTitle = document.createElement('p');
						reviewTitle.setAttribute('class','fw-bold');
						reviewTitle.innerHTML = review.title;
						
						reviewBody = document.createElement('p');
						reviewBody.innerHTML = review.review;
						
						
						buttonDiv = document.createElement('div');
						buttonDiv.setAttribute('class','d-flex flex-row justify-content-end');
						
						linkBook = document.createElement('a');
						linkBook.setAttribute('class','btn btn-outline-info me-2 mb-1');
						linkBook.setAttribute('href','<?php echo base_url() ?>/book/' + review.book_id + '/' + review.book_slug);
						linkBook.innerHTML = "Go to book";
						
						deleteButton = document.createElement('p');
						deleteButton.setAttribute('class','btn btn-outline-danger mb-1');
						deleteButton.innerHTML = '<i class="bi bi-trash3"></i>';
						
						btnTitleDiv.append(title);
						btnTitleDiv.append(date);
						headerBtn.append(btnTitleDiv);
						header.append(headerBtn);
						
						infoBody.append(reviewTitle);
						infoBody.append(reviewBody);
						buttonDiv.append(linkBook);
						buttonDiv.append(deleteButton);		
						infoBody.append(buttonDiv);
						infoDiv.append(infoBody);
						
						item.append(header);
						item.append(infoDiv);
						resultDiv.append(item);
					});	
					
					resultDiv.setAttribute('id','ajax-reviews-true');
				} else {
					listsDiv = document.getElementById('ajax-lists');
					
					message = document.createElement('p');
					message.setAttribute('class','ms-2 mb-2');
					message.innerHTML = "You  haven't written any reviews yet.";
					
					listsDiv.append(message);
				}
			})
			.catch(err => {
				// Display errors in console
				console.log(err);
			});
		}
	}
	
	function getList(list,userId){
		var resultDiv = document.getElementById('ajax-lists');
		
		fetch('https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/getlists/' + list + '/' + userId)
		.then(response => response.json())
		.then(response => {			
			if(response.result == undefined){	
				response.forEach(function(book,index) {			
					bookDiv = document.createElement('a');
					bookDiv.setAttribute('class','col-6 col-sm-4 col-lg-2 py-2 px-1 text-center');
					bookDiv.setAttribute('href','<?php echo base_url() ?>/book/' + book.book_id + '/' + book.book_slug);
					bookFigure = document.createElement('figure');
					bookFigure.setAttribute('class','figure pb-2 mb-1 h-100 d-flex flex-column align-items-center');
					
					cover = document.createElement('img');
					cover.setAttribute('class','align-middle h-auto cover border-0 img-fluid');
					cover.setAttribute('src',"<?=base_url('covers')?>/" + book.book_cover);
					cover.setAttribute('width','140px');
					
					caption = document.createElement('figcaption');
					caption.setAttribute('class','figure-caption');
					caption.innerHTML = book.book_title;
					
					bookFigure.append(cover);
					bookFigure.append(caption);
					bookDiv.append(bookFigure);
					resultDiv.append(bookDiv);
				});
			} else {
				message = document.createElement('p');
				message.setAttribute('class','ms-2 mb-2');
				message.innerHTML = "You  haven't added any books yet.";
				
				resultDiv.append(message);
			}
		})
		.catch(err => {
			console.log(err);
		});
	}
	
	function getAddedBooks(userId) {
		var resultDiv = document.getElementById('ajax-lists');
		
		fetch('https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/getlists/5/' + userId)
		.then(response => response.json())
		.then(response => {			
			if(response.result == undefined){
				response.forEach(function(book,index) {			
					bookDiv = document.createElement('div');
					bookDiv.setAttribute('class','col-6 col-sm-4 col-lg-2 py-2 px-1 text-center');
					bookFigure = document.createElement('figure');
					bookFigure.setAttribute('class','figure pb-2 mb-1 h-100 d-flex flex-column align-items-center');
					
					bookLink = document.createElement('a');
					bookLink.setAttribute('href','<?php echo base_url() ?>/book/' + book.book_id + '/' + book.book_slug);
					
					cover = document.createElement('img');
					cover.setAttribute('class','align-middle h-auto cover border-0 img-fluid');
					cover.setAttribute('src',"<?=base_url('covers')?>/" + book.book_cover);
					cover.setAttribute('width','140px');
					
					caption = document.createElement('figcaption');
					caption.setAttribute('class','figure-caption');
					caption.innerHTML = book.book_title;
					
					deleteButton = document.createElement('button');
					deleteButton.setAttribute('class','btn btn-outline-danger w-100 mt-auto');
					deleteButton.setAttribute('data-bs-toggle','modal');
					deleteButton.setAttribute('data-bs-target','#deleteModal');
					deleteButton.setAttribute('onclick','setModalDeleteButton(' + book.book_id + ',"' + book.book_title + '")');
					deleteButton.innerHTML = '<i class="bi bi-trash3-fill"></i> Delete';
					
					bookLink.append(cover);
					bookLink.append(caption);
					bookFigure.append(bookLink);
					bookFigure.append(deleteButton);
					bookDiv.append(bookFigure);					
					resultDiv.append(bookDiv);
				});	
			} else {
				message = document.createElement('p');
				message.setAttribute('class','ms-2 mb-2');
				message.innerHTML = "You  haven't added any books yet.";
				
				resultDiv.append(message);
			}
		})
		.catch(err => {
			console.log(err);
		});
	}
	
	function setModalDeleteButton(bookId, title){
		deleteButton = document.getElementById('modal-delete-book');
		link = '<?php echo base_url() ?>/delete-book/' + bookId;
		deleteButton.setAttribute('href', link);
		
		bookInfo = document.getElementById('modal-book-info');
		bookInfo.innerHTML = "Are you sure you want to delete <strong>" + title + "</strong> ?";
	}
	
	function setActive(category){
		//Clear space
		listsDiv = document.getElementById("ajax-lists");
		while (listsDiv.firstChild) {
			listsDiv.removeChild(listsDiv.lastChild);
		}
		
		revDiv = document.getElementById("ajax-reviews-true");
		if(revDiv != null){
			while (revDiv.firstChild) {
				revDiv.removeChild(revDiv.lastChild);
			}
			revDiv.setAttribute('id','ajax-reviews');
		}
		
		
		prevActiveLink = document.getElementsByClassName('nav-link active');
		
		for(let i = 0; i <= prevActiveLink.length-1; i++){
			prevActiveLink[i].setAttribute('class', 'nav-link link-dark');
		}
		
		if(category == 4){			
			document.getElementById('prof-reviews-link').setAttribute('class','nav-link active');
			getReviews(<?php echo session()->get('id') ?>);
			
		} else if(category == 1){			
			document.getElementById('prof-want-link').setAttribute('class','nav-link active');
			getList(category,<?php echo session()->get('id') ?>);
		} else if (category == 2){
			document.getElementById('prof-read-link').setAttribute('class','nav-link active');
			getList(category,<?php echo session()->get('id') ?>);
		} else if (category == 3){
			document.getElementById('prof-complete-link').setAttribute('class','nav-link active');
			getList(category,<?php echo session()->get('id') ?>);
		} else if (category == 5) {
			document.getElementById('prof-added-link').setAttribute('class','nav-link active');
			getAddedBooks(<?php echo session()->get('id') ?>);
		}			
	}
	
	document.getElementById("mobileSelect").onchange = changeListener;  
	function changeListener(){
		setActive(this.value);
	}
	
	$(document).ready(function() {
		setActive(1);
	});

</script>
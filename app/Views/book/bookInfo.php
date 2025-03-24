<div class="container" style="background: #ebebeb;">
	<div class="row">
		<div class="col-12 col-md-4 col-lg-3 order-1 order-sm-1">
			<div class="d-flex flex-column align-items-center mt-3">
				<img src="<?=base_url('covers')?>/<?php print_r($cover['file_name'])?>" class="img-fluid" width="220px">
				
				<div class="text-center mt-3">
					<?php if ($rating !== "none"): ?>
						<?php $floorNum = floor($rating); ?>
						<?php for ($x = 0; $x < $floorNum; $x++): ?>
							<i class="fa fa-star checked text-warning" style="font-size:25px"></i>
						<?php endfor; ?>	
						<?php for ($x = 0; $x < (5-$floorNum); $x++): ?>
							<i class="fa fa-star-o checked text-secondary" style="font-size:25px"></i>
						<?php endfor; ?>
						<p class="mt-2"><?= esc($rating) ?> stars based on <?php echo count($reviews) ?> reviews.</p>
					<?php else: ?>
						<?php for ($x = 0; $x < 5; $x++): ?>
							<i class="fa fa-star-o checked text-secondary" style="font-size:25px"></i>
						<?php endfor; ?>
						<p class="mt-2">0 stars based on 0 reviews.</p>
					<?php endif; ?>
				</div>
			</div>              
		</div>
		
		<div class="col-12 col-md-8 col-lg-9 order-2 order-sm-2">
			<div id="book-info-cont"></div>
			
			<div class="d-flex flex-row justify-content-between align-items-center">
				<div class="d-flex flex-row align-items-end">
					<p class="mb-0 me-1 fs-1"><?= esc($book['title']) ?></p>
					<p class="mb-1 ms-1 fs-4 fw-light">by <?= esc($book['author']) ?></p>
				</div>

				<?php if(session()->get('isLoggedIn')): ?>
					<button class="btn btn-outline-dark dropdown-toggle" type="button" id="listMenuButton"
						data-bs-toggle="dropdown" aria-expanded="false">Add to List </button>
					<div class="dropdown-menu" aria-labelledby="listMenuButton">
						<form class="mx-2 mt-1">
							<?= csrf_field() ?>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="to-read" value="1">
								<label class="form-check-label">Want to Read</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="reading" value="2">
								<label class="form-check-label">Reading</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="complete" value="3">
								<label class="form-check-label">Completed</label>
							</div>
						</form>
						<hr class="dropdown-divider">
						<a class="dropdown-item"
							href="<?php echo base_url() ?>/profile/<?= esc(session()->get('id')) ?>"><i class="bi bi-eye me-1"></i>View lists</a>
					</div>					
				<?php endif ?>
				
			</div>

			<p class="text-uppercase fst-italic mt-3 mb-2" >Summary</p>
			<p style="white-space: pre-line"><?= esc($book['summary']) ?></p>
			
			<hr>
			<div class="row">
				<div class="col-12 col-sm-6 order-1">
					<p class="mb-1">Publisher: <?= esc($book['publisher']) ?></p>
					<p class="mb-1">Release Date: <?= esc($book['release_date']) ?></p>
					<?php if(property_exists($info, 'number_of_pages')): ?>
						<p>Pages: <?php print_r($info->number_of_pages) ?></p>
					<?php else : ?>
						<p>Pages: Not defined </p>
					<?php endif ?>
				</div>
				<div class="col-12 col-sm-6 order-2">
					<p class="mb-1">ISBN: <?= esc($book['isbn']) ?></p>
					<a class="mb-1 link-dark"
						href="<?php echo base_url() ?>/browse/<?= esc($book['category'], 'url') ?>">
						Category: <?= esc($book['category']) ?>
					</a>
				</div>
			</div>
			
		</div>
	</div>
	
	<hr>

	<div class="row">
		<div class="col-12 col-md-8 col-lg-9 order-3 order-sm-3">
			<div class="d-flex flex-row justify-content-between align-items-center">
				<p class="fs-3 fw-light">Reviews</p>
				<?php if(session()->get('isLoggedIn')): ?>
					<button class="btn btn-dark h-75" id="info-review" onclick="addReview()">Add review</button>
				<?php endif ?>
			</div>
			
			<div id="add-review">
				<div class="card mb-2" id='card-form' style="display:none">
					<div class="card-body">
						<form action="<?php echo base_url()?>/save-review/<?= esc($book['id']) ?>" method="post" id="save-review">
							<?= csrf_field() ?>
							<div class="mb-1">	
								<div class="d-flex flex-row align-items-center mb-3">
									<p class="mb-2 me-3">Rating</p>	
									<select class="form-select" name="userRating" id="review-form-select">
										<option value=1>1 star</option>
										<option value=2>2 stars</option>
										<option value=3>3 stars</option>
										<option value=4>4 stars</option>
										<option value=5>5 stars</option>
									</select>
								</div>
								
								<label for="title" class="form-label">Title</label>
								<input type="text" class="form-control" name="title" id="review-form-title" placeholder="Title" required/>
								
								<label for="review" class="form-label">Review</label>
								<textarea class="form-control" name="review" id="review-form-text-area" rows="6" required></textarea>
								
								<div class='d-flex justify-content-end'>
									<button type="button" class="btn btn-secondary mt-2 me-2" onclick="closeReview()">Cancel</button>
									<input type="submit" class="btn btn-outline-dark mt-2" id="review-form-save" value="Post Review" />
								</div>
							</div>							
						</form>
					</div>
				</div>
			</div>
			
			<div>	
				<?php if ((!empty($reviews) && is_array($reviews)) && (!empty($users) && is_array($users))): ?>	
					<!-- Display user's review first -->
					<?php $userIndex = 0; ?>
					<?php foreach ($reviews as $review): ?>
						<?php if($users[$userIndex]['id'] == session()->get('id')): ?>						
							<div class="card mb-2">
								<div class="card-body">
									<div class="d-flex flex-row">
										<div class="d-flex flex-column align-items-center px-2">
											<?php if ($users[$userIndex]['profilePic'] == NULL): ?>
												<img class="rounded-circle"
													src="<?=base_url('profilePics')?>/default_profile.jpg" width="80px" height="80px">
											<?php else: ?>
												<img class="rounded-circle"
													src="<?=base_url('profilePics')?>/<?php print_r($users[$userIndex]['profilePic'])?>" width="80px" height="80px">
											<?php endif ?>
											<p class="mb-2"><?php print_r($users[$userIndex]['username'])?></p>
											<p class="m-0">
												<?php for ($x = 0; $x < $review['rating']; $x++): ?>
													<i class="fa fa-star checked text-warning" style="font-size:13px"></i>
												<?php endfor; ?>	
												<?php for ($x = 0; $x < ($review['rating']-5); $x++): ?>
													<i class="fa fa-star-o checked text-warning" style="font-size:13px"></i>
												<?php endfor; ?>
											</p>
										</div>
										<div class="flex-fill ms-3">
											<p class="fw-bold"><?= esc($review['title']) ?></p>
											<p style="white-space: pre-line" id="view-review"><?= esc($review['review']) ?></p>
										</div>
									</div>
									<p class="mt-1 mb-0 text-secondary"><?= esc($review['created_at']) ?></p>
								</div>
							</div>
							
							<script>
								document.getElementById('info-review').innerHTML= 'Edit Review';
								document.getElementById('save-review').setAttribute('action',"<?php echo base_url()?>/update-review/<?= esc($book['id']) ?>");
								document.getElementById('review-form-save').setAttribute('value','Save Changes');
								document.getElementById('review-form-title').setAttribute('value',"<?php print_r($review['title']) ?>");
								document.getElementById('review-form-text-area').innerHTML = document.getElementById('view-review').innerHTML; 
								$('#review-form-select').val(<?php print_r($review['rating']) ?>);
							</script>
						<?php endif; ?>
						<?php $userIndex++; ?>
					<?php endforeach ?>
					
					<!-- Display the rest -->
					<?php $revIndex = 0; ?>
					<?php foreach ($reviews as $review): ?>		
						<?php if($users[$revIndex]['id'] != session()->get('id')): ?>							
							<div class="card mb-2">
								<div class="card-body">
									<div class="d-flex flex-row">
										<div class="d-flex flex-column align-items-center px-2">
											<?php if ($users[$revIndex]['profilePic'] == NULL): ?>
												<img class="rounded-circle"
													src="<?=base_url('profilePics')?>/default_profile.jpg" width="80px" height="80px">
											<?php else: ?>
												<img class="rounded-circle"
													src="<?=base_url('profilePics')?>/<?php print_r($users[$revIndex]['profilePic'])?>" width="80px" height="80px">
											<?php endif ?>
											<p class="mb-2"><?php print_r($users[$revIndex]['username'])?></p>
											<p class="m-0">
												<?php for ($x = 0; $x < $review['rating']; $x++): ?>
													<i class="fa fa-star checked text-warning" style="font-size:13px"></i>
												<?php endfor; ?>	
												<?php for ($x = 0; $x < ($review['rating']-5); $x++): ?>
													<i class="fa fa-star-o checked text-warning" style="font-size:13px"></i>
												<?php endfor; ?>
											</p>
										</div>
										<div class="flex-fill ms-3">
											<p class="fw-bold"><?= esc($review['title']) ?></p>
											<p style="white-space: pre-line"><?= esc($review['review']) ?></p>
										</div>
									</div>
									<p class="mt-1 mb-0 text-secondary"><?= esc($review['created_at']) ?></p>
								</div>
							</div>
						<?php endif; ?>
						<?php $revIndex++; ?>
					<?php endforeach ?>
				<?php endif ?>
				
			</div>
			
		</div>
		
		<div class="col-12 col-md-4 col-lg-3 order-4 order-sm-4">
			<div class="card">
				<div class="card-body">
					<p class="fs-5 fw-bold">Recently added in <?= esc($book['category']) ?></p>

					<div class="row">
						<?php if ((!empty($similarBooks) && is_array($similarBooks)) && (!empty($similarCovers) && is_array($similarCovers))): ?>
							<?php $index = 0; ?>
							<?php foreach ($similarBooks as $books_item): ?>
								<a class="col-6 col-md-12 col-xl-6 py-2 px-1"
									href="<?php echo base_url() ?>/book/<?= esc($books_item['id'], 'url') ?>/<?= esc($books_item['slug'], 'url') ?>">
									<figure class="figure pb-2 mb-1 h-100 d-flex flex-column align-items-center">
										<img class="align-middle h-auto cover border-0 img-fluid"
											src="<?=base_url('covers')?>/<?php print_r($similarCovers[$index]['file_name'])?>" width="120px">
										<figcaption class="figure-caption"><?= esc($books_item['title']) ?></figcaption>
									</figure>
								</a>
								<?php $index++; ?>
							<?php endforeach ?>
						<?php else: ?>
							<p>Unable to find similar books for you.</p>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	function addReview(){
		formOpen = document.getElementById('card-form').style.display;
		if (formOpen == "none"){		
			document.getElementById('card-form').style.display = "block";				
		} else {
			closeReview();
		}
	}

	function closeReview(){
		document.getElementById('card-form').style.display = "none";
	}	
</script>

<script>	
	
	$('input[id=to-read]').change(function() {
		checkpoint = document.getElementById("to-read");
		list = checkpoint.defaultValue;	
		updateList(list);
	});
	
	$('input[id=reading]').change(function() {
		checkpoint = document.getElementById("reading");
		list = checkpoint.defaultValue;
		updateList(list);
	});
	
	$('input[id=complete]').change(function() {
		checkpoint = document.getElementById("complete");
		list = checkpoint.defaultValue;
		updateList(list);
	});
	
	function updateList(list){
		fetch('https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/updatelist/' + <?= esc($book['id']) ?> + '/' + list + '/' + <?= esc(session()->get('id')) ?>)
		.then(response => response.json())
		.then(response => {
			container = document.getElementById('book-info-cont');
			
			alert = document.createElement('div');
			alert.setAttribute('class','alert alert-success alert-dismissible fade show p-2 mt-3');
			alert.setAttribute('role','alert');
			
			closeButton = document.createElement('button');
			closeButton.setAttribute('class','btn-close p-2');
			closeButton.setAttribute('type','button');
			closeButton.setAttribute('data-bs-dismiss','alert');
			closeButton.setAttribute('aria-label','Close');
			
			info = document.createElement('p');
			info.setAttribute('class','mb-0');
			
			if (response['action'] === 1){
				info.innerHTML = 'You have added the book to your "' + response.list + '" list';
			} else{
				info.innerHTML = 'You have removed the book to your "' + response.list + '" list';
			}
			
			alert.append(info);
			alert.append(closeButton);
			container.append(alert);
		})
		.catch(err => {
			console.log(err);
		});
	}
	
	$(document).ready(function() {
		fetch('https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/bookinlists/' + <?= esc(session()->get('id')) ?> + '/' + <?= esc($book['id']) ?>)
		.then(response => response.json())
		.then(response => {			
			if(response.nolist == false){
				if (response.want != undefined){
					document.getElementById('to-read').checked = true;
				}
				if (response.reading != undefined){
					document.getElementById('reading').checked = true;
				}
				if (response.complete != undefined){
					document.getElementById('complete').checked = true;
				}
			}
		})
		.catch(err => {
			console.log(err);
		});
		
	});
</script>
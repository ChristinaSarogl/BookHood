<div class="container mt-3">
    <div class="container">
		<?php if ((!empty($books) && is_array($books)) && (!empty($covers) && is_array($covers))): ?>
			<div class="d-flex justify-content-center">
				<p class="bg-dark text-wrap px-3 rounded text-white fs-4 text-uppercase">Latest in <?= esc($books[0]['category']) ?></p>
			</div>
				
			<div class="row mx-0">
				<?php $recentIndex = 0; ?>
				<?php foreach ($recentBooks as $recent_books_item): ?> 
					<a class="col-6 col-sm-4 col-lg-2 py-2 px-1 text-center"
						href="<?php echo base_url() ?>/book/<?= esc($recent_books_item['id'], 'url') ?>/<?= esc($recent_books_item['slug'], 'url') ?>">
						<figure class="figure pb-2 mb-1 h-100 d-flex flex-column align-items-center">
						<img class="align-middle h-auto cover border-0 img-fluid"
							src="<?=base_url('covers')?>/<?php print_r($recentCovers[$recentIndex]['file_name'])?>" width="140px">
						<figcaption class="figure-caption"><?= esc($recent_books_item['title']) ?></figcaption>
						</figure>
					</a>
					<?php $recentIndex++; ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>

	<div class="container mt-3" style="background: #ebebeb;">
		<div class="row">			
			<div class="d-flex justify-content-between align-items-center">
				<p class="my-3 px-3 fs-5 fw-light"><?php echo count($books) ?> books</p>
				<div class="d-flex align-items-center">
					<p class="m-0 me-2">Sort by: </p>
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle px-1 px-sm-2" type="button" id="sortingLabel" data-bs-toggle="dropdown" aria-expanded="false">
                          Latest
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortingLabel">
                          <li><button class="dropdown-item" onclick="changeOption(1)">Latest</button></li>
						  <li><button class="dropdown-item" onclick="changeOption(2)">Name</button></li>
						  <li><button class="dropdown-item" onclick="changeOption(3)">Rating</button></li>
                        </ul>
                    </div>
				</div>
			</div>
			
			<hr>
			
			<div class="row" id="categoryBooks">
				<?php $index = 0; ?>
				<?php foreach ($books as $books_item): ?> 
					<a class="col-12 col-md-6 col-lg-4 py-2 px-2 d-flex link-dark"
						href="<?php echo base_url() ?>/book/<?= esc($books_item['id'], 'url') ?>/<?= esc($books_item['slug'], 'url') ?>">
						<img class="img-fluid" src="<?=base_url('covers')?>/<?php print_r($covers[$index]['file_name'])?>" width="120px">
						<div class="ms-2">
							<p class="fs-4 mb-1"><?= esc($books_item['title']) ?></p>
							<?php if ($ratings[$index] !== "none"): ?>
								<?php $floorNum = floor($ratings[$index]); ?>
								<?php for ($x = 0; $x < $floorNum; $x++): ?>
									<i class="fa fa-star checked text-warning" style="font-size:20px"></i>
								<?php endfor; ?>	
								<?php for ($x = 0; $x < (5-$floorNum); $x++): ?>
									<i class="fa fa-star-o checked text-secondary" style="font-size:20px"></i>
								<?php endfor; ?>
							<?php else: ?>
								<?php for ($x = 0; $x < 5; $x++): ?>
									<i class="fa fa-star-o checked text-secondary" style="font-size:20px"></i>
								<?php endfor; ?>
							<?php endif; ?>				
						</div>
					</a>
					<?php $index++; ?>
				<?php endforeach ?>
			</div>
			
	<?php else: ?>

		<h3>No Books in this category</h3>

		<p>Unable to find any books for you.</p>
		
	<?php endif ?>
	
	</div>
</div>

<script>
	function changeOption(option){
		booksDiv = document.getElementById("categoryBooks");
		while (booksDiv.firstChild) {
			booksDiv.removeChild(booksDiv.lastChild);
		}
		
		if (option == 1) {
			document.getElementById("sortingLabel").innerHTML = 'Latest';
			sortLatest();
		} else if (option == 2) {
			document.getElementById("sortingLabel").innerHTML = 'Name';
			sortName();
		} else {
			document.getElementById("sortingLabel").innerHTML = 'Rating';
			sortRating();
		}	
	}
	
	function sortLatest(){
		fetch("https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/sortby/1/<?= esc($books[0]['category']) ?>")
		.then(response => response.json())
		.then(response => {			
			console.log(response);
			displayResult(response);
		})
		.catch(err => {
			console.log(err);
		});	
	}
	
	function sortName(){		
		fetch("https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/sortby/2/<?= esc($books[0]['category']) ?>")
		.then(response => response.json())
		.then(response => {			
			console.log(response);
			displayResult(response);
		})
		.catch(err => {
			console.log(err);
		});		
	}
	
	function sortRating(){
		fetch("https://mi-linux.wlv.ac.uk/~1801448/bookhood/public/index.php/ajax/sortby/3/<?= esc($books[0]['category']) ?>")
		.then(response => response.json())
		.then(response => {	
			orderedRatings = response['ratings'].sort((firstItem, secondItem) => secondItem.rating - firstItem.rating);
			
			orderedBooks = [];
			orderedCovers = [];
			orderedRatings.forEach(function(book,index){
				response['books'].forEach(function(responseBook,responseIndex){
					if(book.book == responseBook.id){
						orderedBooks.push(responseBook);
						orderedCovers.push(response['covers'][responseIndex]);
					}
				});
			});
			
			data = { books: orderedBooks, covers: orderedCovers, ratings: orderedRatings};
			displayResult(data);
		})
		.catch(err => {
			console.log(err);
		});	
	}
	
	function displayResult(response){
		for(let i = 0; i < response['books'].length; i++){			
					
			bookDiv = document.createElement('a');
			bookDiv.setAttribute('class','col-12 col-md-6 col-lg-4 py-2 px-2 d-flex link-dark');
			bookDiv.setAttribute('href','<?php echo base_url() ?>/book/' + response['books'][i].id + '/' + response['books'][i].slug);
			
			cover = document.createElement('img');
			cover.setAttribute('class','img-fluid');
			cover.setAttribute('src',"<?=base_url('covers')?>/" + response['covers'][i]['file_name']);
			cover.setAttribute('width','120px');
			
			infoDiv = document.createElement('div');
			infoDiv.setAttribute('class','ms-2');
			
			title = document.createElement('p');
			title.setAttribute('class','fs-4 mb-1');
			title.innerHTML = response['books'][i].title;
			
			infoDiv.append(title);
			
			if(response['ratings'][i] == 'none'){
				for(let j = 0; j < 5; j++){
					star = document.createElement('i');
					star.setAttribute('class','fa fa-star-o checked text-secondary');
					star.setAttribute('style','font-size:20px');
					
					infoDiv.append(star);
				}
			} else {
				wholeNumber = Math.trunc(response['ratings'][i].rating);
				for(let whole = 0; whole < wholeNumber; whole++){
					star = document.createElement('i');
					star.setAttribute('class','fa fa-star checked text-warning');
					star.setAttribute('style','font-size:20px');
					
					infoDiv.append(star);
				}
				
				for(let empty = 0; empty < (5-wholeNumber); empty++){
					star = document.createElement('i');
					star.setAttribute('class','fa fa-star-o checked text-secondary');
					star.setAttribute('style','font-size:20px');
					
					infoDiv.append(star);
				}
			}
			
			bookDiv.append(cover);
			bookDiv.append(infoDiv);
			booksDiv.append(bookDiv);
		}
	}
</script>
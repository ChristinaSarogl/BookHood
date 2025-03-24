<div class="container pb-3" style="background: #ebebeb;">
	<div class="d-flex align-items-end pt-3">
		<p class="fs-2 fw-light m-0">Search Results</p>
		<p class="text-secondary mb-2 ms-2">(<?php echo count($books)+count($authors)+count($publishers) ?> results)</p>
	</div>
	<hr>
		
	<div class="d-none d-md-inline">
		<ul class="nav nav-tabs mt-4">
			<li class="nav-item">
			  <button class="nav-link active" id="search-books" onclick="getResults(1)">Books</button>
			</li>
			<li class="nav-item">
				<button class="nav-link link-dark" id="search-authors" onclick="getResults(2)">Authors</button>
			</li>
			<li class="nav-item">
				<button class="nav-link link-dark" id="search-publishers" onclick="getResults(3)">Publishers</button>
			</li>
		</ul>
	</div>
	
	<!-- Mobile -->
	<div class="d-md-none bg-white mt-2 mx-1">
		<select class="form-select" id="searchSelect">
			<option value="1" selected>Books</option>
			<option value="2">Authors</option>
			<option value="3">Publishers</option>
		</select> 
	</div>
	
	<div class="pt-2 bg-white"> 
		<div class="row mx-0">
			<div class="d-flex felx-row justify-content-between align-items-center">
				<p class="my-3 px-3 fs-5 fw-light" id="totalSearchResults"><?php echo count($books) ?> books</p>
			</div>
			
			<hr>
			
			<div class="row" id="searchBooks">
				<?php $index = 0; ?>
				<?php foreach ($books as $books_item): ?> 
					<a class="col-6 col-sm-4 col-lg-2 py-2 px-1 text-center" 
						href="<?php echo base_url() ?>/book/<?= esc($books_item['id'], 'url') ?>/<?= esc($books_item['slug'], 'url') ?>">
						<figure class="figure pb-2 mb-1 h-100 d-flex flex-column align-items-center">
							<img class="align-middle h-auto cover border-0 img-fluid"
								src="<?=base_url('covers')?>/<?php print_r($covers[$index]['file_name'])?>" width="140px">
							<figcaption class="figure-caption"><?= esc($books_item['title']) ?></figcaption>
						</figure>
					</a>
					<?php $index++; ?>
				<?php endforeach ?>
			</div>
			
			<div id="searchAuthors" style="display:none;">
				<ul class="list-group list-group-flush p-0">
					<?php foreach($authors as $author): ?>
						<li class="list-group-item"><?= esc($author) ?></li>
					<?php endforeach?>
                </ul>
			</div>
			
			<div id="searchPublishers" style="display:none;">
				<ul class="list-group list-group-flush p-0">
					<?php foreach($publishers as $publisher): ?>
						<li class="list-group-item"><?= esc($publisher) ?></li>
					<?php endforeach?>
                </ul>
			</div>
		</div>
	</div>
	
</div>

<script>
	function getResults(option){
		prevActiveLink = document.getElementsByClassName('nav-link active');
		
		for(let i = 0; i <= prevActiveLink.length-1; i++){
			prevActiveLink[i].setAttribute('class', 'nav-link link-dark');
		}
		
		if (option == 1){
			document.getElementById('search-books').setAttribute('class','nav-link active');
			document.getElementById('totalSearchResults').innerHTML = "<?php echo count($books) ?> books";
			$('#searchBooks').show();
			$('#searchAuthors').hide();
			$('#searchPublishers').hide();
			$('#searchSelect').val("1");
		} else if (option == 2){
			document.getElementById('search-authors').setAttribute('class','nav-link active');
			document.getElementById('totalSearchResults').innerHTML = "<?php echo count($authors) ?> authors";	
			$('#searchBooks').hide();
			$('#searchAuthors').show();
			$('#searchPublishers').hide();
			$('#searchSelect').val("2");
		} else {
			document.getElementById('search-publishers').setAttribute('class','nav-link active');
			document.getElementById('totalSearchResults').innerHTML = "<?php echo count($publishers) ?> publishers";
			$('#searchBooks').hide();
			$('#searchAuthors').hide();
			$('#searchPublishers').show();
			$('#searchSelect').val("3");
		}		
	}
	
	document.getElementById("searchSelect").onchange = changeListener;  
	function changeListener(){
		getResults(this.value);
	}
	
	$(document).ready(function() {
		<?php if($tab != null): ?>
			getResults(<?= esc($tab) ?>);
		<?php endif ?>
	});
</script>
<div class="container-fluid py-0" style="background: #ebebeb;">
	<div class="container py-3">		
		<?php if ((!empty($books) && is_array($books)) && (!empty($covers) && is_array($covers))): ?>
		
			<div class="d-flex justify-content-center">
				<p class="bg-dark text-wrap px-3 rounded text-white fs-4 text-uppercase">Latest additions</p>
			</div> 
			
			<div id="latestReleases" class="carousel slide" data-wrap="false" data-bs-interval="false">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<div class="row mx-0">		
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
					</div>
				</div>
			</div>

		<?php else: ?>

			<h3>No Books</h3>

			<p>Unable to find any books for you.</p>

		<?php endif ?>
	</div>
</div>

<div class="container-fluid py-0">
	<div class="container py-3">
		<?php if (!empty($reviews) && is_array($reviews)): ?>
	
			<div class="d-flex justify-content-center">
				<p class="bg-dark text-wrap px-3 rounded text-white fs-4 text-uppercase">Latest Reviews</p>
			</div> 
			
			<?php $index = 0; ?>
			<?php foreach ($reviews as $review): ?>
				<a class="card mb-2 link-dark"
					href="<?php echo base_url() ?>/book/<?= esc($revIds[$index], 'url') ?>/<?= esc($revSlugs[$index], 'url') ?>">
					<div class="card-body">
						<div class="row mx-2">
							<div class="col-3 col-lg-2 col-xl-1 px-0">
								<img class="align-middle cover border-0 img-fluid"
									src="<?=base_url('covers')?>/<?php print_r($revCovers[$index])?>" />
							</div>
							<div class="col-9 col-lg-10 col-xl-11">
								<div class="row align-items-center mb-3">
									<p class="col-12 col-md-auto fw-bold fs-5 mb-0"><?php print_r($revTitles[$index])?></p>
									<p class="col-12 col-md-auto m-0">
										<?php for ($x = 0; $x < $review['rating']; $x++): ?>
											<i class="fa fa-star checked text-warning" style="font-size:13px"></i>
										<?php endfor; ?>	
										<?php for ($x = 0; $x < ($review['rating']-5); $x++): ?>
											<i class="fa fa-star-o checked text-warning" style="font-size:13px"></i>
										<?php endfor; ?>
									</p>
								</div>
								<p class="fw-bold mb-2"><?= esc($review['title']) ?></p>
								<p class="d-flex align-self-stretch mb-2 "><?= esc($review['review']) ?></p>
								
								<small class="fst-italic mt-1 mb-0 text-secondary">
									<span class="me-1"><?= esc($review['created_at']) ?></span>
									<span>|</span>
									<span class="ms-1"><?php print_r($usernames[$index])?></span>
								</small>
							</div>
						</div>
					</div>
				</a>
				
				<?php $index++; ?>
			<?php endforeach ?>
			
		<?php else: ?>

			<h3>No Reviews</h3>

			<p>Unable to find any reviews for you.</p>

		<?php endif ?>
	</div>		
</div>

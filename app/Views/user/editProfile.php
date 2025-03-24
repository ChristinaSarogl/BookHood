<div class="container" style="background: #ebebeb;">
	<div class="d-flex align-items-center">
		<a class="link-dark link-dark fs-3 pt-3 me-3" href="<?php echo base_url() ?>/profile/<?php echo session()->get('id') ?>" ><i class="bi bi-arrow-left"></i></a>
		<p class="fs-3 fw-light pt-3 pb-0 m-0">Edit Profile</p>
	</div>
	<hr>
	
	<?= service('validation')->listErrors() ?>
	
	<form action="<?php echo base_url()?>/update/<?php echo session()->get('id') ?>" method="post" enctype="multipart/form-data">
		<?= csrf_field() ?>
		<div class="mb-3 mx-3">
			<label for="profile" class="form-label">New Profile Picture</label>
			<input type="file" name="profile" class="form-control" accept=".png, .jpg" />
		</div>
		<div class="mb-3 mx-3">
			<label for="username">Username</label>
			<input type="text" class="form-control" name="username" placeholder="PinkLabrator53" value="<?= esc($username) ?>" />
		</div>
		<div class="mb-3 mx-3">
			<label for="email">Email address</label>
			<input type="email" class="form-control" name="email" placeholder="name@example.com" value="<?= esc($email)?>" />					
		</div>   
	
		<div class="mx-3">
			<div class="row justify-content-center">
				<div class="col-12 col-md-6">
					<input type="submit" class="btn btn-dark w-100 mb-3" value="Save changes" />
				</div>
			</div>
		</div>
	</form> 
</div>
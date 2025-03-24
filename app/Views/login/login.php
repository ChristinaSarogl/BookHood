<div class="container pt-5">
	<!-- Mobile form -->
	<div class="d-sm-none">
		<p class="fw-bold fs-4 mb-3 text-uppercase text-center">Login</p>
		
		<div class="mb-3">
		   <?= session()->getFlashdata('msg') ?>
		</div>
		
		<form action="<?php echo base_url()?>/login" method="post" class="text-start">
			<?= csrf_field() ?>
			
			<div class="form-floating mb-3 mx-3">
				<input type="email" class="form-control" name="email" placeholder="name@example.com" required>
				<label for="email">Email address</label>
			</div>
			
			<div class="form-floating mb-2 mx-3">
				<input type="password" class="form-control" name="password" placeholder="Password" required>
				<label for="password">Password</label>
			</div>

			<div class="mt-4 text-center">
				<button type="submit" class="btn btn-outline-dark w-50">Login</button>
			</div>
			  
		</form>

		<div>
			<p class="mt-5 mb-2 text-center">Don't have an account?
				<a href="<?php echo base_url() ?>/register" class="text-secondary">Register</a>
			</p>
		</div>
	</div>
	
	<!-- Computer form -->
    <div class="row d-none d-sm-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark" style="border-radius: 1rem;">
				<div class="card-body px-5 py-2 text-center">
					<p class="fw-bold fs-4 mb-3 text-uppercase text-white">Login</p>
					
					<div class="mb-3 text-white">
					   <?= session()->getFlashdata('msg') ?>
					</div>

					<form action="<?php echo base_url()?>/login" method="post" class="text-start">
						<?= csrf_field() ?>
						
						<div class="form-floating mb-3 mx-3">
							<input type="email" class="form-control" name="email" placeholder="name@example.com" required>
							<label for="email">Email address</label>
						</div>
						
						<div class="form-floating mb-2 mx-3">
							<input type="password" class="form-control" name="password" placeholder="Password" required>
							<label for="password">Password</label>
						</div>

						<div class="mt-4 text-center">
							<button type="submit" class="btn btn-outline-light w-50">Login</button>
						</div>
                          
					</form>

					<p class="mt-5 mb-2 text-white">Don't have an account?
						<a href="<?php echo base_url() ?>/register" class="text-secondary">Register</a>
					</p>
				</div>
			</div>
		</div>
    </div>
 </div>
	<div class="container" style="background: #ebebeb;">
        <div class="row d-flex justify-content-center align-items-center">
            <p class="display-6 pt-3 text-center">Add Book</p>
            <hr>
			
            <div class="col-12 col-md-8 col-xl-7">  
			
				<div class="alert alert-danger" role="alert">
					<p class="mb-0">To start, check that the book is not already present on the site, by using the <strong>Search bar </strong>at the top of the site.</p>
				</div>
				
				<?= service('validation')->listErrors() ?>

                <form action="<?php echo base_url()?>/add_book" method="post" enctype="multipart/form-data" class="py-3">
					<?= csrf_field() ?>
					
                    <div class="row g-3 mb-3">
						<div class="form-floating col-md-6">
							<input type="text" class="form-control" id="add-book-title" name="title" placeholder="Book title" required>
							<label for="add-book-title">Book title</label>
						</div> 
						<div class="form-floating col-md-6">
							<input type="text" class="form-control" id="add-book-author" name="author" placeholder="Joe Doe" required>
							<label for="add-book-author">Author</label>
						</div> 
                    </div>
					
                    <div class="mb-3">
                        <label for="add-book-summary" class="form-label">Summary</label>
                        <textarea class="form-control" id="add-book-summary" name="summary" rows="6" required></textarea>
                    </div>
					
					<div class="form-floating mb-3">
						<input type="text" id="add-book-publisher" name="publisher" class="form-control" placeholder="Penguin" required>
						<label for="add-book-publisher">Publisher</label>
					</div> 

                    <div class="mb-3">
                        <span class="text-small">Release Date</span>
						<input type="date" name="release" class="form-control" required />
                    </div>
                    
					<div class="form-floating mb-3">
						<input type="text" id="add-book-isbn" name="isbn" class="form-control" placeholder="1234567890123" required>
						<label for="add-book-isbn">ISBN</label>
					</div> 
					
                    <div class="mb-3">
                        <p>Category</p>
                        
                        <div class="row">
                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Adventure" id="add-book-adventure" required>
                                    <label class="form-check-label" for="add-book-adventure">Adventure</label>
                                </div> 
                            </div>
                            
                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Crime-Mystery" id="add-book-crime-mystery">
                                    <label class="form-check-label" for="add-book-crime-mystery">Crime & Mystery</label>
                                </div>
                            </div>

                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Fantasy" id="add-book-fantasy">
                                    <label class="form-check-label" for="add-book-fantasy">Fantasy</label>
                                </div>
                            </div>

                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Historical" id="add-book-historical-fiction">
                                    <label class="form-check-label" for="add-book-historical-fiction">Historical Fiction</label>
                                </div>
                            </div>

                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Horror-Thriller" id="add-book-horror">
                                    <label class="form-check-label" for="add-book-horror">Horror & Thriller</label>
                                </div>
                            </div>

                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Lgbtq" id="add-book-lgbt">
                                    <label class="form-check-label" for="add-book-lgbt">LGBTQ+</label>
                                </div>
                            </div>

                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Romance" id="add-book-romance">
                                    <label class="form-check-label" for="add-book-romance">Romance</label>
                                </div>
                            </div>

                            <div class="col-6 col-sm-5 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="Sci-fi" id="add-book-sci-fi">
                                    <label class="form-check-label" for="add-book-sci-fi">Science Fiction</label>
                                </div>
                            </div>

                        </div>

                    </div>
                    
                    <div class="mb-3">
                        <label for="add-book-cover" class="form-label">Cover Image</label>
                        <input type="file" name="bookCover" class="form-control" id="add-book-cover" accept=".png, .jpg" required/>
                    </div>                    
    
                    <input type="submit" class="btn btn-outline-dark btn-lg w-100" value="Add book"/>
                </form>    
            </div>
        </div>     
    </div>
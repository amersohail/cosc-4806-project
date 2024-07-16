<?php require_once 'app/views/templates/header.php' ?>

<main role="main" class="container">
			<div class="page-header" id="banner">
					<div class="row">
							<div class="col-lg-12">
								<h1>Please login</h1>
								<?php if (isset($_SESSION['error'])): ?>
										<div class="alert alert-danger">
												<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
										</div>
								<?php endif; ?>
						</div>
			</div>
</div>

<div class="row">
			<div class="col-4">
			<form action="/login/verify" method="post" >
			<fieldset>
				<div class="form-group">
					<label for="username">Username</label>
					<input required type="text" class="form-control" name="username">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input required type="password" class="form-control" name="password">
				</div>
							<br>
					<button type="submit" class="btn btn-primary">Login</button>
			</fieldset>
			</form> 
			<p class="mt-2"><a href="create/index">Cick here to register for new account</a></p>
		</div>
</div>

<?php require_once 'app/views/templates/footer.php' ?>

</main>
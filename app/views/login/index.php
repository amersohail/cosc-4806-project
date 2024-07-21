<?php require_once 'app/views/templates/header.php' ?>

<main role="main" class="container mt-5">
		<div class="row justify-content-center">
				<div class="col-md-6">
						<div class="card shadow-sm">
								<div class="card-header bg-primary text-white">
										<h4 class="mb-0">Please Login</h4>
								</div>
								<div class="card-body">
										<?php if (isset($_SESSION['error'])): ?>
												<div class="alert alert-danger">
														<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
												</div>
										<?php endif; ?>
										<form action="/login/verify" method="post">
												<fieldset>
														<div class="form-group mb-3">
																<label for="username" class="form-label">Username</label>
																<input required type="text" class="form-control" id="username" name="username">
														</div>
														<div class="form-group mb-3">
																<label for="password" class="form-label">Password</label>
																<input required type="password" class="form-control" id="password" name="password">
														</div>
														<input type="hidden" name="redirect" value="<?php echo htmlspecialchars($data['redirect'] ?? '/home'); ?>">
														<div class="d-grid gap-2">
																<button type="submit" class="btn btn-primary">Login</button>
														</div>
												</fieldset>
										</form>
										<p class="mt-3 mb-0 text-center">
												<a href="create/index" class="text-primary">Click here to register for a new account</a>
										</p>
								</div>
						</div>
				</div>
		</div>
</main>

<?php require_once 'app/views/templates/footer.php' ?>
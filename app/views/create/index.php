<?php require_once 'app/views/templates/header.php'; ?>

<main role="main" class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Register</h4>
                </div>
                <div class="card-body">
                    <form action="/create/register" method="post">
                        <fieldset>
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input required type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input required type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input required type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </fieldset>
                    </form> 
                </div>
            </div>
            <div class="alert alert-warning mt-4" role="alert">
                <h4 class="alert-heading">Password Rules</h4>
                <ul class="mb-0">
                    <li>Contains at least one letter</li>
                    <li>Contains at least one digit</li>
                    <li>Is at least 8 characters long</li>
                    <li>May contain special characters (@$!%*?&)</li>
                </ul>
            </div>
            <p class="mt-3 text-center">
                <a href="/login" class="text-primary">Back to Login</a>
            </p>
        </div>
    </div>
</main>

<?php require_once 'app/views/templates/footer.php'; ?>
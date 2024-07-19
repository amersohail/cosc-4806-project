<?php require_once 'app/views/templates/header.php' ?>

<div class="container">
    <!-- Landing Banner -->
    <div class="bg-primary text-white text-center rounded mt-4 p-5">
        <h1 class="display-4">Welcome to AI Movie Finder</h1>
        <p class="lead">Discover reviews, ratings, and more about your favorite movies.</p>
        <hr class="my-4">
        <p>Enter a movie name in the search box below to get started.</p>
    </div>

    <!-- Search Box -->
    <div class="page-header" id="banner">
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="container mt-4">
                    <form class="d-flex" action="/movie/search" method="get">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search Movie" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search Movie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php' ?>
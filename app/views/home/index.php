<?php require_once 'app/views/templates/header.php' ?>

<div class="container">
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

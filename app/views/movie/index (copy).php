<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <?php if ($data['movie']): ?>
        <div class="row">
            <?php if (!empty($data['movie']['Poster']) && $data['movie']['Poster'] != 'N/A'): ?>
                <div class="col-md-4">
                    <img src="<?php echo htmlspecialchars($data['movie']['Poster']); ?>" class="img-fluid rounded" alt="Movie Poster">
                </div>
            <?php endif; ?>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h1 class="card-title"><?php echo htmlspecialchars($data['movie']['Title']); ?> (<?php echo htmlspecialchars($data['movie']['Year']); ?>)</h1>
                        <p class="card-text"><?php echo htmlspecialchars($data['movie']['Plot']); ?></p>
                        <p class="card-text"><strong>Director:</strong> <?php echo htmlspecialchars($data['movie']['Director']); ?></p>
                        <p class="card-text"><strong>Actors:</strong> <?php echo htmlspecialchars($data['movie']['Actors']); ?></p>
                        <p class="card-text"><strong>Genre:</strong> <?php echo htmlspecialchars($data['movie']['Genre']); ?></p>
                        <p class="card-text"><strong>IMDB Rating:</strong> <?php echo htmlspecialchars($data['movie']['imdbRating']); ?></p>
                        <?php if (!empty($data['movie']['imdbID'])): ?>
                            <p class="card-text">
                                <a href="https://www.imdb.com/title/<?php echo htmlspecialchars($data['movie']['imdbID']); ?>" target="_blank" class="btn btn-primary">View on IMDb</a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating and Review Section -->
        <div class="row mt-4">
            <div class="col-12">
                <?php if ($data['isAuthenticated']): ?>
                    <?php if ($data['averageRating']): ?>
                        <p>This movie is rated <?php echo round($data['averageRating'], 1); ?>/5 by our users.</p>
                    <?php else: ?>
                        <p>This movie has no ratings.</p>
                    <?php endif; ?>

                    <?php if ($data['userRating']): ?>
                        <div class="alert alert-info" role="alert">
                            You have rated this movie <?php echo $data['userRating']; ?>/5.
                        </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <h3>Give a Rating</h3>
                        <!-- Bootstrap slider for the rating input -->
                        <form action="/movie/rate" method="post">
                            <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($data['movie']['imdbID']); ?>">
                            <input type="hidden" name="movie_name" value="<?php echo htmlspecialchars($data['movie']['Title']); ?>">
                            <input type="hidden" name="query" value="<?php echo htmlspecialchars($_GET['query']); ?>">
                            <input type="range" class="form-range" min="1" max="5" step="0.5" id="ratingRange" name="rating" value="<?php echo $data['userRating'] ?: 3; ?>" oninput="updateRatingValue(this.value)">
                            <div class="mt-2">
                                <span>Rating: <span id="ratingValue"><?php echo $data['userRating'] ?: 3; ?></span></span>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Rate It</button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <h3>Get a Review</h3>
                        <!-- Button to trigger review generation -->
                        <form action="/movie/getReview" method="post">
                            <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($data['movie']['imdbID']); ?>">
                            <input type="hidden" name="query" value="<?php echo htmlspecialchars($_GET['query']); ?>">
                            <button type="submit" class="btn btn-secondary mt-2" <?php echo isset($data['googleReview']) ? 'disabled' : ''; ?>>Get Review</button>
                        </form>
                    </div>

                    <!-- Display review from Google Gemini -->
                    <?php if (isset($data['googleReview'])): ?>
                        <div class="mt-4">
                            <h3>Google Gemini Review</h3>
                            <div class="card bg-light mb-3">
                                <div class="card-header">Review</div>
                                <div class="card-body">
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($data['googleReview'])); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-warning mt-4" role="alert">
                        Please log in to give a rating and get a review.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            No movie found. Please search again.
            <div class="mt-2">
                <a href="/home" class="btn btn-primary">Go Back to Search</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
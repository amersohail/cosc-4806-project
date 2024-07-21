<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <?php if ($data['movie']): ?>
        <div class="row">
            <?php if (!empty($data['movie']['Poster']) && $data['movie']['Poster'] != 'N/A'): ?>
                <div class="col-md-3">
                    <img src="<?php echo htmlspecialchars($data['movie']['Poster']); ?>" class="img-fluid rounded" alt="Movie Poster">
                </div>
            <?php endif; ?>
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <h1 class="card-title"><?php echo htmlspecialchars($data['movie']['Title']); ?> (<?php echo htmlspecialchars($data['movie']['Year']); ?>)</h1>
                        <p class="card-text"><?php echo htmlspecialchars($data['movie']['Plot']); ?></p>
                        <p class="card-text"><strong>Director:</strong> <?php echo htmlspecialchars($data['movie']['Director']); ?></p>
                        <p class="card-text"><strong>Actors:</strong> <?php echo htmlspecialchars($data['movie']['Actors']); ?></p>
                        <p class="card-text"><strong>Genre:</strong> <?php echo htmlspecialchars($data['movie']['Genre']); ?></p>
                        <p class="card-text">
                            <strong>IMDB Rating:</strong>
                            <a href="https://www.imdb.com/title/<?php echo htmlspecialchars($data['movie']['imdbID']); ?>" target="_blank" style="color: #f5c518;">
                                <?php echo htmlspecialchars($data['movie']['imdbRating']); ?>
                            </a>
                        </p>
                        <?php if ($data['trailer']): ?>
                            <div class="trailer mt-4">
                                <h3 class="card-title">Watch Trailer</h3>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo htmlspecialchars($data['trailer']); ?>" allowfullscreen style="width: 100%; height: 315px;"></iframe>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating and Review Section -->
        <div class="row mt-4">
            <div class="col-12">
                <?php if ($data['isAuthenticated']): ?>
                    <?php if (isset($data['averageRating']) && $data['averageRating'] !== null): ?>
                        <p>This movie is rated <?php echo round($data['averageRating'], 1); ?>/5 by our users.</p>
                    <?php else: ?>
                        <p>This movie has no ratings.</p>
                    <?php endif; ?>

                    <?php if (isset($data['userRating']) && $data['userRating'] !== null): ?>
                        <div class="alert alert-info" role="alert">
                            You have rated this movie <?php echo htmlspecialchars($data['userRating']); ?>/5.
                        </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <h3>Give a Rating</h3>
                        <!-- Bootstrap slider for the rating input -->
                        <form action="/movie/rate" method="post">
                            <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($data['movie']['imdbID'] ?? ''); ?>">
                            <input type="hidden" name="movie_name" value="<?php echo htmlspecialchars($data['movie']['Title'] ?? ''); ?>">
                            <input type="hidden" name="query" value="<?php echo htmlspecialchars($data['query'] ?? ''); ?>">
                            <input type="range" class="form-range" min="1" max="5" step="0.5" id="ratingRange" name="rating" value="<?php echo isset($data['userRating']) ? htmlspecialchars($data['userRating']) : 3; ?>" oninput="updateRatingValue(this.value)">
                            <div class="mt-2">
                                <span>Rating: <span id="ratingValue"><?php echo isset($data['userRating']) ? htmlspecialchars($data['userRating']) : 3; ?></span></span>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Rate It</button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <h3>Get a Review</h3>
                        <!-- Button to trigger review generation -->
                        <form action="/movie/getReview" method="post">
                            <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($data['movie']['imdbID'] ?? ''); ?>">
                            <input type="hidden" name="query" value="<?php echo htmlspecialchars($data['query'] ?? ''); ?>">
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
                     <br>
                     <a href="/login?redirect=<?php echo urlencode('/movie/search?query=' . $data['query']); ?>" class="btn btn-warning mt-2">Log In</a>
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

<script>
    function updateRatingValue(value) {
        document.getElementById('ratingValue').innerText = value;
    }
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
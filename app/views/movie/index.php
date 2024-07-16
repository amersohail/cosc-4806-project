<?php require_once 'app/views/templates/header.php'; ?>

<div class="container">
    <div class="page-header" id="banner">
        <div class="container mt-4">
            <?php if ($data['movie']): ?>
                <h1><?php echo htmlspecialchars($data['movie']['Title']); ?> (<?php echo htmlspecialchars($data['movie']['Year']); ?>)</h1>
                <p><?php echo htmlspecialchars($data['movie']['Plot']); ?></p>
                <p><strong>Director:</strong> <?php echo htmlspecialchars($data['movie']['Director']); ?></p>
                <p><strong>Actors:</strong> <?php echo htmlspecialchars($data['movie']['Actors']); ?></p>
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($data['movie']['Genre']); ?></p>
                <p><strong>IMDB Rating:</strong> <?php echo htmlspecialchars($data['movie']['imdbRating']); ?></p>

                <?php if ($data['isAuthenticated']): ?>
                    <div class="mt-4">
                        <h3>Give a Rating</h3>
                        <!-- Placeholder for the rating input -->
                        <input type="number" min="1" max="10" class="form-control" placeholder="Rate this movie (1-10)">
                    </div>
                    <div class="mt-4">
                        <h3>Get a Review</h3>
                        <!-- Placeholder for the review input -->
                        <textarea class="form-control" rows="5" placeholder="Write your review"></textarea>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning mt-4" role="alert">
                        Please log in to give a rating and get a review.
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    No movie found. Please search again.
                    <div class="mt-2">
                        <a href="/home" class="btn btn-primary">Go Back to Search</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
<?php 
$root = $_SERVER['DOCUMENT_ROOT']; 
include($root . '/student071/dwes/files/common-files/db_connection.php');
include($root . '/student071/dwes/files/common-files/header.php'); 
?>

<div id="form-coments">
    <!-- Listado de reseñas aceptadas -->
    <h2>Customer Reviews</h2>
    <div id="reviews-list">
        <?php 
        $query = "SELECT r.review_id, r.customer_review, r.customer_score, r.inserted_on, u.user_online 
                  FROM 071_reviews r 
                  JOIN 071_users u ON r.user_id = u.user_id 
                  WHERE r.accepted = 1 
                  ORDER BY r.inserted_on DESC";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            while($review = mysqli_fetch_assoc($result)) {
                ?>
                <div class="review-card">
                    <h3><?php echo htmlspecialchars($review['user_online']); ?> - <?php echo htmlspecialchars($review['customer_score']); ?> stars</h3>
                    <p><?php echo htmlspecialchars($review['customer_review']); ?></p>
                    <small>Posted on: <?php echo htmlspecialchars($review['inserted_on']); ?></small>
                </div>
                <?php
            }
        } else {
            echo "<p>No reviews available.</p>";
        }
        ?>
    </div>
</div>

<!-- Formulario para dejar una reseña -->
<h2>Leave a Review</h2>
<form class="review-form" action="/student071/dwes/files/querys/reviews/insert_review.php" method="POST">
    <label for="review-title">Review Title</label>
    <input type="text" name="review_title" id="review-title" placeholder="Enter review title" required>

    <label for="review-text">Your Review</label>
    <textarea name="review_text" id="review-text" placeholder="Write your review here..." required></textarea>

    <label>Rating</label>
    <div id="star-rating">
        <i class="fa fa-star-o star" data-value="1"></i>
        <i class="fa fa-star-o star" data-value="2"></i>
        <i class="fa fa-star-o star" data-value="3"></i>
        <i class="fa fa-star-o star" data-value="4"></i>
        <i class="fa fa-star-o star" data-value="5"></i>
    </div>
    <!-- Campo oculto para almacenar el puntaje -->
    <input type="hidden" name="review_score" id="review-score" value="0" required>

    <button type="submit">Submit Review</button>
</form>

<?php 
include($root . '/student071/dwes/files/common-files/footer.php'); 
?>

<!-- JavaScript para la funcionalidad interactiva de las estrellas -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll("#star-rating .star");
    const ratingInput = document.getElementById("review-score");
    
    stars.forEach(function(star) {
        star.addEventListener("click", function() {
            const rating = parseInt(this.getAttribute("data-value"));
            ratingInput.value = rating;
            stars.forEach(function(s) {
                if (parseInt(s.getAttribute("data-value")) <= rating) {
                    s.classList.remove("fa-star-o");
                    s.classList.add("fa-star", "gold");
                } else {
                    s.classList.remove("fa-star", "gold");
                    s.classList.add("fa-star-o");
                }
            });
        });
    });
});
</script>


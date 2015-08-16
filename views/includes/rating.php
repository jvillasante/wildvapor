<?php $rating = round($rating_avg['rating']); ?>
<div class="rating-div">
  <span class="rating">
    <input type="radio" class="rating-input" disabled='disabled' <?php if ($rating == 5) { echo 'checked'; } ?>>
    <label for="rating-input-1-5" class="rating-star"></label>
    <input type="radio" class="rating-input" disabled='disabled' <?php if ($rating == 4) { echo 'checked'; } ?>>
    <label for="rating-input-1-4" class="rating-star"></label>
    <input type="radio" class="rating-input" disabled='disabled' <?php if ($rating == 3) { echo 'checked'; } ?>>
    <label for="rating-input-1-3" class="rating-star"></label>
    <input type="radio" class="rating-input" disabled='disabled' <?php if ($rating == 2) { echo 'checked'; } ?>>
    <label for="rating-input-1-2" class="rating-star"></label>
    <input type="radio" class="rating-input" disabled='disabled' <?php if ($rating == 1) { echo 'checked'; } ?>>
    <label for="rating-input-1-1" class="rating-star"></label>
    <br>
    <?php echo "$rating stars out of 5"; ?>
  </span>
</div>

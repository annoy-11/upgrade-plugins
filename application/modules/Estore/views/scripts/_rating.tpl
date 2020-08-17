<div class="estore_list_rating">
    <div class="estore_list_ratings emultlist_list_view_rating floatR">
      <?php for( $x=1; $x<=(int)$store->rating; $x++ ): ?>
      	<span class="estore_rating_star_small"></span>
      <?php endfor; ?>
      <?php if( (round($store->rating) - (int)$store->rating) > 0): ?>
      	<span class="estore_rating_star_small far fa-star-half"></span>
      <?php endif; ?>
      <?php for( $x=5; $x>round($store->rating); $x-- ): ?>
      	<span class="estore_rating_star_small estore_rating_star_disable"></span>
      <?php endfor; ?>
    </div>
</div>
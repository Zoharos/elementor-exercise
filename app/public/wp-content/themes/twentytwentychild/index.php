<style>
.product-list {
  display: flex;
  justify-content: center;
}

.product-card {
  width: 300px;
  margin: 20px;
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
}

.product-img {
  display: block;
  max-width: 100%;
  height: auto;
  margin-bottom: 10px;
}

.product-title {
  margin: 10px 0;
  font-size: 1.2em;
  font-weight: bold;
}

.product-excerpt {
  margin: 10px 0;
  font-size: 1em;
}

.product-price {
  margin: 10px 0;
  font-size: 1.2em;
}

.product-sale-price {
  margin: 10px 0;
  background-color: red;
  color: white;
  padding: 5px;
  font-size: 1.2em;
}

.product-category {
  margin: 10px 0;
  font-size: 1em;
}

</style>

<?php
$args = array(
    'post_type' => 'product',
    'posts_per_page' => 6,
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>

<div class="product-list">
  <?php while ($query->have_posts()) : $query->the_post(); ?>

  <div class="product-card">
    <?php if (has_post_thumbnail()) : ?>
    <?php
    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
    $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
    ?>
    <a href="<?php the_permalink(); ?>"><img class="product-img" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>"></a>
    <?php endif; ?>
    <div class="product-details">
      <h5 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
      <p class="product-excerpt"><?php echo get_the_excerpt(); ?></p>
      <?php if (get_post_meta(get_the_ID(), 'price', true)) : ?>
        <p class="product-price"><?php echo '$' . get_post_meta(get_the_ID(), 'price', true); ?></p>
        <?php if (get_post_meta(get_the_ID(), 'sale_price', true)) : ?>
        <p class="product-sale-price"><span class="badge badge-danger">Sale</span><?php echo ' $' . get_post_meta(get_the_ID(), 'sale_price', true); ?></p>
        <?php endif; ?>
      <?php endif; ?>
      <?php if (has_term('', 'category', get_the_ID())) : ?>
      <p class="product-category"><?php echo get_the_term_list(get_the_ID(), 'category', 'Category: ', ', '); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <?php endwhile; ?>
</div>

<?php endif; wp_reset_postdata(); ?>

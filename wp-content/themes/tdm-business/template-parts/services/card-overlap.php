<section class=card>
<?php
$card1_images = get_field("card1_image_array");
$card1_bg_style = (is_array($card1_images) && !empty($card1_images[0]['url']))
    ? 'background-image: url(' . esc_url($card1_images[0]['url']) . '); background-size: cover; background-position: center;'
    : '';

$card2_images = get_field("card2_image_array");
$card2_bg_style = (is_array($card2_images) && !empty($card2_images[0]['url']))
    ? 'background-image: url(' . esc_url($card2_images[0]['url']) . '); background-size: cover; background-position: center;'
    : '';
?>
<div>
    <div class="cardbkimage" style="<?php echo $card1_bg_style; ?>">
        <h2 class="card-title"><?php the_field("card1_title") ?></h2>
        <p class="card-subheading"><?php the_field("card1_subheading") ?></p>
        <button class="cta">Take Me There</button>
    </div>
</div>
<div>
    <div class="cardbkimage" style="<?php echo $card2_bg_style; ?>">
        <h2 class="card-title"><?php the_field("card2_title") ?></h2>
        <p class="card-subheading"><?php the_field("card2_subheading") ?></p>
        <button class="cta">Take Me There</button>
    </div>
</div>
</section>

<div class=controls>
    <button data-anim=-js-card-right class="overlap-arrow left">&lt;</button>
    <button data-anim=-js-card-left class="overlap-arrow right">&gt;</button>
</div>


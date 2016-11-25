<section class="<?php echo $atts['class']; ?> photogal">
    <div class="container-fluid">
        <div class="<?php echo $atts['container-class']; ?> text-center">
            <h1 class="<?php echo $atts['class']; ?>-title text-center"><?php echo $q->post_title ?></h1>
            <?php echo get_the_content() ?>
            <div id="photo-carousel-<?php echo get_the_ID() ?>" class="photo-carousel-<?php echo get_the_ID() ?> photo-gallery-carousel photo-lightgallery" data-toggle="owl-carousel">
                <?php
                $gallery_items = get_post_meta($q->ID, $metaboxes['gallerymetabox']['name'], true);
                foreach ($gallery_items as $key => $gallery) { ?>
                    <div class="item photo-gallery-carousel-item">
                        <div class="image-selector" data-src="<?php echo $gallery['item'] ?>" data-sub-html="#light-box-caption-<?php echo $key ?>">
                            <div class="image-container">
                                <img class="img-item" src="<?php echo $gallery['item'] ?>" >
                                <div id="light-box-caption-<?php echo $key ?>" class="hidden light-box-caption">
                                    <?php if($gallery['heading']): ?><h4><?php echo $gallery['heading'] ?></h4><?php endif; ?>
                                    <?php if($gallery['subheading']): ?><p><?php echo $gallery['subheading'] ?></p><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<script>
    var _photogal = {
        perSlide: "<?php echo $options['per_item']; ?>"
    }
</script>
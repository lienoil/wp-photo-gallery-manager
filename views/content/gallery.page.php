<section class="photo-gallery">
    <div class="container-fluid">
        <div class="offset-sm-1 col-sm-10">
            <div id="gallery-slider-<?php echo $photogal->ID ?>" class="photogal owl-carousel"><?php
                foreach ($pms_photos['carousel'] as $key => $carousel) { ?>
                    <div class="item">
                        <div class="image-selector" data-src="<?php echo $carousel['image'] ?>" data-sub-html="#light-box-caption-<?php echo $key ?>">
                            <div class="image-container">
                                <img class="img-item" src="<?php echo $carousel['image'] ?>" >
                                <div id="light-box-caption-<?php echo $key ?>" class="hidden light-box-caption">
                                    <?php if($carousel['heading']): ?><h4><?php echo $carousel['heading'] ?></h4><?php endif; ?>
                                    <?php if($carousel['subheading']): ?><p><?php echo $carousel['subheading'] ?></p><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div> <?php
                } ?>
            </div>
        </div>
    </div>
</section>
<?php
global $post;
$options = get_post_meta($photogal->ID, 'pms_photo_options', true);
$perSlide = ($options) ? $options['per_item'] : '5'; ?>
<script>
    var _photogal = {
        perSlide: "<?php echo $perSlide; ?>"
    }
</script>

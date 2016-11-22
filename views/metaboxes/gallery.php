<div class="gallery-card plugin-card">
    <div class="plugin-card-top">
        <div class="name column-name">
            <h3>
                <a href="http://localhost/wordpress-studies/wp-admin/plugin-install.php?tab=plugin-information&amp;plugin=wp-super-cache&amp;TB_iframe=true&amp;width=600&amp;height=550" class="thickbox open-plugin-details-modal">
                WP Super Cache                      <img src="//ps.w.org/wp-super-cache/assets/icon-256x256.png?rev=1095422" class="plugin-icon" alt="">
                </a>
            </h3>
        </div>
        <div class="action-links">
            <ul class="plugin-action-buttons"><li><a class="install-now button" data-slug="wp-super-cache" href="http://localhost/wordpress-studies/wp-admin/update.php?action=install-plugin&amp;plugin=wp-super-cache&amp;_wpnonce=2f1b1841dd" aria-label="Install WP Super Cache 1.4.8 now" data-name="WP Super Cache 1.4.8">Install Now</a></li><li><a href="http://localhost/wordpress-studies/wp-admin/plugin-install.php?tab=plugin-information&amp;plugin=wp-super-cache&amp;TB_iframe=true&amp;width=600&amp;height=550" class="thickbox open-plugin-details-modal" aria-label="More information about WP Super Cache 1.4.8" data-title="WP Super Cache 1.4.8">More Details</a></li></ul>              </div>
        <div class="desc column-description">
            <p>A very fast caching engine for WordPress that produces static html files.</p>
            <p class="authors"> <cite>By <a href="https://automattic.com/">Automattic</a></cite></p>
        </div>
    </div>
    <div class="plugin-card-bottom">
        <div class="vers column-rating">
            <div class="star-rating"><span class="screen-reader-text">4.5 rating based on 924 ratings</span><div class="star star-full" aria-hidden="true"></div><div class="star star-full" aria-hidden="true"></div><div class="star star-full" aria-hidden="true"></div><div class="star star-full" aria-hidden="true"></div><div class="star star-half" aria-hidden="true"></div></div>                 <span class="num-ratings" aria-hidden="true">(924)</span>
        </div>
        <div class="column-updated">
            <strong>Last Updated:</strong> 7 months ago             </div>
        <div class="column-downloaded">
            1+ Million Active Installs              </div>
        <div class="column-compatibility">
            <span class="compatibility-untested">Untested with your version of WordPress</span>             </div>
    </div>
</div>

<div class="gallery gallery-container">
    <div id="gallery_item_0" class="gallery-item">
        <div class="input-group">
            <button id="item-button-0" data-target="#gallery_item_0" type="button" class="pull-right button button-default button-large"><i class="dashicons-before dashicons-no-alt fa fa-times"></i></button>
        </div>
        <img id="gallery_photos_image_0" role="button" class="button-media-wps" data-target="#gallery_photos_image_0" data-input="#gallery_photos_image_input_0" src="<?php echo @$gallery_photos['gallery'][0]['image'] ?>" width="300" height="225">
        <input id="gallery_photos_image_input_0" type="hidden" name="gallery_photos[gallery][0][image]" value="<?php echo @$gallery_photos['gallery'][0]['image'] ?>">
        <div class="form-group">
            <strong>Heading</strong><br>
            <input type="text" name="gallery_photos[gallery][0][heading]" value="<?php echo @$gallery_photos['gallery'][0]['heading'] ?>"><br>
        </div>
        <div class="form-group">
            <strong>Subheading</strong><br>
            <input type="text" name="gallery_photos[gallery][0][subheading]" value="<?php echo @$gallery_photos['gallery'][0]['subheading'] ?>">
        </div>
    </div><?php

    if( (is_array($gallery_photos) && array_key_exists('gallery', $gallery_photos)) || !empty($gallery_photos['gallery']) ) {
        foreach ($gallery_photos['gallery'] as $key => $value) {
            if(0 != $key): ?>
            <div id="gallery_item_<?php echo $key ?>" class="gallery-item">
                <div class="input-group">
                    <button data-target="#gallery_item_<?php echo $key ?>" type="button" class="pull-right button-destroy gallery button button-default button-large"><i class="dashicons-before dashicons-no-alt fa fa-times"></i></button>
                </div>
                <img id="gallery_photos_image_<?php echo $key ?>" role="button" class="button-media-wps" data-target="#gallery_photos_image_<?php echo $key ?>" data-input="#gallery_photos_image_input_<?php echo $key ?>" src="<?php echo $value['image'] ?>" width="300" height="225">
                <input id="gallery_photos_image_input_<?php echo $key ?>" type="hidden" name="gallery_photos[gallery][<?php echo $key ?>][image]" value="<?php echo $value['image'] ?>">
                <div class="form-group">
                    <strong>Heading</strong><br>
                    <input type="text" name="gallery_photos[gallery][<?php echo $key ?>][heading]" value="<?php echo @$gallery_photos['gallery'][ $key ]['heading'] ?>"><br>
                </div>
                <div class="form-group">
                    <strong>Subheading</strong><br>
                    <input type="text" name="gallery_photos[gallery][<?php echo $key ?>][subheading]" value="<?php echo @$gallery_photos['gallery'][ $key ]['subheading'] ?>">
                </div>
            </div><?php
            endif;
        }
    } ?>

</div>
<div class="button-container">
    <button type="button" class="button-add gallery button button-primary button-large"><i class="fa fa-plus">&nbsp;</i>Add Slide</button>
    <button type="button" class="button-destroy-all gallery button button-default button-large"><i class="fa fa-minus">&nbsp;</i>Remove All Slides</button>
</div>
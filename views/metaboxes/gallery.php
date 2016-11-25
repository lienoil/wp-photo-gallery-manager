<div id="cloner-01" class="photogal clonable-block">
    <div class="gallery-cards">
        <?php if (empty($old)) : ?>
            <div class="gallery-card clonable" data-clone-number="1">
                <div class="gallery-card-top">
                    <button type="button" class="button button-destroy clonable-button-close pull-right"><i class="dashicons-before dashicons-no-alt"></i></button>
                    <img id="photoman-img-1" class="clonable-increment-id clonable-increment-data-target clonable-increment-data-input button-media image-previewer" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-target="#photoman-img-1" data-input="#photoman-input-1">
                    <input type="hidden" class="clonable-increment-id clonable-increment-name" name="<?php echo $metabox['name']; ?>[0][item]" id="photoman-input-1">
                </div>
                <div class="gallery-card-bottom">
                    <p><strong>Heading</strong></p>
                    <p><input class="regular-text clonable-increment-name" type="text" name="<?php echo $metabox['name']; ?>[0][heading]"></p>
                    <p><strong>Subheading</strong></p>
                    <p><input class="regular-text clonable-increment-name" type="text" name="<?php echo $metabox['name']; ?>[0][subheading]"></p>
                </div>
            </div>
        <?php else : ?>
            <?php foreach ($old as $key => $value) : ?>
                <div class="gallery-card clonable" data-clone-number="<?php echo $key+1; ?>">
                    <div class="gallery-card-top">
                        <button type="button" class="button button-destroy clonable-button-close pull-right"><i class="dashicons-before dashicons-no-alt"></i></button>
                        <img id="photoman-img-<?php echo $key; ?>" class="clonable-increment-id clonable-increment-data-target clonable-increment-data-input button-media image-previewer" src="<?php echo @$value['item']; ?>" data-target="#photoman-img-<?php echo $key; ?>" data-input="#photoman-input-<?php echo $key; ?>">
                        <input type="hidden" class="clonable-increment-id clonable-increment-name" name="<?php echo $metabox['name']; ?>[<?php echo $key; ?>][item]" id="photoman-input-<?php echo $key; ?>" value="<?php echo @$value['item']; ?>">
                    </div>
                    <div class="gallery-card-bottom">
                        <p><strong>Heading</strong></p>
                        <p><input class="regular-text clonable-increment-name" type="text" name="<?php echo $metabox['name']; ?>[<?php echo $key; ?>][heading]" value="<?php echo @$value['heading']; ?>"></p>
                        <p><strong>Subheading</strong></p>
                        <p><input class="regular-text clonable-increment-name" type="text" name="<?php echo $metabox['name']; ?>[<?php echo $key; ?>][subheading]" value="<?php echo @$value['subheading']; ?>"></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="button-container">
        <button type="button" class="button button-primary clonable-button-add">Add Slide</button>
        <button type="button" class="button button-default clonable-button-destroy-all">Remove All Slide</button>
    </div>
</div>
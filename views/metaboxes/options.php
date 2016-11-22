<table class="pms-gallery-options">
    <tbody>
        <tr>
            <th scope="row">
                <label for="shortcode">Shortcode to paste</label>
            </th>
            <td>
                <input id="shortcode" type="text" readonly value="[<?php echo PhotoController::$cpt_shortcode; ?> id='<?php echo $post->ID ?>']">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="items_per_slide">Items Per Slide</label>
            </th>
            <td>
                <input type="number" min="1" max="20" name="pms_photo_options[per_item]" value="<?php echo @$pms_photo_options['per_item'] ?>">
            </td>
        </tr>
    </tbody>
</table>
<div class="photogal">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="shortcode">Display on page</label>
                </th>
                <td>
                    <?php @wp_dropdown_pages(array(
                        'name' => $metabox['name'].'[display]',
                        'class' => 'form-control',
                        'selected' => isset($old) && $old['display'] ? $old['display'] : 0,
                        'show_option_none' => 'None - use shortcode',
                    )); ?>

                    <p class="description">Alternatively, use the shortcode below:</p>
                    <input id="shortcode" type="text" readonly name="<?php echo $metabox['name']; ?>[shortcode]" value="[<?php echo $global['shortcodes'][0] ?> id='<?php echo $post->ID ?>']">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="items_per_slide">Items Per Slide</label>
                </th>
                <td>
                    <input type="number" min="1" name="<?php echo $metabox['name']; ?>[per_item]" value="<?php echo (isset($old) && $old['per_item']) ? $old['per_item'] : 3 ?>">
                </td>
            </tr>
        </tbody>
    </table>
</div>
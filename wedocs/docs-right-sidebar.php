<?php
$opt = get_option('docly_opt');
$is_os_dropdown = isset($opt['is_os_dropdown']) ? $opt['is_os_dropdown'] : '1';
?>
<div class="col-lg-2 col-md-4 doc_right_mobile_menu">
    <div class="open_icon" id="right">
        <i class="arrow_carrot-left"></i>
        <i class="arrow_carrot-right"></i>
    </div>
    <div class="doc_rightsidebar scroll">
        <?php
        if ( $is_os_dropdown == '1' ) :
            wp_enqueue_style( 'bootstrap-select' );
            wp_enqueue_script( 'bootstrap-select' );
            if ( !empty($opt['os_options'][0]['title']) ) :
                ?>
                <select id="mySelect">
                    <?php
                    foreach ( $opt['os_options'] as $option ) { ?>
                        <option value="<?php echo sanitize_title($option['title']) ?>" data-content="<i class='<?php echo esc_attr($option['url']); ?>'></i> <?php echo esc_html($option['title']) ?>">
                            <?php echo esc_html($option['title']) ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <?php
            endif;
        endif;
        ?>
        <div id="font-switcher" class="d-flex justify-content-between align-items-center">
            <?php
            $is_font_switcher = isset($opt['is_font_switcher']) ? $opt['is_font_switcher'] : '1';
            if ( $is_font_switcher == '1' ) :
	            wp_enqueue_style( 'docly-font-size' );
	            wp_enqueue_script( 'docly-font-size' );
                ?>
                <div id="rvfs-controllers" class="fontsize-controllers group">
                    <div class="btn-group">
                        <button id="switcher-small" class="rvfs-decrease btn" title="<?php esc_attr_e('Decrease font size', 'docly'); ?>">A-</button>
                        <button class="rvfs-reset btn disabled" title="<?php esc_attr_e('Default font size', 'docly'); ?>">A</button>
                        <button id="switcher-large" class="rvfs-increase btn" title="<?php esc_attr_e('Increase font size', 'docly'); ?>">A+</button>
                    </div>
                </div>
                <?php
            endif;
            $is_print_icon = isset($opt['is_print_icon']) ? $opt['is_print_icon'] : '1';
            if ( $is_print_icon == '1' ) : ?>
                <a href="javascript:window.print()" class="print"><i class="icon_printer"></i></a>
            <?php endif; ?>
        </div>
        <?php
        $is_dark_switcher = isset($opt['is_dark_switcher']) ? $opt['is_dark_switcher'] : '1';
        if ( $is_dark_switcher == '1' ) : ?>
            <div class="doc_switch">
                <label for="something" class="tab-btn tab-btns light-mode"><i class="icon_lightbulb_alt"></i></label>
                <input type="checkbox" name="something" id="something" class="tab_switcher">
                <label for="something" class="tab-btn dark-mode"><i class="far fa-moon"></i></label>
            </div>
        <?php endif; ?>
        <?php
        if ( get_the_content($post->ID) ) :
            $d = new DOMDocument();
            libxml_use_internal_errors(true);
            $d->loadHTML('<?xml encoding="UTF-8">' . get_the_content($post->ID));
            $has_h2 = isset($d->getElementsByTagName('h2')['length']) ? $d->getElementsByTagName('h2')['length'] : '';
            if ( $has_h2 ) :
                ?>
                <div class="on-this-page">
                    <h6> <?php esc_html_e( 'On this page', 'docly' ); ?> </h6>
                    <nav class="doc_menu" id="navbar-example3"> </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ( is_active_sidebar('doc_sidebar') ) : ?>
            <div class="doc_sidebar mt-5">
                <?php dynamic_sidebar('doc_sidebar'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
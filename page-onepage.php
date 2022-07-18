<?php
/**
 * Template Name: Onepage Doc
 */

get_header('onepage');
?>

<?php
$opt = get_option('docly_opt');

$parent = function_exists('get_field') ? get_field('doc_id') : '';

// var_dump( $parent, $ancestors, $root );
$children = wp_list_pages(array(
	'title_li' => '',
	'order' => 'menu_order',
	'child_of' => $parent,
	'echo' => false,
	'post_type' => 'docs',
	'walker' => new Docly_Walker_Docs_Onepage(),
));

$doc_width = function_exists('get_field') ? get_field('doc_width') : '';
$doc_column = $doc_width == 'full-width' ? '2' : '3';
?>

<section class="doc_documentation_area onepage_doc_area page_wrapper" id="sticky_doc">
	<div class="overlay_bg"></div>
	<div class="container-fluid pl-60 pr-60">
		<div class="row doc-container">
			<div class="col-lg-2 doc_mobile_menu doc-sidebar display_none">
				<aside class="doc_left_sidebarlist">
					<h3 class="nav_title">
						<?php echo get_post_field( 'post_title', $parent, 'display' ); ?>
                    </h3>
                    <?php
                    if ( $children ) :
                        ?>
                        <div class="scroll">
                            <ul class="list-unstyled nav-sidebar doc-nav">
                                <?php
                                echo wp_list_pages(array(
                                    'title_li' => '',
                                    'order' => 'menu_order',
                                    'child_of' => $parent,
                                    'echo' => false,
                                    'post_type' => 'docs',
                                    'walker' => new Docly_Walker_Docs_Onepage(),
                                    'depth' => 0
                                ));
                                ?>
                            </ul>
                        </div>
                        <?php
                    endif;
                    ?>
				</aside>
			</div>
			<div class="col-lg-8 col-md-8">
				<div class="documentation_info" id="post">
                    <?php
                    $sections = get_children( array(
	                    'post_parent'    => $parent,
	                    'post_type'      => 'docs',
	                    'post_status'    => 'publish',
	                    'orderby'        => 'menu_order',
	                    'order'          => 'ASC',
	                    'posts_per_page' => !empty($settings['show_section_count']) ? $settings['show_section_count'] : -1,
                    ));

                    //echo '<pre>'.print_r($doc_items, 1).'</pre>';

                    $i = 0;
                    foreach ( $sections as $doc_item ) {
	                    $child_sections = get_children( array(
		                    'post_parent'    => $doc_item->ID,
		                    'post_type'      => 'docs',
		                    'post_status'    => 'publish',
		                    'orderby'        => 'menu_order',
		                    'order'          => 'ASC',
		                    'posts_per_page' => -1,
	                    ));
                        ?>
                        <article class="documentation_body doc-section onepage-doc-sec" id="<?php echo sanitize_title($doc_item->post_title) ?>">
                            <div class="shortcode_title">
                                <h2> <?php echo wp_kses_post($doc_item->post_title) ?> </h2>
                            </div>
                            <div class="doc-content">
	                            <?php
	                            $parent_content = \Elementor\Plugin::instance()->frontend->get_builder_content($doc_item->ID);
	                            echo !empty($parent_content) ? $parent_content : apply_filters('the_content', $doc_item->post_content);
	                            ?>
                            </div>

                            <?php
                            if ( $child_sections ) :
                                $articles_title = $opt['articles_title'] ?? esc_html__( 'Articles', 'docly' );
                                ?>
                                <div class="articles-list mt-5">
                                    <h4> <?php echo esc_html($articles_title) ?></h4>
                                    <ul class="list-unstyled article_list tag_list">
                                        <?php
                                        foreach ( $child_sections as $child_section ) {
                                            //echo '<pre>'.print_r($child_section, 1).'</pre>';
                                            ?>
                                            <li>
                                                <a href="#<?php echo sanitize_title($child_section->post_title) ?>">
                                                    <i class="icon_document_alt"></i><?php echo wp_kses_post($child_section->post_title) ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="border_bottom"></div>
                            <?php
                            foreach ( $child_sections as $child_section ) :
                                ?>
                                <div class="child-doc onepage-doc-sec" id="<?php echo sanitize_title($child_section->post_title) ?>">
                                    <div class="shortcode_title">
                                        <h2> <?php echo wp_kses_post($child_section->post_title) ?> </h2>
                                    </div>
                                    <div class="doc-content">
                                        <?php
                                        $child_content = \Elementor\Plugin::instance()->frontend->get_builder_content($child_section->ID);
                                        echo !empty($child_content) ? $child_content : apply_filters('the_content', $child_section->post_content);
                                        ?>
                                    </div>
                                    <div class="border_bottom"></div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </article>
                        <?php
                    ++$i;
                    }
                    ?>
				</div>
			</div>
			<div class="col-lg-2 col-md-4 doc_right_mobile_menu">
				<div class="open_icon" id="right">
					<i class="arrow_carrot-left"></i>
					<i class="arrow_carrot-right"></i>
				</div>
				<div class="doc_rightsidebar">
					<?php
					$is_os_dropdown = isset($opt['is_os_dropdown']) ? $opt['is_os_dropdown'] : '1';
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
                    $sidebar_content = function_exists('get_field') ? get_field('right_sidebar_content') : '';
                    if ( !empty($sidebar_content) ) {
                        echo '<div class="onepage-sidebar mt-5 doc_sidebar">';
	                    echo do_shortcode( $sidebar_content );
	                    echo '</div>';
                    }
                    ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
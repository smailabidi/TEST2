<?php
$sections = get_children(array(
    'post_parent'    => $post->ID,
    'post_type'      => 'docs',
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => !empty($settings['show_section_count']) ? $settings['show_section_count'] : -1,
));
?>

<?php if ( $sections && $post->post_parent === 0 ) : ?>
    <div class="row">
        <?php
        foreach ($sections as $section) : ?>
            <div class="col-lg-6 col-sm-6">
                <div class="media documentation_item">
                    <div class="icon">
                        <?php
                        if ( has_post_thumbnail($section->ID) ) {
                            echo get_the_post_thumbnail($section->ID, 'full');
                        } else {
                            $default_icon = DOCLY_DIR_IMG.'/icons/folder.png';
                            echo "<img src='$default_icon' alt='{$section->post_title}'>";
                        }
                        ?>
                    </div>
                    <div class="media-body">
                        <a href="<?php echo get_permalink( $section->ID ); ?>">
                           <h5> <?php echo wp_kses_post( $section->post_title ); ?> </h5>
                        </a>
                        <p>
                            <?php
                            $excerpt_limit = !empty($opt['excerpt_limit']) ? $opt['excerpt_limit'] : 8;
                            if ( strlen(trim($section->post_excerpt)) != 0 ) {
                                echo wp_trim_words( $section->post_excerpt, $excerpt_limit, '' );
                            } else {
                                echo wp_trim_words( $section->post_content, $excerpt_limit, '' );
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php
$opt = get_option('docly_opt');
$ancestors = array();
$root = $parent = false;
if ( $post->post_parent ) {
    $ancestors = get_post_ancestors($post->ID);
    $root = count($ancestors) - 1;
    $parent = $ancestors[$root];
} else {
    $parent = $post->ID;
}

// var_dump( $parent, $ancestors, $root );
$walker = new Docly_Walker_Docs();
$children = wp_list_pages(array(
    'title_li' => '',
    'order' => 'menu_order',
    'child_of' => $parent,
    'echo' => false,
    'post_type' => 'docs',
    'walker' => $walker,
));

$doc_column = Docly_helper()->doc_width() == 'full-width' ? '2' : '3';
?>

<div class="col-lg-<?php echo esc_attr($doc_column) ?> doc_mobile_menu display_none">
    <aside class="doc_left_sidebarlist">
        <div class="open_icon" id="left">
            <i class="arrow_carrot-right"></i>
            <i class="arrow_carrot-left"></i>
        </div>
        <h2 class="doc-title">
            <?php echo get_post_field( 'post_title', $parent, 'display' ); ?>
        </h2>
        <?php
        if ( $children ) :
            ?>
            <div class="scroll">
                <ul class="list-unstyled nav-sidebar">
                    <?php
                    echo wp_list_pages(array(
                        'title_li' => '',
                        'order' => 'menu_order',
                        'child_of' => $parent,
                        'echo' => false,
                        'post_type' => 'docs',
                        'walker' => $walker,
                    ));
                    ?>
                </ul>
            </div>
            <?php
            $links = !empty($opt['doc_left_sidebar_links']) ? $opt['doc_left_sidebar_links'] : '';
            if ( $links ) :
                ?>
                <ul class="list-unstyled nav-sidebar coding_nav">
                    <?php
                    foreach ($links as $link) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url($link['url']); ?>">
                                <img src="<?php echo esc_url($link['image']); ?>" alt="<?php esc_attr_e('icon', 'docly'); ?>">
                                <?php echo wp_kses_post($link['title']); ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            endif;
        endif;
        ?>
    </aside>
</div>
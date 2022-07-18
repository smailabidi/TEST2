<?php
if ( $docs ) :
    switch ( $col ) {
        case '2':
            $col = '6';
            break;
        case '3':
            $col = '4';
            break;
        case '4':
            $col = '3';
            break;
        case '6':
            $col = '2';
            break;
        default:
            $col = '4';
    }
    ?>
    <div class="row">
        <?php foreach ( $docs as $main_doc ) : ?>
            <div class="col-lg-<?php echo $col; ?> col-sm-6">
                <div class="categories_guide_item wow fadeInUp">
                    <?php echo get_the_post_thumbnail($main_doc['doc']->ID, 'full') ?>
                    <a class="doc_tag_title" href="<?php echo get_permalink( $main_doc['doc']->ID ); ?>">
                        <h4 class="title"><?php echo $main_doc['doc']->post_title; ?></h4>
                    </a>
                    <ul class="list-unstyled tag_list">
                        <?php foreach ( $main_doc['sections'] as $section ) { ?>
                            <li><a href="<?php echo get_permalink( $section->ID ); ?>">
                                    <i class="icon_document_alt"></i><?php echo $section->post_title; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <a href="<?php echo get_permalink( $main_doc['doc']->ID ); ?>" class="doc_border_btn">
                        <?php echo $more; ?><i class="arrow_right"></i>
                    </a>
                </div>
            </div>
            <?php
        endforeach;
        ?>
    </div>
    <?php
endif;

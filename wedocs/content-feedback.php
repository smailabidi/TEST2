<?php
global $post;
$opt = get_option('docly_opt');

$positive = (int) get_post_meta( $post->ID, 'positive', true );
$negative = (int) get_post_meta( $post->ID, 'negative', true );

$positive_title = $positive ? sprintf( _n( '%d person found this useful', '%d persons found this useful', $positive, 'docly' ), number_format_i18n( $positive ) ) : esc_html__( 'No votes yet', 'docly' );
$negative_title = $negative ? sprintf( _n( '%d person found this not useful', '%d persons found this not useful', $negative, 'docly' ), number_format_i18n( $negative ) ) : esc_html__( 'No votes yet', 'docly' );

$still_stuck_text = !empty($opt['still_stuck_text']) ? $opt['still_stuck_text'] : esc_html__('Still stuck?', 'docly');
$help_form_link_text = !empty($opt['help_form_link_text']) ? $opt['help_form_link_text'] : esc_html__('How can we help?', 'docly');
$doc_feedback_label = !empty($opt['doc_feedback_label']) ? $opt['doc_feedback_label'] : esc_html__('Was this page helpful?', 'docly');

$is_feedback_area = isset($opt['is_feedback_area']) ? $opt['is_feedback_area'] : '';
?>

<?php if ( $is_feedback_area == '1' ) : ?>
    <div class="feedback-area">
        <div class="border_bottom mt-md-5"></div>
        <div class="row">
            <div class="col-lg-5">
                <div class="still-stuck">
                    <h6>
                        <i class="icon_mail_alt"></i> <?php echo esc_html($still_stuck_text) ?>
                        <a href="#exampleModal2" data-toggle="modal" data-target="#exampleModal2">
                            <?php echo esc_html($help_form_link_text) ?>
                        </a>
                    </h6>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="still-stuck feedback_link wedocs-feedback-wrap wedocs-hide-print">
                    <div id="was-this-helpful" class="text-right">
                        <span> <?php echo esc_html($doc_feedback_label) ?> </span>
                        <span class="vote-link-wrap">
                            <a href="#" class="h_btn wedocs-tip positive" data-id="<?php the_ID(); ?>" data-type="positive" title="<?php echo esc_attr( $positive_title ); ?>">
                                <?php esc_html_e( 'Yes', 'docly' ); ?>
                                <?php if ( $positive ) { ?>
                                    <span class="count"><?php echo number_format_i18n( $positive ); ?></span>
                                <?php } ?>
                            </a>
                            <a href="#" class="h_btn wedocs-tip negative" data-id="<?php the_ID(); ?>" data-type="negative" title="<?php echo esc_attr( $negative_title ); ?>">
                                <?php esc_html_e( 'No', 'docly' ); ?>
                                <?php if ( $negative ) { ?>
                                    <span class="count"><?php echo number_format_i18n( $negative ); ?></span>
                                <?php } ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
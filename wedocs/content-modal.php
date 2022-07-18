<?php
$opt = get_option('docly_opt');

$name = $email = '';

if ( is_user_logged_in() ) {
    $user  = wp_get_current_user();
    $name  = $user->display_name;
    $email = $user->user_email;
}

?>

<div class="modal fade img_modal" id="exampleModal2" tabindex="-2" role="dialog" aria-hidden="false">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class=" icon_close"></i>
    </button>
    <div class="modal-dialog help_form" role="document">
        <div class="modal-content wedocs-modal-body">
            <div class="shortcode_title">
                <?php echo !empty($opt['feedback_form_title']) ? "<h2>".$opt['feedback_form_title']."</h2>" : ''; ?>
                <?php echo !empty($opt['feedback_form_subtitle']) ? wp_kses_post(wpautop($opt['feedback_form_subtitle'])) : ''; ?>
            </div>
            <div id="wedocs-modal-errors"></div>
            <form method="post" action="" id="wedocs-contact-modal-form" class="contact_form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?php echo esc_attr($name); ?>" name="name" id="name" placeholder="<?php esc_attr_e('Name', 'docly'); ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="email" class="form-control" name="email" id="email" placeholder="<?php esc_attr_e('Email', 'docly'); ?>" <?php disabled( is_user_logged_in() ); ?> required>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="<?php esc_attr_e('Subject', 'docly'); ?>" required>
                    </div>
                    <div class="form-group col-md-12">
                        <textarea name="message" id="massage" placeholder="<?php esc_attr_e('Message', 'docly'); ?>" required></textarea>
                    </div>
                    <div class="wedocs-form-action form-group col-md-12">
                        <button type="submit" name="submit" class="btn action_btn">
                            <?php esc_html_e('Send', 'docly'); ?>
                        </button>
                        <input type="hidden" name="doc_id" value="<?php the_ID(); ?>">
                        <input type="hidden" name="action" value="wedocs_contact_feedback">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
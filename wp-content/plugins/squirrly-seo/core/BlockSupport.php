<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockSupport extends SQ_Classes_BlockController {

    public function init() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('support');

        echo $this->getView('Blocks/Support');
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        global $current_user;
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_feedback':
                $return = array();

                SQ_Classes_Helpers_Tools::saveOptions('sq_feedback', 1);

                $from = $current_user->user_email;
                $subject = __('Plugin Feedback', _SQ_PLUGIN_NAME_);
                $face = SQ_Classes_Helpers_Tools::getValue('feedback', false);

                if ($face) {
                    switch ($face) {
                        case 1:
                            $face = 'Angry';
                            break;
                        case 2:
                            $face = 'Sad';
                            break;
                        case 3:
                            $face = 'Happy';
                            break;
                        case 4:
                            $face = 'Excited';
                            break;
                        case 5:
                            $face = 'Love it';
                            break;
                    }

                    $message = '';
                    if ($face <> '') {
                        $message .= 'Url:' . get_bloginfo('wpurl') . "\n";
                        $message .= 'Face:' . $face;
                    }

                    $headers[] = 'From: ' . $from . ' <' . $from . '>';

                    //$this->error='buuum';
                    wp_mail(_SQ_SUPPORT_EMAIL_, $subject, $message, $headers);
                    $return['message'] = __('Thank you for your feedback', _SQ_PLUGIN_NAME_);
                    $return['success'] = true;

                } else {
                    $return['message'] = __('No message.', _SQ_PLUGIN_NAME_);
                    $return['error'] = true;
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                echo json_encode($return);
                break;
        }
        exit();
    }

}

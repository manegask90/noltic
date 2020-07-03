<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Overview
 */
class SQ_Controllers_Overview extends SQ_Classes_FrontController {
    /** @var object Checkin process with Squirrly Cloud */
    public $checkin;

    public function init() {
        //Checkin to API V2
        $this->checkin = SQ_Classes_RemoteController::checkin();

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        if(is_rtl()){
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('popper');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap.rtl');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        }else{
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        }
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('research');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('dashboard');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('account');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');

        add_action('sq_form_notices', array($this,'getNotificationBar'));

        //@ob_flush();
        parent::init();

    }


}

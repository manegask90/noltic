<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Onboarding extends SQ_Classes_FrontController {

    public $metas;
    public $active_plugins;

    /**
     * Call for Onboarding
     * @return mixed|void
     */
    public function init() {
        //Clear the Scripts and Styles from other plugins
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->clearStyles();

        $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'step1');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        if(is_rtl()){
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('popper');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap.rtl');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        }else{
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        }
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('onboarding');

        if (method_exists($this, preg_replace("/[^a-zA-Z0-9]/", "", $tab))) {
            call_user_func(array($this, preg_replace("/[^a-zA-Z0-9]/", "", $tab)));
        }

        //@ob_flush();
        echo $this->getView('Onboarding/' . ucfirst($tab));
    }

    public function step1() {
        //Set the onboarding version
        SQ_Classes_Helpers_Tools::saveOptions('sq_onboarding', SQ_VERSION);
    }

    /**
     * Check SEO Actions
     */
    public function action() {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_onboading_checksite':
                /** @var SQ_Models_CheckSeo $seoCheck */
                $seoCheck = SQ_Classes_ObjController::getClass('SQ_Models_CheckSeo');
                $seoCheck->getSourceCode();
                $this->metas = $seoCheck->checkMetas();


                break;

            case 'sq_onboarding_commitment':
                SQ_Classes_Helpers_Tools::saveOptions('sq_seojourney', date('Y-m-d'));

                break;

        }
    }

}
<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockKRHistory extends SQ_Classes_BlockController {

    public $kr;

    function hookGetContent() {
        $args = array();
        $args['limit'] = 100;
        $this->kr = SQ_Classes_RemoteController::getKRHistory($args);

        echo $this->getView('Blocks/KRHistory');
    }

}

<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockFeatures extends SQ_Classes_BlockController {

    function init() {
        parent::init();

        echo $this->getView('Blocks/Features');
    }

}

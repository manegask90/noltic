<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockKRFound extends SQ_Classes_BlockController {

    public $keywords;

    function hookGetContent() {

        $this->keywords = SQ_Classes_RemoteController::getKrFound();
        SQ_Debug::dump($this->keywords);

        echo $this->getView('Blocks/KRFound');
    }

}

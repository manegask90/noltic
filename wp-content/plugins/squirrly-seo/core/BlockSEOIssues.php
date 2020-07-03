<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockSEOIssues extends SQ_Classes_BlockController {
    public $audits;
    public $tasks;
    //
    public $title = true;

    public function hookGetContent() {
        echo $this->getView('Blocks/SEOIssues');
    }

}

<?php

class SQ_Models_Focuspages_Authority extends SQ_Models_Abstract_Assistant {

    protected $_category = 'authority';

    protected $_moz_page_authority = false;

    const AUTHORITY_MINVAL = 35;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (isset($this->_audit->data->sq_analytics_moz->page_authority)) {
            $this->_moz_page_authority = $this->_audit->data->sq_analytics_moz->page_authority;
        } else {
            $this->_error = true;
        }

    }

    /**
     * Customize the tasks header
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        return $header;
    }


    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'authority' => array(
                'title' => sprintf(__("Authority over %s", _SQ_PLUGIN_NAME_), self::AUTHORITY_MINVAL),
                'value' => (int)$this->_moz_page_authority . ' ' . __('Authority', _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Your Page Authority Needs to be over %s to complete this task. %s To do that you'll need good metrics for all the tasks in the Traffic Health section of Focus Pages. %s You'll also need inner links, social media signals and backlinks from 3rd party sites.", _SQ_PLUGIN_NAME_), self::AUTHORITY_MINVAL, '<br /><br />', '<br /><br />'),
            ),
        );
    }

    /*********************************************/
    /**
     * Show the page authority
     *
     */
    public function getValue() {
        if ($this->_moz_page_authority !== false) {
            return (int)$this->_moz_page_authority;
        }

        return false;
    }

    /**
     * Check the page authority to be grater than AUTHORITY_MINVAL
     * @return bool|WP_Error
     */
    public function checkAuthority($task) {
        if ($this->_moz_page_authority !== false) {
            $task['completed'] = ($this->_moz_page_authority >= self::AUTHORITY_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

}
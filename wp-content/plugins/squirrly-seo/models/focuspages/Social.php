<?php

class SQ_Models_Focuspages_Social extends SQ_Models_Abstract_Assistant {

    protected $_category = 'social';
    protected $_social_shares = 0;

    const SHARES_MINVAL = 100;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (!isset($this->_audit->data->sq_analytics_facebook->share) &&
            !isset($this->_audit->data->sq_analytics_facebook->like) &&
            !isset($this->_audit->data->sq_analytics_pinterest->share) &&
            !isset($this->_audit->data->sq_analytics_reddit->share)) {
            $this->_error = true;
        }

        if (isset($this->_audit->data->sq_analytics_facebook->share)) {
            $this->_social_shares += (int)$this->_audit->data->sq_analytics_facebook->share;
        }
        if (isset($this->_audit->data->sq_analytics_facebook->like)) {
            $this->_social_shares += (int)$this->_audit->data->sq_analytics_facebook->like;
        }
        if (isset($this->_audit->data->sq_analytics_pinterest->share)) {
            $this->_social_shares += (int)$this->_audit->data->sq_analytics_pinterest->share;
        }
        if (isset($this->_audit->data->sq_analytics_reddit->share)) {
            $this->_social_shares += (int)$this->_audit->data->sq_analytics_reddit->share;
        }
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'social' => array(
                'title' => sprintf(__("%s Shares", _SQ_PLUGIN_NAME_), self::SHARES_MINVAL),
                'value' => $this->_social_shares . ' ' . __('social share', _SQ_PLUGIN_NAME_),
                'penalty' => 10,
                'description' => sprintf(__("This task only tracks shares from trackable sources. %s Twitter and LinkedIN share counts are no longer available. %s Of course, for Twitter you can always pay Twitter directly for API access, in which case we could give you a guide on how to integrate your Twitter API with our Focus Pages audit services. %s %shttps://developer.twitter.com/en/pricing/search-fullarchive%s", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<a href="https://developer.twitter.com/en/pricing/search-fullarchive" target="_blank">', '</a>'),
            ),
        );

    }

    /*********************************************/
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $header .= '<li class="completed">
                    <a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" target="_blank" class="sq_research_selectit btn btn-success text-white col-sm-10 offset-1">' . __('Go to Social Media Settings', _SQ_PLUGIN_NAME_) . '</a>
                </li>';

        return $header;
    }

    public function getTitle($title) {
        parent::getTitle($title);

        foreach ($this->_tasks[$this->_category] as $task) {
            if ($task['completed'] === false) {
                return __("Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
            }
        }

        return $title;
    }

    public function getValue() {
        if ($this->_social_shares !== false) {
            return number_format((int)$this->_social_shares, 0, '','.');
        }

        return false;
    }

    public function checkSocial($task) {
        $task['completed'] = ($this->_social_shares > self::SHARES_MINVAL);
        return $task;
    }

}
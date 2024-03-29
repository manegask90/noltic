<?php

class SQ_Models_Focuspages_Content extends SQ_Models_Abstract_Assistant {

    protected $_category = 'content';

    protected $_keyword = false;
    protected $_optimization = false;
    protected $_modified = false;

    const OPTIMIZATION_MINVAL = 100;
    const UPDATEDAT_MAXVAL = 3;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (isset($this->_audit->data->sq_seo_keywords->optimization_percent)) {
            $this->_optimization = $this->_audit->data->sq_seo_keywords->optimization_percent;
        }
        if (isset($this->_audit->data->sq_seo_keywords->value)) {
            $this->_keyword = $this->_audit->data->sq_seo_keywords->value;
        }
        if (isset($this->_audit->data->sq_seo_briefcase) && !empty($this->_audit->data->sq_seo_briefcase)) {
            foreach ($this->_audit->data->sq_seo_briefcase as $lsikeyword) {
                if (strcasecmp($lsikeyword->keyword, $this->_keyword) == 0) {
                    $this->_optimization = $lsikeyword->optimized;
                }
            }
        }
        if (isset($this->_post->post_modified)) {
            $this->_modified = $this->_post->post_modified;
        }
        //add_filter('sq_assistant_' . $this->_category . '_task_practice', array($this, 'getPractice'), 11, 2);
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'optimization' => array(
                'title' => sprintf(__("Optimize to %s", _SQ_PLUGIN_NAME_), self::OPTIMIZATION_MINVAL . '%'),
                'value' => $this->_optimization . '%',
                'description' => sprintf(__("Make sure this Focus Page is optimized to 100%% using the %sSquirrly SEO Live Assistant%s. %s As you can see clearly on Google search result pages, Googles tries to find the closest match (inside web content) to what the user searched for. %s That is why using this method of optimizing a page as outlined by the Live Assistant feature is mandatory. %s Don't worry about over-optimizing anything, as the Live Assistant checks for many over-optimization traps you may fall into.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant') . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'snippet' => array(
                'title' => __("Snippet is green", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("The tasks inside the %sSnippet section%s of the Focus Pages feature must all be turned green. %s Why? %s If the Snippet elements are Not green, then your Focus Page is not 100%% optimized. %s We've built this SEO Content section especially because we wanted to help you understand that there's a lot more to On-Page SEO than just a content analysis, or a snippet. You need all these elements working together in order to achieve high rankings.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo', array('sid=' . (isset($this->_post->ID) ? $this->_post->ID : ''), 'stype=' . (isset($this->_post->post_type) ? $this->_post->post_type : ''))) . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'onpageseo' => array(
                'title' => __("Platform SEO is green", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Make sure that the Platform SEO section is green for this Focus Page. %s Because WordPress is such a vast CMS with many customization possibilities, it happens to many website owners, business owners and developers, that custom post types from their site remain completely without SEO codes and other important settings. %s This task makes sure that everything is properly set up.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'updates' => array(
                'title' => __("Fresh content update", _SQ_PLUGIN_NAME_),
                'value' => $this->_modified,
                'description' => sprintf(__("Last Update Date for your Content: needs to be in the last 3 months. %s If it's not, then go and edit your page. %s Google prefers pages where the website owners keep updating the content. %s Why? %s Because it's one of the easiest ways to ensure that the content on the page keeps being relevant.", _SQ_PLUGIN_NAME_), self::UPDATEDAT_MAXVAL, '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
//            'practice' => array(
//                'title' => __("Website architecture", _SQ_PLUGIN_NAME_),
//                'description' => sprintf(__("Go to the Best Practices section of Focus Pages and learn about URL Structure (also called Website Architecture). %s It will be a super powerful ranking factor that can get you ranked better than your competitors. Most companies fail at this. You can be the win who does it right and wins big!", _SQ_PLUGIN_NAME_), '<br /><br />'),
//            ),
        );

    }

    /*********************************************/
    public function getHeader() {
        $edit_link = '';
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php');
        if (isset($this->_post->ID)) {
            $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$this->_post->ID . '&action=edit');
            if ($this->_post->post_type <> 'profile') {
                $edit_link = get_edit_post_link($this->_post->ID, false);
            }
        }
        $header .= '<li class="completed">';
        if ($this->_keyword) {
            $header .= '<div class="font-weight-bold text-black-50 mb-2 text-center">' . __('Keyword', _SQ_PLUGIN_NAME_) . ': <strong class="text-info">' . $this->_keyword . '</strong></div>';
            if ((int)$this->_post->ID > 0) {
                $header .= '<button  class="sq_research_selectit btn btn-success text-white col-sm-8 offset-2 my-2" data-post="' . $edit_link . '" data-keyword="' . htmlspecialchars(addslashes($this->_keyword)) . '">' . __('Optimize for this', _SQ_PLUGIN_NAME_) . '</a>';
            }
        } else {
            $header .= '<div class="font-weight-bold text-warning m-0  text-center">' . __('No Keyword Found', _SQ_PLUGIN_NAME_) . '</div>';
            $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank" class="btn btn-success text-white col-sm-8 offset-2 mt-3">' . __('Do a research', _SQ_PLUGIN_NAME_) . '</a>';

            if (isset($this->_post->ID)) {
                $header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 my-2">' . __('Optimize for a keyword', _SQ_PLUGIN_NAME_) . '</a>';
            }
        }
        $header .= '</li>';

        return $header;
    }

    /**
     * Keyword optimization required
     * @param $title
     * @return string
     */
    public function getTitle($title) {
        parent::getTitle($title);

        if ($this->_error && !$this->_keyword) {
            $title = __("Optimize the page for a keyword. Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
        }else {
            foreach ($this->_tasks[$this->_category] as $task) {
                if ($task['completed'] === false) {
                    return __("Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
                }
            }
        }

        return $title;
    }

    /**
     * API Post Optimization
     * @return bool|WP_Error
     */
    public function checkOptimization($task) {
        if ($this->_optimization !== false) {
            $task['completed'] = ($this->_optimization >= self::OPTIMIZATION_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * Call all Snippet functions and make sure they all return true
     * @return bool
     */
    public function checkSnippet($task) {
        $assistant = SQ_Classes_ObjController::getNewClass('SQ_Models_Focuspages_Snippet');
        $assistant->setAudit($this->_audit);
        $assistant->setPost($this->_post);
        $assistant->init();

        $tasks = $assistant->parseTasks($this->_tasks);

        $task['completed'] = true;
        foreach ($tasks['snippet'] as $name => $snippettask) {
            if ($snippettask['completed'] == false) {
                $task['completed'] = false;
            }
        }

        return $task;
    }

    /**
     * Call all Onpage functions and make sure they all return true
     * @return bool
     */
    public function checkOnpageseo($task) {
        /** @var SQ_Models_Focuspages_Onpage $tasks */
        $assistant = SQ_Classes_ObjController::getNewClass('SQ_Models_Focuspages_Onpage');
        $assistant->setAudit($this->_audit);
        $assistant->setPost($this->_post);
        $assistant->init();

        $tasks = $assistant->parseTasks($this->_tasks);

        $task['completed'] = true;
        foreach ($tasks['onpage'] as $name => $onpagetask) {
            if ($onpagetask['completed'] == false) {
                $task['completed'] = false;
            }
        }

        return $task;
    }

    /**
     * Check if the last modified date is less than 3 months
     * @return bool|WP_Error
     */
    public function checkUpdates($task) {
        if ($this->_modified !== false) {
            $task['completed'] = (strtotime($this->_modified) >= (time() - (self::UPDATEDAT_MAXVAL * 30 * 3600 * 24)));
            return $task;
        }

        $task['error'] = true;
        return $task;
    }
}
<?php

class SQ_Models_Bulkseo_Twittercard extends SQ_Models_Abstract_Assistant {

    protected $_category = 'twittercard';

    protected $_title_length;
    protected $_description_length;
    //
    protected $_tw_title;
    protected $_tw_description;
    protected $_tw_media;

    protected $_title_maxlength = 75;
    protected $_description_maxlength = 110;
    protected $_loadpatterns = true;

    const TITLE_MINLENGTH = 10;
    const DESCRIPTION_MINLENGTH = 10;
    const CHARS_ERROR = 5;

    public function init() {
        parent::init();

        $metas = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas')));
        $this->_title_maxlength = (int)$metas->tw_title_maxlength;
        $this->_description_maxlength = (int)$metas->tw_description_maxlength;

        //Get all the patterns
        $this->_patterns = SQ_Classes_Helpers_Tools::getOption('patterns');

        //For post types who are not in automation, add the custom patterns
        if (!isset($this->_patterns[$this->_post->post_type])) {
            $this->_patterns[$this->_post->post_type] = $this->_patterns['custom'];
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') ||
            isset($patterns[$this->_post->post_type]['do_pattern']) && !$this->_patterns[$this->_post->post_type]['do_pattern']) {
            $this->_loadpatterns = false;
        }

        if ($this->_loadpatterns && ($this->_post->sq_adm->tw_title == '' || $this->_post->sq_adm->tw_description == '')) {
            $this->_pattern = true;
        }

        $this->_tw_title = ($this->_post->sq->tw_title <> '' ? $this->_post->sq->tw_title : SQ_Classes_Helpers_Sanitize::truncate($this->_post->sq->title, 10, $this->_post->sq->tw_title_maxlength));
        $this->_tw_description = ($this->_post->sq->tw_description <> '' ? $this->_post->sq->tw_description : SQ_Classes_Helpers_Sanitize::truncate($this->_post->sq->description, 10, $this->_post->sq->tw_description_maxlength));

        $this->_title_length = strlen(html_entity_decode(utf8_decode($this->_tw_title)));
        $this->_description_length = strlen(html_entity_decode(utf8_decode($this->_tw_description)));

        $this->_tw_media = $this->_post->sq->tw_media;
        if ($this->_tw_media == '') {
            $images = SQ_Classes_ObjController::getNewClass('SQ_Models_Services_OpenGraph')->getPostImages();
            if (!empty($images)) {
                $image = current($images);
                if (isset($image['src'])) {
                    $this->_tw_media = $image['src'];
                }
            }
        }
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'title_empty' => array(
                'title' => __("TC title not empty", _SQ_PLUGIN_NAME_),
                'value' => $this->_tw_title,
                'description' => sprintf(__('You need to have a title for the Twitter Card of this post. %s It will help you control the way your post looks when it\'s shared on Twitter. %s It\'s also important for SEO purposes.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'title_length' => array(
                'title' => sprintf(__("TC title up to %s chars", _SQ_PLUGIN_NAME_), $this->_title_maxlength),
                'value' => $this->_title_length . ' ' . __('chars', _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Title has to be longer than %s chars and up to %s chars. %s You can change the title max length from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), self::TITLE_MINLENGTH, $this->_title_maxlength, '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'),
            ),
            'description_empty' => array(
                'title' => __("TC Description not empty", _SQ_PLUGIN_NAME_),
                'value' => $this->_tw_description,
                'description' => sprintf(__('You need to have a Twitter Card description for this post. %s It will help you control the way your post looks when people share this URL on Twitter. Good copywriting on your Twitter Card description will attract more clicks to your site. %s It\'s also important for SEO purposes.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'description_length' => array(
                'title' => sprintf(__("TC description up to %s chars", _SQ_PLUGIN_NAME_), $this->_description_maxlength),
                'value' => $this->_description_length . ' ' . __('chars', _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Description has to be longer than %s chars and up to %s chars. %s You can change the description max length from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), self::DESCRIPTION_MINLENGTH, $this->_description_maxlength, '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'),
            ),
            'image' => array(
                'title' => __("TC Image", _SQ_PLUGIN_NAME_),
                'value' => ($this->_post->sq->tw_media <> '' ? $this->_post->sq->tw_media : ($this->_post->post_attachment <> '' ? __('(featured image)', _SQ_PLUGIN_NAME_) . ' ' . $this->_post->post_attachment : '')),
                'description' => sprintf(__("Set a good looking image for your URL. It needs to look good in Twitter feeds when people will share this URL. %s A great image will attract more clicks to your site.", _SQ_PLUGIN_NAME_), '<br /><br />'),
            ),
        );


    }

    /**
     * Return the Category Tile
     * @param $title
     * @return string
     */
    public function getTitle($title) {
        if ($this->_error) {
            return __("Twitter Card is deactivated.", _SQ_PLUGIN_NAME_);
        }

        foreach ($this->_tasks[$this->_category] as $task) {
            if ($task['completed'] === false) {
                return __("Twitter Card is not set correctly. Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
            }
        }

        if ($this->_pattern) {
            return __("Twitter Card is generated automatically.", _SQ_PLUGIN_NAME_);
        }

        return __("Twitter Card is customized and set correctly.", _SQ_PLUGIN_NAME_);

    }

    /**
     * Show Current Post
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-2">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        return $header;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkTitle_empty($task) {
        $errors = array();
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_twc) {
            $errors[] = sprintf(__("Twitter Card for this post type is deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) {
            $errors[] = sprintf(__("Twitter Card is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) {
            $errors[] = sprintf(__("Social Media is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->tw_title == '') {
            $task['error_message'] = __('Title is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_tw_title <> '');

        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkTitle_length($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_twc) {
            $errors[] = sprintf(__("Twitter Card for this post type is deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) {
            $errors[] = sprintf(__("Twitter Card is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) {
            $errors[] = sprintf(__("Social Media is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->tw_title == '') {
            $task['error_message'] = __('Title is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_title_length > self::TITLE_MINLENGTH && $this->_title_length < ((int)$this->_title_maxlength + self::CHARS_ERROR));

        return $task;
    }

    public function checkDescription_empty($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_twc) {
            $errors[] = sprintf(__("Twitter Card for this post type is deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) {
            $errors[] = sprintf(__("Twitter Card is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) {
            $errors[] = sprintf(__("Social Media is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->tw_description == '') {
            $task['error_message'] = __('Description is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_tw_description <> '');

        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkDescription_length($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_twc) {
            $errors[] = sprintf(__("Twitter Card for this post type is deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) {
            $errors[] = sprintf(__("Twitter Card is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) {
            $errors[] = sprintf(__("Social Media is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->tw_description == '') {
            $task['error_message'] = __('Description is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_description_length > self::DESCRIPTION_MINLENGTH && $this->_description_length < ((int)$this->_description_maxlength + self::CHARS_ERROR));

        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkImage($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_twc) {
            $errors[] = sprintf(__("Twitter Card for this post type is deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) {
            $errors[] = sprintf(__("Twitter Card is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) {
            $errors[] = sprintf(__("Social Media is deactivated from %sSEO Settings > Social Media%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }


        $task['completed'] = ($this->_tw_media <> '');

        return $task;

    }


}
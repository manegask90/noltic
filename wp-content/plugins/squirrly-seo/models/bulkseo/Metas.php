<?php

class SQ_Models_Bulkseo_Metas extends SQ_Models_Abstract_Assistant {

    protected $_category = 'metas';
    protected $_patterns;

    protected $_title_length;
    protected $_description_length;
    //
    protected $_title_maxlength = 75;
    protected $_description_maxlength = 255;
    protected $_keyword = false;
    protected $_loadpatterns = true;

    const TITLE_MINLENGTH = 10;
    const DESCRIPTION_MINLENGTH = 10;
    const CHARS_ERROR = 5;

    public function init() {
        parent::init();

        $metas = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas')));
        $this->_title_maxlength = (int)$metas->title_maxlength;
        $this->_description_maxlength = (int)$metas->description_maxlength;

        $this->_keyword = $this->_post->sq->keywords;

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

        $this->_title_length = strlen(html_entity_decode(utf8_decode($this->_post->sq->title)));
        $this->_description_length = strlen(html_entity_decode(utf8_decode($this->_post->sq->description)));

    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'title_empty' => array(
                'title' => sprintf(__("Title not empty", _SQ_PLUGIN_NAME_), '<br /><br />'),
                'value_title' => __('Current Title', _SQ_PLUGIN_NAME_) . ': ',
                'value' => $this->_post->sq->getClearedTitle(),
                'description' => sprintf(__("The title for this URL must not be empty. %s Write a title for this page. The title is very important because it shows up in the browser tab and in the Google listing for your page. %s The better you write the title, the more clicks you can get when people find your page on search engines.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'title_length' => array(
                'title' => sprintf(__("Title up to %s chars", _SQ_PLUGIN_NAME_), $this->_title_maxlength),
                'value_title' => __('Current Title Length', _SQ_PLUGIN_NAME_) . ': ',
                'value' => $this->_title_length . ' ' . __('chars', _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Title has to be longer than %s chars and up to %s chars. %s You can change the title max length from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), self::TITLE_MINLENGTH, $this->_title_maxlength, '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'),
            ),
            'keyword_title' => array(
                'title' => __("Keyword in title", _SQ_PLUGIN_NAME_),
                'value_title' => __('Squirrly Keyword', _SQ_PLUGIN_NAME_) . ': ',
                'value' => ($this->_keyword <> '' ? $this->_keyword : '<em>' . __("no keywords", _SQ_PLUGIN_NAME_) . '</em>'),
                'description' => sprintf(__('Your keyword must be present in the title of the page. %s It\'s a very important element through which you make sure that you connect the searcher\'s intent to the content on your page. %s If I\'m looking for "buy cheap smartwatch" and you give me a page called "Luna Presentation", I will never click your page. Why? Because I might not know that Luna is a smartwatch designed by VectorWatch. %s "Buy Cheap Smartwatch - Luna by VectorWatch" would be a much better choice for a title.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'description_empty' => array(
                'title' => __("Description not empty", _SQ_PLUGIN_NAME_),
                'value_title' => __('Current Description', _SQ_PLUGIN_NAME_) . ': ',
                'value' => $this->_post->sq->getClearedDescription(),
                'description' => sprintf(__("Meta descriptions are important for SEO on multiple search engines. %s You need to have a meta description for this URL. %s The better you write it, the higher the chances of people clicking on your listing when they find it on search engines.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'description_length' => array(
                'title' => sprintf(__("Description up to %s chars", _SQ_PLUGIN_NAME_), $this->_description_maxlength),
                'value_title' => __('Current Description Length', _SQ_PLUGIN_NAME_) . ': ',
                'value' => $this->_description_length . ' ' . __('chars', _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Description has to be longer than %s chars and up to %s chars. %s You can change the description max length from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), self::DESCRIPTION_MINLENGTH, $this->_description_maxlength, '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'),
            ),
            'keyword_description' => array(
                'title' => __("Keyword in description", _SQ_PLUGIN_NAME_),
                'value_title' => __('Squirrly Keyword', _SQ_PLUGIN_NAME_) . ': ',
                'value' => ($this->_keyword <> '' ? $this->_keyword : '<em>' . __("no keywords", _SQ_PLUGIN_NAME_) . '</em>'),
                'description' => sprintf(__("Same as with the title task. %s If a user reads the description of your page on Google, but cannot find the keyword they searched for in that text, then they'd have very low chances of actually clicking and visiting your page. %s They'd go to the next page ranked on Google for that keyword. %s Think about this: Google itself is trying more and more to display keywords in the description of the pages it brings to TOP 10. It's pretty clear they care a lot about this, because that's what people want to find on the search engine.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'keywords' => array(
                'title' => __("Meta Keywords (2-4 Words)", _SQ_PLUGIN_NAME_),
                'value_title' => __('Meta Keyword', _SQ_PLUGIN_NAME_) . ': ',
                'value' => ($this->_post->sq->keywords <> '' ? $this->_post->sq->keywords : '<em>' . __("no meta keywords", _SQ_PLUGIN_NAME_) . '</em>'),
                'description' => __("Even if Meta keywords are not mandatory for Google, it's important for other search engines to find this meta and to index your post for these keywords.", _SQ_PLUGIN_NAME_),
            ),
            'canonical' => array(
                'title' => sprintf(__("Canonical Link", _SQ_PLUGIN_NAME_), $this->_title_maxlength),
                'value_title' => __('Current Link', _SQ_PLUGIN_NAME_) . ': ',
                'value' => ((isset($this->_post->sq->canonical) && $this->_post->sq->canonical <> '') ? $this->_post->sq->canonical : $this->_post->url),
                'description' => sprintf(__("You don't have to set any canonical link if your post is not copied from another source. %s Squirrly will alert you if your canonical link is not the same with the current post's URL. %s The canonical link is used to tell search engines which URL is the original one. The original is the one that gets indexed and ranked.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
        );


    }

    public function getTitle($title) {
        if ($this->_error) {
            return __("Some Squirrly Metas are deactivated.", _SQ_PLUGIN_NAME_);
        }

        foreach ($this->_tasks[$this->_category] as $task) {
            if ($task['completed'] === false) {
                return __("Some Squirrly Metas are not set correctly. Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
            }
        }

        if ($this->_pattern) {
            return __("Some Squirrly Metas are generated automatically.", _SQ_PLUGIN_NAME_);
        }

        return __("All Squirrly Metas are customized and set correctly.", _SQ_PLUGIN_NAME_);

    }

    /*********************************************/
    /**
     * Show Current Post
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-2">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            if ($this->_keyword) {
                $header .= '<div class="font-weight-bold text-black-50 mt-2 text-left">' . __('Keyword', _SQ_PLUGIN_NAME_) . ': ' . $this->_keyword . '</div>';
            } else {
                $header .= '<div class="font-weight-bold text-warning mt-2 text-left">' . __('No Meta Keyword Found', _SQ_PLUGIN_NAME_) . '</div>';
            }
        }
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

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) {
            $errors[] = sprintf(__("Meta Title is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->title == '') {
            $task['error_message'] = __('Title is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_post->sq->title <> '');

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

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) {
            $errors[] = sprintf(__("Meta Title is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->title == '') {
            $task['error_message'] = __('Title is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_title_length > self::TITLE_MINLENGTH && $this->_title_length < ((int)$this->_title_maxlength + self::CHARS_ERROR));

        return $task;

    }

    public function checkKeyword_title($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) {
            $errors[] = sprintf(__("Meta Title is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            $errors[] = sprintf(__("Meta Keywords is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq->title <> '') {
            $keywords = preg_split('/,/', $this->_keyword);
            if (!empty($keywords)) {
                foreach ($keywords as $keyword) {
                    $title = html_entity_decode(utf8_decode($this->_post->sq->title));
                    $keyword = html_entity_decode(utf8_decode($keyword));
                    if ($keyword <> '' && (SQ_Classes_Helpers_Tools::findStr($title, trim($keyword)) !== false)) {
                        $task['completed'] = true;
                        return $task;
                    }
                }
            }
        }

        $task['completed'] = false;

        return $task;

    }

    public function checkDescription_empty($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) {
            $errors[] = sprintf(__("Meta Description is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->description == '') {
            $task['error_message'] = __('Description is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_post->sq->description <> '');

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

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) {
            $errors[] = sprintf(__("Meta Description is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }


        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->description == '') {
            $task['error_message'] = __('Description is generated automatically.', _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_description_length > self::DESCRIPTION_MINLENGTH && $this->_description_length < ((int)$this->_description_maxlength + self::CHARS_ERROR));

        return $task;
    }

    public function checkKeyword_description($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) {
            $errors[] = sprintf(__("Meta Description is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            $errors[] = sprintf(__("Meta Keywords is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq->description <> '') {
            $keywords = preg_split('/,/', $this->_keyword);

            if (!empty($keywords)) {
                foreach ($keywords as $keyword) {
                    $description = html_entity_decode(utf8_decode($this->_post->sq->description));
                    $keyword = html_entity_decode(utf8_decode($keyword));
                    if ($keyword <> '' && (SQ_Classes_Helpers_Tools::findStr($description,  trim($keyword)) !== false)) {
                        $task['completed'] = true;
                        return $task;
                    }
                }
            }
        }
        $task['completed'] = false;

        return $task;

    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkKeywords($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            $errors[] = sprintf(__("Meta Keywords is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        $keywords = preg_split('/,/', $this->_post->sq->keywords);
        foreach ($keywords as $keyword) {
            if ($keyword <> '' && $this->_strWordCount($keyword) >= 2) {
                $task['completed'] = true;
                return $task;
            }
        }

        $task['completed'] = false;

        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkCanonical($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = __("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical')) {
            $errors[] = sprintf(__("Meta Canonical is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if (isset($this->_post->sq->canonical) && $this->_post->sq->canonical <> '') {
            if (rtrim($this->_post->sq->canonical, '/') <> rtrim($this->_post->url, '/')) {
                $task['completed'] = false;
                return $task;
            }
        }

        $task['completed'] = true;

        return $task;
    }

    private function _strWordCount($string) {
        if (!$count = str_word_count($string)) {
            if (function_exists('mb_split')) {
                @mb_internal_encoding('UTF-8');
                @mb_regex_encoding('UTF-8');

                $words = mb_split('[^\x{0600}-\x{06FF}]', $string);
            } else {
                return 1;
            }

            $count = count((array)$words);
        }
        return $count;
    }

}
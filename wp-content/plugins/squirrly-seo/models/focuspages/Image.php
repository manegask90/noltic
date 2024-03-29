<?php

class SQ_Models_Focuspages_Image extends SQ_Models_Abstract_Assistant {

    protected $_category = 'image';

    protected $_keyword = false;
    protected $_images = array();

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (isset($this->_audit->data->sq_seo_keywords->value) && $this->_audit->data->sq_seo_keywords->value <> '') {
            $this->_keyword = $this->_audit->data->sq_seo_keywords->value;
        }

        if (isset($this->_audit->data->sq_seo_open_graph->value) && $this->_audit->data->sq_seo_open_graph->value <> '') {
            $og = json_decode($this->_audit->data->sq_seo_open_graph->value);
            if (isset($og->image)) {
                $this->_images[] = $og->image;
            }
        }

        if (isset($this->_audit->data->sq_seo_twittercard->value) && $this->_audit->data->sq_seo_twittercard->value <> '') {
            $tc = json_decode($this->_audit->data->sq_seo_twittercard->value);
            if (isset($tc->image)) {
                $this->_images[] = $tc->image;
            }
        }

        if ($this->_post->post_content <> '') {
            @preg_match_all('/<img[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/i', stripslashes($this->_post->post_content), $out);

            if (!empty($out)) {
                if (is_array($out[1]) && count((array)$out[1]) > 0) {
                    foreach ($out[1] as $row) {
                        $this->_images[] = $row;
                        break;
                    }
                }

            }
        }

    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'filename' => array(
                'title' => __("Keyword in filename", _SQ_PLUGIN_NAME_),
                'value' => (!empty($this->_images) ? join('<br />', $this->_images) : ''),
                'penalty' => 5,
                'description' => sprintf(__('Your filename for one of the images in this Focus Page should be: %s keyword.jpg %s Download a relevant image from your page. Change the filename. Then re-upload with the SEO filename and add it your page\'s content again. %s It\'s best to keep this at only one filename which contains the main keyword of the page. %s Why? %s Because Google could consider over-optimization if you used it more than once.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
        );

    }

    /**
     * @param $content
     * @param $task
     * @return string
     */
    public function getHeader() {
        $edit_link = '';
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $header .= '<li class="completed">';
        if ($this->_keyword) {
            $header .= '<div class="font-weight-bold text-black-50 mb-2 text-center">' . __('Keyword', _SQ_PLUGIN_NAME_) . ': <strong class="text-info">' . $this->_keyword . '</strong></div>';
            if (isset($this->_post->ID)) {
                if (isset($this->_post->ID)) {
                    $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo', array('sid=' . $this->_post->ID, 'stype=' . $this->_post->post_type));
                }
                $header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-success text-white col-sm-8 offset-2 mt-3">' . __('Edit your snippet', _SQ_PLUGIN_NAME_) . '</a>';
            }
        } else {
            $header .= '<div class="font-weight-bold text-warning m-0 text-center">' . __('No Keyword Found', _SQ_PLUGIN_NAME_) . '</div>';
            $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank" class="btn btn-success text-white col-sm-8 offset-2 mt-3">' . __('Do a research', _SQ_PLUGIN_NAME_) . '</a>';
            if (isset($this->_post->ID)) {
                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$this->_post->ID . '&action=edit');
                if ($this->_post->post_type <> 'profile') {
                    $edit_link = get_edit_post_link($this->_post->ID, false);
                }
                $header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-3">' . __('Optimize for a keyword', _SQ_PLUGIN_NAME_) . '</a>';
            }
        }

        $header .= '</li>';

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
    /*********************************************/

    /**
     * Check if the keyword is in the file name | API keyword in filename
     * @return bool
     */
    public function checkFilename($task) {
        $task['completed'] = false;

        if (!$this->_keyword) {
            $this->_tasks[$this->_category]['filename']['description'] = sprintf(__('Optimize the post first using a Keyword from Squirrly Briefcase', _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') . '" target="_blank">', '</a>');
            $task['error_message'] = __("No image found", _SQ_PLUGIN_NAME_);
            $task['completed'] = false;
        } elseif (!empty($this->_images)) {
            $keyword = html_entity_decode(utf8_decode($this->_keyword));
            $keyword = preg_replace('/[^a-zA-Z0-9\']/', ' ', $keyword);
            $keyword = preg_replace('/\s{2,}/', ' ', $keyword);
            $words = explode(' ', $keyword);
            foreach ($this->_images as $image) {
                //Check if all words are present in the image URL
                $allwords = true;
                foreach ($words as $word) {
                    if (SQ_Classes_Helpers_Tools::findStr($image, $word) === false) {
                        $allwords = false;
                    }
                }

                //Complete task if all words are found
                if ($allwords) {
                    $task['completed'] = true;
                    break;
                }
            }
        }

        return $task;
    }

}
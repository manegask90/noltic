<?php

abstract class SQ_Models_Abstract_Assistant {

    /** @var object API audit for this page */
    protected $_audit;
    /** @var SQ_Models_Domain_Post The local data aboud the post */
    protected $_post;
    /** @var array Current Category tasks */
    protected $_tasks;
    /** @var string Task Category Name */
    protected $_category;
    /** @var array DB tasks signals */
    protected $_dbtasks;
    /** @var bool task statuses */
    protected $_error = false;
    protected $_completed = true;
    protected $_pattern = false;
    protected $_error_message = false;

    /** @var string Task colors */
    const TASK_COMPLETE = '#20bc49';
    const TASK_INCOMPLETE = '#dd3333';
    const TASK_OBCURE = '#f1d432';
    const TASK_ERROR = '#dddddd';
    const TASK_PATTERN = '#20bc49';

    public function setAudit($audit) {
        $this->_audit = $audit;

        return $this;
    }

    public function setPost($post) {
        $this->_post = $post;

        return $this;
    }

    /**
     * Get all the focus pages data
     */
    public function init() {
        //get data from DB with the completed tasks
        $this->_dbtasks = json_decode(get_option(SQ_TASKS), true);

        //Add filters for tasks, color and value
        add_filter('sq_assistant_tasks', array($this, 'parseTasks'));

        //parse the category
        add_filter('sq_assistant_categories', array($this, 'parseCategory'));

    }


    /**
     * Set all Tasks from all Assistant Classes
     * Extend and add the current assistant tasks
     * @param $tasks
     * @return mixed
     */
    public function setTasks($tasks) {
        return $this->_tasks = $tasks;
    }

    /**
     * Get all tasks
     * @return mixed
     */
    public function getTasks() {
        return $this->_tasks;
    }

    /**
     * Get all saved statuses from database
     * @return array
     */
    public function getDbTasks() {
        return $this->_dbtasks;
    }

    /**
     * Get the task value if exists
     * Set false by default
     * @return bool
     */
    public function getValue() {
        return false;
    }

    /**
     * If data integrity is affected, return error
     * @return bool
     */
    public function isError() {
        return $this->_error;
    }

    /**
     * Get the task color
     * @param $completed
     * @return string
     */
    public function getColor($completed) {
        if ($this->_error) {
            return self::TASK_ERROR;
        } elseif (!$completed) {
            return self::TASK_INCOMPLETE;
        } elseif ($this->_pattern) {
            return self::TASK_PATTERN;
        } elseif ($completed) {
            return self::TASK_COMPLETE;
        }

        return self::TASK_INCOMPLETE;
    }

    public function getTitle($title) {
        if ($this->_error) {
            $title = __("We are gathering data for this category", _SQ_PLUGIN_NAME_);
        }
        return $title;
    }

    /**
     * Parse tasks for each category
     * @param $tasks
     * @param $category
     * @return mixed
     */
    public function parseTasks($tasks, $category = null) {

        if (!isset($category)) {
            $category = $this->_category;
        }
        //$this->_error = false;

        $this->setTasks($tasks);

        if (isset($this->_tasks[$category])) {
            foreach ($this->_tasks[$category] as $name => &$task) {

                $task['completed'] = true;
                $task['pattern'] = $task['error'] = $task['error_message'] = false;

                //Set task status from DB or active
                $task['active'] = true;
                if (isset($this->_dbtasks[$category][$name]['active'])) {
                    $task['active'] = $this->_dbtasks[$category][$name]['active'];
                }
                ///

                //set the current task
                if ($task['active']) {
                    if (method_exists($this, 'check' . ucfirst($name))) {
                        $task = @call_user_func_array(array($this, 'check' . ucfirst($name)), array($task));

                        //Check if the task has errors
                        if ($task['error']) {
                            $task['completed'] = false;
                            $task['error_message'] = (isset($task['error_message']) && $task['error_message'] <> '' ? $task['error_message'] : __("Not enough data to process this task", _SQ_PLUGIN_NAME_));
                        } else {
                            //If the task has value
                            if (isset($task['value'])) {
                                $task['description'] = '<div class="pb-3 mb-3 border-bottom text-info font-italic" style="word-break: break-word !important;">' . (isset($task['value_title']) ? $task['value_title'] : __('Current', _SQ_PLUGIN_NAME_)) . ': <strong>' . $task['value'] . '</strong></div>' . $task['description'];
                            }

                            //Check if the task has patterns
                            if ($task['pattern']) {
                                $this->_pattern = true;
                            }
                        }

                    }
                } else {
                    //set complete if task inactive
                    $task['completed'] = true;
                    $this->_error = $task['error'] = $task['pattern'] = false;
                    $task['error_message'] = __('You chose to ignore this task. Click to activate it.', _SQ_PLUGIN_NAME_);
                }


                if (!isset($task['status'])) {
                    $task['status'] = ($task['active'] ? ($task['error'] ? ' error' : ($task['completed'] ? ($task['pattern'] ? 'pattern' : 'completed') : '')) : 'ignore');
                }

            }

        }

        //Save the completed Tasks in DB
        $this->saveDBTasks();

        //Get the DbTasks
        add_filter('sq_assistant_dbtasks', array($this, 'getDbTasks'));


        //return all tasks
        return $this->getTasks();

    }


    /**
     * Parse all the categories for this page
     * Get status data for each category
     * @param $categories
     * @return mixed
     */
    public function parseCategory($categories) {
        if (!isset($categories[$this->_category])) {
            $categories[$this->_category]['completed'] = true;
            $categories[$this->_category]['title'] = '';
            $categories[$this->_category]['penalty'] = 0; //initialize the category penality to 0

            foreach ($this->_tasks[$this->_category] as $task) {
                if ($task['active']) {
                    if (!$task['completed']) {
                        $categories[$this->_category]['completed'] = false;
                        $this->_completed = false;
                    }
                    if ($task['error']) {
                        $categories[$this->_category]['error'] = true;
                        $this->_error = true;
                        break;
                    }

                    if (!$task['completed'] && !$task['error'] && isset($task['penalty'])) {
                        $categories[$this->_category]['penalty'] += (int)$task['penalty'];
                    }
                }
            }
            $categories[$this->_category]['color'] = $this->getColor($categories[$this->_category]['completed']);
            $categories[$this->_category]['title'] = $this->getTitle($categories[$this->_category]['title']);
            $categories[$this->_category]['value'] = $this->getValue();
            $categories[$this->_category]['error'] = $this->isError();

            if (method_exists($this, 'getHeader')) {
                $categories[$this->_category]['header'] = call_user_func(array($this, 'getHeader'));
            }

        }
        return $categories;
    }

    /**
     * Modify task for best practice
     * @param $content
     * @param $task
     * @return string
     */
    public function getPractice($content, $task) {
        return '<li class="sq_task sq_practice row completed"   data-category="' . $this->_category . '" data-name="practice" data-active="' . $task['active'] . '" data-completed="' . $task['completed'] . '" data-dismiss="modal">
                            <i class="fa fa-warning"></i>
                            <h4>' . $task['title'] . '</h4>
                            <div class="description" style="display: none">' . $task['description'] . '</li>';
    }

    /**
     * Save the completed tasks in DB
     */
    public function saveDBTasks() {
        update_option(SQ_TASKS, json_encode($this->_dbtasks));
    }

}
<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Ranking extends SQ_Classes_FrontController {

    public $info;
    public $ranks;
    public $serps;

    /** @var object Checkin process with Squirrly Cloud */
    public $checkin;

    function init() {
        //Clear the Scripts and Styles from other plugins
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->clearStyles();

        //Checkin to API V2
        $this->checkin = SQ_Classes_RemoteController::checkin();

        if (is_wp_error($this->checkin)) {
            if($this->checkin->get_error_message() == 'no_data') {
                echo $this->getView('Errors/Error');
                return;
            }elseif($this->checkin->get_error_message() == 'maintenance') {
                echo $this->getView('Errors/Maintenance');
                return;
            }
        }

        $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'rankings');

        if (method_exists($this, $tab)) {
            call_user_func(array($this, $tab));
        }

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        if(is_rtl()){
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('popper');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap.rtl');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        }else{
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        }
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('datatables');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rankings');

        //@ob_flush();
        echo $this->getView('Ranking/' . ucfirst($tab));

        //get the modal window for the assistant popup
        echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getModal();

    }

    /**
     * Call the rankings
     */
    public function rankings() {
        add_action('sq_form_notices', array($this,'getNotificationBar'));

        $days_back = (int)SQ_Classes_Helpers_Tools::getValue('days_back', 30);

        $args = array();
        $args['days_back'] = $days_back;
        $args['keyword'] = (string)SQ_Classes_Helpers_Tools::getValue('skeyword', '');
        $args['has_change'] = (string)SQ_Classes_Helpers_Tools::getValue('schanges', '');
        $args['has_ranks'] = (string)SQ_Classes_Helpers_Tools::getValue('ranked', '');


        if ($this->info = SQ_Classes_RemoteController::getRanksStats($args)) {
            if (is_wp_error($this->info)) {
                $this->info = array();
            }
        }

        if ($this->ranks = SQ_Classes_RemoteController::getRanks($args)) {
            if (is_wp_error($this->ranks)) {
                SQ_Classes_Error::setError(__('Could not load the Rankings.', _SQ_PLUGIN_NAME_));
                $this->ranks = array();
            }
        }
    }

    public function gscsync() {
        $args = array();
        $args['max_results'] = '100';
        $args['max_position'] = '30';

        if ($this->suggested = SQ_Classes_RemoteController::syncGSC($args)) {
            if (is_wp_error($this->suggested)) {
                SQ_Classes_Error::setError(__('Could not load data.', _SQ_PLUGIN_NAME_));
                $this->suggested = array();
            }
        }

        //Get the briefcase keywords
        if ($briefcase = SQ_Classes_RemoteController::getBriefcase()) {
            if (!is_wp_error($briefcase)) {
                if (isset($briefcase->keywords)) {
                    $this->keywords = $briefcase->keywords;
                }
            }
        }
    }

    /**
     * Called when action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();

        if (!current_user_can('sq_manage_focuspages')) {
            return;
        }

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {

            case 'sq_ranking_settings':
                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //Save the settings on API too
                $args = array();
                $args['sq_google_country'] = SQ_Classes_Helpers_Tools::getValue('sq_google_country');
                $args['sq_google_language'] = 'en';
                SQ_Classes_RemoteController::saveSettings($args);
                ///////////////////////////////

                //show the saved message
                SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));

                break;
            case 'sq_serp_refresh_post':
                $keyword = SQ_Classes_Helpers_Tools::getValue('keyword', false);
                if ($keyword) {
                    $args = array();
                    $args['keyword'] = $keyword;
                    if (SQ_Classes_RemoteController::checkPostRank($args) === false) {
                        SQ_Classes_Error::setError(sprintf(__('Could not refresh the rank. Please check your SERP credits %shere%s', _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('account') . '">', '</a>'));
                    } else {
                        SQ_Classes_Error::setMessage(sprintf(__('%s is queued and the rank will be checked soon.', _SQ_PLUGIN_NAME_), '<strong>' . $keyword . '</strong>'));
                    }
                }

                break;
            case 'sq_serp_delete_keyword':
                $keyword = SQ_Classes_Helpers_Tools::getValue('keyword', false);

                if ($keyword) {
                    $response = SQ_Classes_RemoteController::deleteSerpKeyword(array('keyword' => $keyword));
                    if (!is_wp_error($response)) {
                        SQ_Classes_Error::setError(__('The keyword is deleted', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                    } else {
                        SQ_Classes_Error::setError(__('Could not delete the keyword!', _SQ_PLUGIN_NAME_) . " <br /> ");
                    }
                } else {
                    SQ_Classes_Error::setError(__('Invalid params!', _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;
            case 'sq_ajax_rank_bulk_delete':
                SQ_Classes_Helpers_Tools::setHeader( 'json' );
                $inputs = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

                if ( ! empty( $inputs ) ) {
                    foreach ( $inputs as $keyword ) {
                        if ( $keyword <> '' ) {
                            $args            = array();
                            $args['keyword'] = $keyword;
                            SQ_Classes_RemoteController::deleteSerpKeyword($args);
                        }
                    }

                    echo json_encode( array( 'message' => __( 'Deleted!', _SQ_PLUGIN_NAME_ ) ) );
                } else {
                    echo json_encode( array( 'error' => __( 'Invalid params!', _SQ_PLUGIN_NAME_ ) ) );
                }
                exit();
            case 'sq_ajax_rank_bulk_refresh':
                SQ_Classes_Helpers_Tools::setHeader( 'json' );
                $inputs = SQ_Classes_Helpers_Tools::getValue( 'inputs', array() );

                if ( ! empty( $inputs ) ) {
                    foreach ( $inputs as $keyword ) {
                        if ( $keyword <> '' ) {
                            $args            = array();
                            $args['keyword'] = $keyword;
                            SQ_Classes_RemoteController::checkPostRank($args);
                        }

                        echo json_encode( array( 'message' => __( 'Sent!', _SQ_PLUGIN_NAME_ ) ) );
                    }
                } else {
                    echo json_encode( array( 'error' => __( 'Invalid params!', _SQ_PLUGIN_NAME_ ) ) );
                }
                exit();

        }
    }

    public function getScripts() {
        return '<script type="text/javascript">
               function drawChart(id, values, reverse) {
                    var data = google.visualization.arrayToDataTable(values);

                    var options = {

                        curveType: "function",
                        title: "",
                        chartArea:{width:"100%",height:"100%"},
                        enableInteractivity: "true",
                        tooltip: {trigger: "auto"},
                        pointSize: "2",
                        colors: ["#55b2ca"],
                        hAxis: {
                          baselineColor: "transparent",
                           gridlineColor: "transparent",
                           textPosition: "none"
                        } ,
                        vAxis:{
                          direction: ((reverse) ? -1 : 1),
                          baselineColor: "transparent",
                          gridlineColor: "transparent",
                          textPosition: "none"
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById(id));
                    chart.draw(data, options);
                    return chart;
                }
          </script>';
    }

}

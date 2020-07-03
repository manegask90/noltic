<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockFocusPages extends SQ_Classes_BlockController {
    public $focuspages;

    public function hookGetContent() {
        if ($focuspages = SQ_Classes_RemoteController::getFocusPages()) {
            //Get the audits for the focus pages
            $audits = SQ_Classes_RemoteController::getFocusAudits();

            if (!empty($focuspages)) {
                foreach ($focuspages as $focuspage) {
                    //Add the audit data if exists
                    if (isset($focuspage->user_post_id) && !empty($audits)) {
                        foreach ($audits as $audit) {
                            if ($focuspage->user_post_id == $audit->user_post_id) {
                                $audit = json_decode($audit->audit);
                                if (isset($audit->properties) && isset($audit->properties->created_at->date)) {
                                    $focuspage->audit_datetime = date(get_option('date_format') . ' ' . get_option('time_format'), strtotime($audit->properties->created_at->date));
                                } else {
                                    $focuspage->audit_datetime = __('Audit in progress', _SQ_PLUGIN_NAME_);
                                }
                            }
                        }
                    }

                    /** @var SQ_Models_Domain_FocusPage $focuspage */
                    $this->focuspages[] = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_FocusPage', $focuspage);

                }
            }
        }
        echo $this->getView('Blocks/FocusPages');
    }

    public function getScripts() {
        return '<script>
               function drawChart(id, values, reverse) {
                    var data = google.visualization.arrayToDataTable(values);

                    var options = {

                      title : "",
                      chartArea:{width:"80%",height:"70%"},
                      vAxis: {title: "",
                            viewWindowMode:"explicit",
                            viewWindow: {
                              max:100,
                              min:0
                            }},
                      hAxis: {title: ""},
                      seriesType: "bars",
                      series: {2: {type: "line"}},
                      legend: {position: "bottom"},
                      colors:["#17c6ea","#fb3b47"]
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById(id));
                    chart.draw(data, options);
                    return chart;
                }
          </script>';
    }
}

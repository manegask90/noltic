<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockRanks extends SQ_Classes_BlockController {
    public $info;
    public $ranks;


    public function hookGetContent() {
        $args = array();
        $args['days_back'] = 7;
        $args['has_ranks'] = 1;


        if ($this->info = SQ_Classes_RemoteController::getRanksStats($args)) {
            if (is_wp_error($this->info)) {
                $this->info = array();
            }
        }
        if ($this->ranks = SQ_Classes_RemoteController::getRanks($args)) {
            if (is_wp_error($this->ranks)) {
                $this->ranks = array();
            }
        }

        echo $this->getView('Blocks/Ranks');
    }

    public function getScripts() {
        return '<script>
               function drawChart(id, values, reverse) {
                    var data = google.visualization.arrayToDataTable(values);

                    var options = {

                        curveType: "function",
                        title: "",
                        chartArea:{width:"80%",height:"70%"},
                        enableInteractivity: "true",
                        tooltip: {trigger: "auto"},
                        pointSize: "4",
                        colors: ["#55b2ca"],
                        hAxis: {
                          baselineColor: "#55b2ca",
                           gridlineColor: "#55b2ca",
                           textPosition: "out"
                        } ,
                        vAxis:{
                          direction: ((reverse) ? -1 : 1),
                          baselineColor: "#f8f8f8",
                          gridlineColor: "#f8f8f8",
                          textPosition: "out"
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById(id));
                    chart.draw(data, options);
                    return chart;
                }
          </script>';
    }
}

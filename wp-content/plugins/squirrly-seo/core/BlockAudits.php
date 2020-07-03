<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockAudits extends SQ_Classes_BlockController {
    public $audits;
    public $tasks;
    //
    public $title = true;

    public function hookGetContent() {
        $this->audits = SQ_Classes_RemoteController::getBlogAudits();
        echo $this->getView('Blocks/Audits');
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

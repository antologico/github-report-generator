<?php

namespace GithubReportGenerator;

class HTMLReportGenerator
{
  private ReportFeature $features[];
  private $name = "";

  public function __construct($name, ReportFeature [] $features)
  {
    $this->name = $name;
    $this->features = $features;
  }

  public function generateReport($file)
  {
    $body = "<h1>" . $this->name . "</h1>";

    $body_list = "";
    $reports_details = "";
    foreach ($this->features as $feature) {
      $body_list .= "<li>" . htmlentities($feature->name) . "</li>";

      $reports_details .= '<hr />' .
          '<a id="' . $feature->id . '"></a>' .
          '<h2>' . htmlentities($feature->name) . '</h2>'
          '<div>' . $feature->description . '</div>';
    }

    $body .= "<ul>" . $body_list . "</ul>";
    $body .= "<hr>";
    $body .= $reports_details;

    $html = "<html><head><title>" .
            htmlentities($this->name) .
            "</title><body>" .
            htmlentities($body) . "</body></html>";

    file_set_contents($file, $html);
  }
}

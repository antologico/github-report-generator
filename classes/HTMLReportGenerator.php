<?php

namespace GithubReportGenerator;

class HTMLReportGenerator
{
  private $features = [];
  private $name = "";
  private $cssFile = null;

  public function __construct($name, $cssFile, $features = [])
  {
    $this->name = $name;
    $this->cssFile = $cssFile;
    $this->features = $features;
  }

  public function generateReport($file)
  {
    $body_list = "";
    $reports_details = "";
    foreach ($this->features as $feature) {
      $body_list .= '<li><a href="#' . $feature->id . '"><b>' .
        htmlentities($feature->name) . '</b></a></li>';

      $reports_details .= '<a id="' . $feature->id . '"></a>' .
          '<h2>' . htmlentities($feature->name) . '</h2>' .
          '<div class="feature">' . $feature->description . '</div><hr/>';
    }

    $body  = '<h1 class="title">' . $this->name . '</h1><hr />';
    $body .= '<ul>' . $body_list . '</ul>';
    $body .= '<hr>';
    $body .= $reports_details;

    $cssLink = (is_null($this->cssFile) ? '' :
            '<link href="' . $this->cssFile . '" rel="stylesheet" />');
    $html = '<html><head><title>' .
            htmlentities($this->name) .
            '</title>' . $cssLink . '</head><body>' .
            $body . '</body></html>';

    file_put_contents($file, $html);
  }
}

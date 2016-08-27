<?php

namespace GithubReportGenerator;

class ReportGeneratorBase {

  private $debug = false;

  public function setDebug($activate)
  {
    $this->debug = $activate;
  }

  protected function debug ($value)
  {
    if ($this->debug) {
      if (is_array($value) || is_object($value))
      {
        $value = json_encode($value, JSON_PRETTY_PRINT);
      }
      print $value;
      echo "\n";
    }
  }
}

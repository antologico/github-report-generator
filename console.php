<?php

include_once 'classes/VersionReportGenerator.php';
include_once 'classes/HTMLReportGenerator.php';
include_once 'classes/ReportFeature.php';

use GithubReportGenerator\VersionReportGenerator;
use GithubReportGenerator\HTMLReportGenerator;
use GithubReportGenerator\ReportFeature;

try {

  $params = [
    'username'   => null,
    'password'   => null,
    'repository' => null,
    'branch'     => null,
    'file'       => null,
    'css'        => null
  ];

  echo "\n [i] usage : php console.php --user=userName\n" .
         "                             --password=password\n" .
         "                             --repository=reportName\n" .
         "                             --branch=branchName\n" .
         "                             --file=report.html\n" .
         "                             --css=css-sample.css\n\n";

  if (count($argv) - 1 != count($params)) {
    throw new \Exception("Incorrect number of params", 1);
  }

  for ($i = 1; $i<count($argv); $i++) {

    $param = str_replace("--", "", $argv[$i]);
    $param = explode("=", $param);
    if (count($param) !=2 ) {
      throw new \Exception("Param <" . $argv[$i] . "> defined incorrectly", 1);
    }
    if (array_key_exists($param[0], $params)) {
      $params[$param[0]] = $param[1];
    } else {
      throw new \Exception("Error processing param <" .$param[0]. ">", 1);
    }
  }

  $report = new VersionReportGenerator($params['username'], $params['password']);
  $report->setDebug(false);
  $report->testCredentials();
  $results = $report->getPulls($params['repository'], $params['branch']);

  $features = [];
  foreach (json_decode($results) as $result) {
    $features[] = new ReportFeature($result->id, $result->title, $result->body);
  }

  $htmlFile = new HTMLReportGenerator($params['branch'], $params['css'], $features);
  $htmlFile->generateReport($params['file']);
  echo "\n [i] Correctly finish\n\n";

} catch(\Exception $e) {
  echo '[!] ' . $e->getMessage();
  echo "\n";
}

echo "\n";

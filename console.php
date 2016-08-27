<?php

include_once 'classes/VersionReportGenerator.php';

use GithubReportGenerator\VersionReportGenerator;

try {

  $params = [
    'username'   => null,
    'password'   => null,
    'repository' => null,
    'branch'     => null,
  ];
var_dump($params);

  echo "\ncall  :  'php console.php --user=userName --password=password --repository=reportName --branch=branchName'\n\n";

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
  $results = $report->getPulls($params['username'], $params['repository'], $params['branch']);

  print_r($results);

} catch(\Exception $e) {
  echo '[!] ' . $e->getMessage();
  echo "\n";
}

echo "\n";

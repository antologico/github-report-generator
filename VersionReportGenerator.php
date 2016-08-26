<?php

namespace GithubReportGenerator;

include 'ReportGeneratorBase.php';

class VersionReportGenerator extends ReportGeneratorBase
{
  private $client_id = null;
  private $client_token = null;
  private $file = null;
  private $repository = null;

  private $GIT_HUB_API = 'https://api.github.com/';

  public function VersionReportGenerator($repository, $client_id = null, $client_token = null, $file = null)
  {
    $this->repository = $repository;
    if (!is_null($client_id) && !is_null($client_token)) {
      $this->sendCredentilas($client_id, $client_token);
    }
    $this->file = $file;
  }

  public function setCredentials($client_id = null, $client_token=null)
  {
    $this->client_id = $client_id;
    $this->client_token = $client_token;
  }

  public function testCredentials($client_id=null, $client_token=null)
  {
    $this->client_id     = is_null($client_id) ? $this->client_id : $client_id;
    $this->client_token = is_null($client_token) ? $this->client_token : $client_token;
    if (is_null($this->client_token) || is_null($this->client_id)) {
      throw new \Exception ('Credentials not defined');
    }
    $this->curl('user');
    return true;
  }

  private function curl($petition) {
    // create curl resource
    $curl = curl_init($this->GIT_HUB_API. $petition);
    curl_setopt($curl, CURLOPT_USERPWD, $this->client_id . ':' . $this->client_token);
    curl_setopt($curl, CURLOPT_USERAGENT,'Googlebot/2.1 (+http://www.google.com/bot.html)');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $this->debug('Sending credentials...');
    $result = curl_exec($curl);
    if ($result == false) {
      throw new \Exception ('Bad credentials: ' . curl_error($curl));
    }
    $this->debug(json_decode($result));
    curl_close($curl);

    return $result;
  }

  public function generateReport($file = null)
  {
      $file = is_null($file) ? $this->file : $file;
      if (!is_null($file)) {
         $file = is_null($file);
      } else {
        throw new \Exception ('Destiny file not expecified');
      }
  }

}

try {
  $report = new VersionReportGenerator('github-report-generator');
  $report->setDebug(true);
  $report->testCredentials('antoniojuansanchez', 'e33fbde1dbff67197bf3d9dab72a432a0945a62f');
} catch(\Exception $e) {
  echo $e->getMessage();
}

echo "\n";

?>

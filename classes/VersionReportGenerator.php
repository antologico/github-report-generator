<?php

namespace GithubReportGenerator;

include 'ReportGeneratorBase.php';

class VersionReportGenerator extends ReportGeneratorBase
{
  private $client_id = null;
  private $client_token = null;
  private $file = null;

  private $GIT_HUB_API = 'https://api.github.com/';

  public function __construct($client_id = null, $client_token = null, $file = null)
  {
    if (!is_null($client_id) && !is_null($client_token)) {
      $this->setCredentials($client_id, $client_token);
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
    $this->curl($this->replace('users/:user',
      [':user' => $this->client_id]));
    return true;
  }

  public function getPulls($owner, $repository, $branch)
  {
    return $this->curl($this->replace(
      'repos/:owner/:repo/pulls?state=all&base=:branch', [
        ':repo' => $repository,
        ':owner' => $owner,
        ':branch' => $branch
      ])
    );
  }

  private function replace($string, $array)
  {
    foreach ($array as $key => $value) {
      $string = str_replace ($key, $value, $string);
    }
    return $string;
  }

  private function curl($petition) {
    // create curl resource
    $curl = curl_init($this->GIT_HUB_API. $petition);
    curl_setopt($curl, CURLOPT_USERPWD, $this->client_id . ':' . $this->client_token);
    curl_setopt($curl, CURLOPT_USERAGENT,'Googlebot/2.1 (+http://www.google.com/bot.html)');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $this->debug('Sending petition... ('. $this->client_id . ') ' . $petition);
    $result = curl_exec($curl);

    if ($result == false) {
      throw new \Exception ('Bad credentials: ' . curl_error($curl));
    } else {
      $this->debug(json_decode($result));
      curl_close($curl);
      return $result;
    }
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

<?php

namespace PHPClassic;

/**
 * Curl HTTP request wrapper
 *
 * @author Jonas Sciangula <joni2back {at} gmail.com>
 */
class Curly
{
    protected $handler;
    protected $url;
    protected $response;
    protected $responseHeaders = array();
    protected $method = 'GET';
    protected $port = 80;
    protected $headers = array();
    protected $postParams = array();
    protected $getParams = array();
    protected $followRedirects = true;

    /**
     * @param string $url
     * @throws \ErrorException
     */
    public function __construct($url = null)
    {
        if (! function_exists('curl_init')) {
            throw new \ErrorException('Curl library is not enabled');
        }
        $this->setUrl($url);
        $this->handler = curl_init($this->url);
    }

    /**
     * @param string $url
     * @return \PHPClassic\Curly
     */
    public function setUrl($url = null)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param bool $mode
     */
    public function setFollowRedirects($mode)
    {
        $this->followRedirects = (bool) $mode;
    }

    /**
     * @param string $method
     * @return \PHPClassic\Curly
     */
    public function setMethod($method)
    {
        $allowedMethods = array('GET', 'POST', 'DELETE', 'PUT');
        if (in_array($method, $allowedMethods)) {
            $this->method = $method;
        }
        return $this;
    }

    /**
     * @param array $params
     * @return \PHPClassic\Curly
     */
    public function setGetParams(array $params)
    {
        $this->getParams = $params;
        return $this;
    }

    /**
     * @param array $params
     * @return \PHPClassic\Curly
     */
    public function setPostParams(array $params)
    {
        $this->postParams = $params;
        return $this;
    }

    /**
     * @param array $headers
     * @return \PHPClassic\Curly
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param int $port
     * @return \PHPClassic\Curly
     */
    public function setPort($port)
    {
        $this->port = (int) $port;
        return $this;
    }

    /**
     * @return \PHPClassic\Curly
     */
    protected function configure()
    {
        $getParams = '?' . http_build_query($this->getParams);
        $postParams = http_build_query($this->postParams);

        curl_setopt($this->handler, CURLOPT_URL, $this->url . $getParams);
        curl_setopt($this->handler, CURLOPT_PORT, $this->port);
        curl_setopt($this->handler, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($this->handler, CURLOPT_POSTFIELDS, $postParams);
        curl_setopt($this->handler, CURLOPT_FOLLOWLOCATION, $this->followRedirects);
        curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handler, CURLOPT_HEADER, true);
        return $this;
    }

    /**
     * @return \PHPClassic\Curly
     */
    public function execute()
    {
        $this->configure();
        $response = curl_exec($this->handler);
        $headerSize = curl_getinfo($this->handler, CURLINFO_HEADER_SIZE);
        $this->responseHeaders = substr($response, 0, $headerSize);
        $this->response = substr($response, $headerSize);
        return $this;
    }

    /**
     * @return array
     */
    public function getResponseHeaders()
    {
        return explode("\n", trim($this->responseHeaders));
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

}
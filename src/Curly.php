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
    protected $responseHeaders;
    protected $method = 'GET';
    protected $port = 80;
    protected $headers = array();
    protected $postParams = array();
    protected $getParams = array();
    protected $followRedirect = true;
    protected $options = array();
    public static $allowedMethods = array(
        'OPTIONS', 'GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'TRACE', 'CONNECT'
    );

    /**
     * @param string $url
     * @throws \ErrorException
     */
    public function __construct($url = null)
    {
        if (! function_exists('curl_init')) {
            throw new \ErrorException('Curl library is not enabled');
        }
        $this->handler = curl_init();
        $this->setUrl($url);
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
    public function setFollowRedirect($mode)
    {
        $this->followRedirect = (bool) $mode;
    }

    /**
     * @param string $method
     * @return \PHPClassic\Curly
     */
    public function setMethod($method)
    {
        if (in_array(strtoupper($method), self::$allowedMethods)) {
            $this->method = strtoupper($method);
        }
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
     * @param array $params
     * @return \PHPClassic\Curly
     */
    public function setGetParams(array $params = array())
    {
        $this->getParams = $params;
        return $this;
    }

    /**
     * @param array $params
     * @return \PHPClassic\Curly
     */
    public function setPostParams(array $params = array())
    {
        $this->postParams = $params;
        return $this;
    }

    /**
     * @param array $headers
     * @return \PHPClassic\Curly
     */
    public function setHeaders(array $headers = array())
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param array $files
     * @return \PHPClassic\Curly
     */
    public function setFiles(array $files = array())
    {
        $files = array_map(function($file) {
            return sprintf('@%s', realpath($file));
        }, $files);
        $this->setPostParams($files);
        return $this;
    }

    /**
     * @param array $params
     * @return \PHPClassic\Curly
     */
    public function addGetParams(array $params = array())
    {
        $this->getParams = array_merge($params, $this->getParams);
        return $this;
    }

    /**
     * @param array $params
     * @return \PHPClassic\Curly
     */
    public function addPostParams(array $params = array())
    {
        $this->postParams = array_merge($params, $this->postParams);
        return $this;
    }

    /**
     * @param array $params
     * @return \PHPClassic\Curly
     */
    public function addHeaders(array $headers = array())
    {
        $this->headers = array_merge($headers, $this->headers);
        return $this;
    }

    /**
     * @param array $files
     * @return \PHPClassic\Curly
     */
    public function addFiles(array $files = array())
    {
        $files = array_map(function($file) {
            return sprintf('@%s', realpath($file));
        }, $files);
        $this->addPostParams($files);
        return $this;
    }

    /**
     * @param string $user
     * @param string $password
     * @param int $authType
     * @return \PHPClassic\Curly
     */
    public function setAuth($user, $password, $authType = CURLAUTH_BASIC)
    {
        $this->setOption(CURLOPT_HTTPAUTH, $authType);
        $this->setOption(CURLOPT_USERPWD, sprintf('%s:%s', $user, $password));
        return $this;
    }

    /**
     * @return \PHPClassic\Curly
     */
    protected function prepare()
    {
        $getParams = http_build_query($this->getParams);
        //$postParams = http_build_query($this->postParams);

        $this->setOption(CURLOPT_URL, sprintf('%s?%s', $this->url, $getParams));
        $this->setOption(CURLOPT_PORT, $this->port);
        $this->setOption(CURLOPT_HTTPHEADER, $this->headers);
        $this->setOption(CURLOPT_CUSTOMREQUEST, $this->method);
        $this->setOption(CURLOPT_POSTFIELDS, $this->postParams);
        $this->setOption(CURLOPT_FOLLOWLOCATION, $this->followRedirect);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, true);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        return $this;
    }

    /**
     * @return \PHPClassic\Curly
     */
    protected function build()
    {
        foreach ($this->options as $option => $value) {
            curl_setopt($this->handler, $option, $value);
        }
        return $this;
    }

    /**
     * @param int $option
     * @param mixed $value
     * @return \PHPClassic\Curly
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * @return \PHPClassic\Curly
     */
    public function execute()
    {
        $this->prepare();
        $this->setOption(CURLOPT_HEADER, true);
        $this->build();

        $response = curl_exec($this->handler);
        $headerSize = curl_getinfo($this->handler, CURLINFO_HEADER_SIZE);

        curl_close($this->handler);
        $this->responseHeaders = substr($response, 0, $headerSize);
        $this->response = substr($response, $headerSize);
        return $this;
    }

    /**
     * @param string $savePath
     * @return \Panel\CommonBundle\Helper\Curly
     */
    public function download($savePath)
    {
        $this->prepare();
        $this->build();
        $response = curl_exec($this->handler);
        curl_close($this->handler);
        file_put_contents($savePath, $response);

        return $this;
    }

    /**
     * @param bool $toKBytes
     * @return int
     */
    public function getSize($toKBytes = true)
    {
        $this->prepare();
        $this->setOption(CURLOPT_HEADER, true);
        $this->setOption(CURLOPT_NOBODY, true);
        $this->build();
        curl_exec($this->handler);
        $size = curl_getinfo($this->handler, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($this->handler);

        return $toKBytes ? round($size / 1024) : $size;
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

    /**
     * @return void
     */
    public function __clone()
    {
        $this->handler = curl_init();
        $this->setUrl($this->url);
        $this->setPort($this->port);
    }

}
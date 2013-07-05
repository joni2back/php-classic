<?php

/**
 * Dynamic object data handler
 *
 * @author Jonas Sciangula <joni2back {at} gmail.com>
 */
class ClassicObject
{
    protected $_data = array();
    protected $_origData = array();

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->_origData = $this->_data = $data;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return \ClassicObject
     */
    public function set($key, $value)
    {
        $this->_data[$key] = $value;
        return $this;
    }

    /**
     * @param string$key
     */
    public function uns($key)
    {
        unset($this->_data[$key]);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->_data[$key]);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param string|array $key
     * @param mixed $value
     * @return \ClassicObject
     */
    public function setData($key, $value = null)
    {
        if (is_array($key)) {
            $this->_data = $key;
        } else {
            $this->_data[$key] = $value;
        }
        return $this;
    }

    /**
     * @param array $arr
     * @return \ClassicObject
     */
    public function addData(array $data)
    {
        foreach($data as $key => $value) {
            $this->setData($key, $value);
        }
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getOrigData($key = null)
    {
        if (is_null($key)) {
            return $this->_origData;
        }
        return isset($this->_origData[$key]) ? $this->_origData[$key] : null;
    }

    /**
     * @param string $key
     * @param mixed $data
     * @return \ClassicObject
     */
    public function setOrigData($key = null, $data = null)
    {
        if (is_null($key)) {
            $this->_origData = $this->_data;
        } else {
            $this->_origData[$key] = $data;
        }
        return $this;
    }

    /**
     * @param string $key
     * @return \ClassicObject
     */
    public function unsetData($key = null)
    {
        if (is_null($key)) {
            $this->_data = array();
        } else {
            $this->uns($key);
        }
        return $this;
    }

    public function hasChanges($key = null)
    {
        if (is_null($key)) {
            $result = $this->_data !== $this->_origData;
        } else {
            $result = $this->get($key) !== $this->getOrigData($key);
        }
        return $result;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->_data);
    }

    /**
     * This method should be overriden to work with the database
     * @return \ClassicObject
     */
    public function save()
    {
        $this->_origData = $this->_data;
        return $this;
    }

    /**
     * @return \ClassicObject
     */
    public function revert()
    {
        $this->_data = $this->_origData;
        return $this;
    }

    /**
     * @param string $method
     * @param array $params
     * @return \ClassicObject
     */
    public function __call($method, $params)
    {
        if (! preg_match('/^(get|set|has|uns)/', $method)) {
            trigger_error("Call to undefined function {$method}", E_USER_ERROR);
        }
        $operation = substr($method, 0, 3);
        $key = $this->_decamelize(substr($method, 3));
        switch ($operation) {
            case 'get':
                return $this->get($key);
                break;
            case 'set':
                return $this->set($key, $params[0]);
                break;
            case 'has':
                return $this->has($key);
                break;
            case 'uns':
                return $this->uns($key);
                break;
        }
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    protected function _decamelize($key)
    {
        return strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $key));
    }
}
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


// module/Amounts/src/Amounts/Model/Entity/Amounts.php

namespace  Amounts\Model\Entity;

class Amount {

    protected $_id;
    protected $_amount;
    protected $_currency;
    protected $_date;
    protected $_type;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getAmount() {
        return $this->_amount;
    }

    public function setAmount($amount) {
        $this->_amount = $amount;
        return $this;
    }

    public function getCurrency() {
        return $this->_currency;
    }

    public function setCurrency($currency) {
        $this->_currency = $currency;
        return $this;
    }

    public function getDate() {
        return $this->_date;
    }

    public function setDate($date) {
        $this->_date = $date;
        return $this;
    }

    public function getType() {
        return $this->_type;
    }

    public function setType($type) {
        $this->_type = $type;
        return $this;
    }
}

?>

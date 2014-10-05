<?php


// module/Amounts/src/Amounts/Model/AmountsTable.php

namespace Amounts\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug as Debug;
use Zend\View\Model\JsonModel;
use Zend\Json\Json as json;


class AmountsTable extends AbstractTableGateway {

    protected $table = 'amounts';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchAll() {
        $resultSet = $this->select(function (Select $select) {
            $select->order('created ASC');
        });

        $jsons = array();

        foreach ($resultSet as $row) {

            $json = array(
                    'id' => $row->id,
                    'amount' => $row->amount,
                    'type' => $row->type,
                    'currency' => $row->currency,
                    'date'=>$row->date
                );

            $jsons[] = $json;
        }

        return $jsons;
    }

    public function getAmount($id) {

        $row = $this->select(array('id' => (int) $id))->current();

        if (!$row)
            return false;

        $json = new JsonModel(array(
                'id' => $row->id,
                'amount' => $row->amount,
                'type' => $row->type,
                'currency' => $row->currency,
                'date'=>$row->date
                )
        );

        return $json;
    }

    public function saveAmount(Entity\Amount $amount) {

        $data = array(
            'amount' => $amount->getAmount(),
            'type' => $amount->getType(),
            'currency' => $amount->getCurrency(),
            'date' =>$amount->getDate()
        );

        $id = (int) $amount->getId();


        if ($id == 0) {

            $data['date'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getAmount($id)) {

            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else{
            Debug::dump('test');
            return false;
        }


    }

    public function removeAmount($id) {
        return $this->delete(array('id' => (int) $id));
    }

}
<?php

// module/Amounts/src/Amounts/Controller/AmountsController.php:

namespace Amounts\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug as Debug;
use Zend\Log\Logger as Log;
use Zend\Log\Writer\Stream as Writer;
use Zend\Json\Json as json;
use Zend\View\Model\JsonModel;


class AmountsController extends AbstractRestfulController {

    protected $_amountsTable;
    public $logger;


    //Fetch all amounts
    public function indexAction() {
        return new JsonModel($this->getAmountsTable()->fetchAll());
    }

    //Get one amount
    public function get($id) {
        $album = $this->getAmountsTable()->getAmount($id);
        return new JsonModel(array("data" => $album));
    }

    /*public function addAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $new_note = new \Amounts\Model\Entity\Amount();
            if (!$note_id = $this->getAmountsTable()->saveAmount($new_note))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_note_id' => $note_id)));
            }
        }
        return $response;
    }
*/
    public function removeAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post_data = $request->getPost();
            $amount_id = $post_data['id'];
            if (!$this->getAmountsTable()->removeAmount($amount_id))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true)));
            }
        }
        return $response;
    }


    //Create amount function
    public function updateAction() {
        // update post
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post_data = $request->getPost();

            //Id
            $amount_id = $post_data['id'];

            //Amount
            $amount_amount = $post_data['amount'];

            //Currency
            $amount_currency = $post_data['currency'];

            //Date
            $amount_date = $post_data['date'];

            //Type
            $amount_type = $post_data['type'];


            $amount = new \Amounts\Model\Entity\Amount();
            $amount->setId($amount_id);
            $amount->setType($amount_type);
            $amount->setAmount($amount_amount);
            $amount->setCurrency($amount_currency);
            $amount->setDate($amount_date);
            if (!$this->getAmountsTable()->saveAmount($amount))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true)));
            }
        }
        return $response;
    }

    public function getAmountsTable() {
        if (!$this->_amountsTable) {
            $sm = $this->getServiceLocator();
            $this->_amountsTable = $sm->get('Amounts\Model\AmountsTable');
        }
        return $this->_amountsTable;

    }

}
<?php
namespace Tasks\V1\Rpc\Sender;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class SenderController extends AbstractActionController
{

    public function senderAction()
    {
        return new ViewModel(array(
            "ack" => time(),
        ));
    }
}

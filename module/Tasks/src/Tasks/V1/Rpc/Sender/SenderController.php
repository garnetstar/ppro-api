<?php
namespace Tasks\V1\Rpc\Sender;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;
use Model\Facade\MessageFacade;
use Lib\SenderInterface;

class SenderController extends AbstractActionController
{

    /**
     *
     * @var MessageFacade
     */
    private $messageFacade;

    /**
     *
     * @var SenderInterface
     */
    private $sender;

    /**
     *
     * @param MessageFacade $messageFacade            
     * @param SenderInterface $sender            
     */
    public function __construct(MessageFacade $messageFacade, SenderInterface $sender)
    {
        $this->messageFacade = $messageFacade;
        $this->sender = $sender;
    }

    public function senderAction()
    {
        $toSend = $this->messageFacade->getMessagesToSend();
        
        foreach ($toSend as $message) {
            if($this->sender->sendMessage($message->getTask(), $message->getMessageType())){
                $this->messageFacade->updateProcesset($message);
            }
            
        }
        
        return new ViewModel(array(
            "ack" => time()
        ));
    }
}

<?php
namespace Tasks\V1\Rpc\Sender;

class SenderControllerFactory
{

    public function __invoke($controllers)
    {
        $sl = $controllers->getServiceLocator();
        
        $messageFacade = $sl->get('Model\Facade\MessageFacade');
        $sender = $sl->get('textSender');
        
        return new SenderController($messageFacade, $sender);
    }
}

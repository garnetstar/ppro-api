<?php
namespace Tasks\V1\Rpc\Sender;

class SenderControllerFactory
{

    public function __invoke($controllers)
    {
        $sl = $controllers->getServiceLocator();
        
        $taskFacade = $sl->get('Model\Facade\TaskFacade');
        $messageFacade = $sl->get('Model\Facade\MessageFacade');
        
        return new SenderController($messageFacade, $taskFacade);
    }
}

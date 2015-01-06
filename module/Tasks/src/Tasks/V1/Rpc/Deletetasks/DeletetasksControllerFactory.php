<?php
namespace Tasks\V1\Rpc\Deletetasks;

class DeletetasksControllerFactory
{
    public function __invoke($controllers)
    {
        $sl = $controllers->getServiceLocator();
        
        $taskFacade = $sl->get('Model\Facade\TaskFacade');
        
        
        return new DeletetasksController($taskFacade);
    }
}

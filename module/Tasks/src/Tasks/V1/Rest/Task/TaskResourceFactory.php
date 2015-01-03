<?php
namespace Tasks\V1\Rest\Task;

class TaskResourceFactory
{
    public function __invoke($services)
    {
        $taskFacade = $services->get('Model\Facade\TaskFacade');
        $userFacade = $services->get('Model\Facade\UserFacade');
        
        return new TaskResource($taskFacade, $userFacade);
    }
}

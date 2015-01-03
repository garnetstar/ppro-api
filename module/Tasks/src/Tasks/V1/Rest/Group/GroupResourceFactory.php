<?php
namespace Tasks\V1\Rest\Group;

class GroupResourceFactory
{
    public function __invoke($services)
    {
        $userFacade = $services->get('Model\Facade\UserFacade');
        $groupFacade = $services->get('Model\Facade\GroupFacade');
        
        return new GroupResource($userFacade, $groupFacade);
    }
}

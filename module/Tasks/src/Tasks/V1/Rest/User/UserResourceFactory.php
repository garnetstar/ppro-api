<?php
namespace Tasks\V1\Rest\User;

class UserResourceFactory
{
    public function __invoke($services)
    {
        $facade = $services->get('Model\Facade\UserFacade');
        $groupFacade = $services->get('Model\Facade\GroupFacade');
        
        return new UserResource($facade, $groupFacade);
    }
}

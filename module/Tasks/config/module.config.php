<?php
return array(
    'router' => array(
        'routes' => array(
            'tasks.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Tasks\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'tasks.rest.group' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/group[/:group_id]',
                    'defaults' => array(
                        'controller' => 'Tasks\\V1\\Rest\\Group\\Controller',
                    ),
                ),
            ),
            'tasks.rest.task' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/task[/:task_id]',
                    'defaults' => array(
                        'controller' => 'Tasks\\V1\\Rest\\Task\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'tasks.rest.user',
            1 => 'tasks.rest.group',
            2 => 'tasks.rest.task',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Tasks\\V1\\Rest\\User\\UserResource' => 'Tasks\\V1\\Rest\\User\\UserResourceFactory',
            'Doctrine\\DoctrineAdapter' => 'Doctrine\\Factory\\DoctrineAdapterFactory',
            'Model\\Facade\\OAuthFacade' => 'Model\\Factory\\OAuthFacadeFactory',
            'Model\\Facade\\UserFacade' => 'Model\\Factory\\UserFacadeFactory',
            'Model\\Facade\\GroupFacade' => 'Model\\Factory\\GroupFacadeFactory',
            'Model\\Facade\\TaskFacade' => 'Model\\Factory\\TaskFacadeFactory',
            'Tasks\\V1\\Rest\\Group\\GroupResource' => 'Tasks\\V1\\Rest\\Group\\GroupResourceFactory',
            'Tasks\\V1\\Rest\\Task\\TaskResource' => 'Tasks\\V1\\Rest\\Task\\TaskResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'Tasks\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'Tasks\\V1\\Rest\\User\\UserResource',
            'route_name' => 'tasks.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Tasks\\V1\\Rest\\User\\UserEntity',
            'collection_class' => 'Tasks\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
        'Tasks\\V1\\Rest\\Group\\Controller' => array(
            'listener' => 'Tasks\\V1\\Rest\\Group\\GroupResource',
            'route_name' => 'tasks.rest.group',
            'route_identifier_name' => 'group_id',
            'collection_name' => 'group',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Tasks\\V1\\Rest\\Group\\GroupEntity',
            'collection_class' => 'Tasks\\V1\\Rest\\Group\\GroupCollection',
            'service_name' => 'Group',
        ),
        'Tasks\\V1\\Rest\\Task\\Controller' => array(
            'listener' => 'Tasks\\V1\\Rest\\Task\\TaskResource',
            'route_name' => 'tasks.rest.task',
            'route_identifier_name' => 'task_id',
            'collection_name' => 'task',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'sort',
                1 => 'status',
                2 => 'assignee',
                3 => 'groups',
            ),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Tasks\\V1\\Rest\\Task\\TaskEntity',
            'collection_class' => 'Tasks\\V1\\Rest\\Task\\TaskCollection',
            'service_name' => 'Task',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Tasks\\V1\\Rest\\User\\Controller' => 'HalJson',
            'Tasks\\V1\\Rest\\Group\\Controller' => 'HalJson',
            'Tasks\\V1\\Rest\\Task\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Tasks\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.tasks.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Tasks\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.tasks.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Tasks\\V1\\Rest\\Task\\Controller' => array(
                0 => 'application/vnd.tasks.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Tasks\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.tasks.v1+json',
                1 => 'application/json',
            ),
            'Tasks\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.tasks.v1+json',
                1 => 'application/json',
            ),
            'Tasks\\V1\\Rest\\Task\\Controller' => array(
                0 => 'application/vnd.tasks.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Tasks\\V1\\Rest\\User\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tasks.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Tasks\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tasks.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
            'Tasks\\V1\\Rest\\Group\\GroupEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tasks.rest.group',
                'route_identifier_name' => 'group_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Tasks\\V1\\Rest\\Group\\GroupCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tasks.rest.group',
                'route_identifier_name' => 'group_id',
                'is_collection' => true,
            ),
            'Tasks\\V1\\Rest\\Task\\TaskEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tasks.rest.task',
                'route_identifier_name' => 'task_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Tasks\\V1\\Rest\\Task\\TaskCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tasks.rest.task',
                'route_identifier_name' => 'task_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Tasks\\V1\\Rest\\User\\Controller' => array(
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => true,
                ),
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
            'Tasks\\V1\\Rest\\Group\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => true,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => true,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
            'Tasks\\V1\\Rest\\Task\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => true,
                ),
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Tasks\\V1\\Rest\\User\\Controller' => array(
            'input_filter' => 'Tasks\\V1\\Rest\\User\\Validator',
        ),
        'Tasks\\V1\\Rest\\Group\\Controller' => array(
            'input_filter' => 'Tasks\\V1\\Rest\\Group\\Validator',
        ),
        'Tasks\\V1\\Rest\\Task\\Controller' => array(
            'input_filter' => 'Tasks\\V1\\Rest\\Task\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Tasks\\V1\\Rest\\User\\Validator' => array(
            0 => array(
                'name' => 'username',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'password',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            2 => array(
                'name' => 'groups',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'Group do kterých bude uživatel patřit.
id entit Group oddělených čárkou.',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            3 => array(
                'name' => 'name',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            4 => array(
                'name' => 'surname',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            5 => array(
                'name' => 'role',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^(admin|user)$/',
                        ),
                    ),
                ),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
        ),
        'Tasks\\V1\\Rest\\Group\\Validator' => array(
            0 => array(
                'name' => 'name',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'Tasks\\V1\\Rest\\Task\\Validator' => array(
            0 => array(
                'name' => 'title',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'description',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            2 => array(
                'name' => 'reporter',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'ID usera který task vytvořil.',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            3 => array(
                'name' => 'assignee',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'ID usera kterému byl task přidělen',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            4 => array(
                'name' => 'status',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'ID statusu',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
        ),
    ),
);

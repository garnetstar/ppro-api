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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'tasks.rest.user',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Tasks\\V1\\Rest\\User\\UserResource' => 'Tasks\\V1\\Rest\\User\\UserResourceFactory',
           'Doctrine\\DoctrineAdapter' => 'Doctrine\\Factory\\DoctrineAdapterFactory',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Tasks\\V1\\Rest\\User\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Tasks\\V1\\Rest\\User\\Controller' => array(
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
        ),
    ),
);

<?php

namespace Album;
use PhlyRestfully\ResourceController;

return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController'
        )
    ),
    'router' => array(
        'routes' => array(
            'v1' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Album\PasteController', // for the web UI
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'albums' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'v1/albums[/:id]',
                            'defaults' => array(
                                'controller' => 'Album\ApiController',
                            )
                        ),
                    ),
                ),
            ),
        ),
    ),
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view'
        )
    ),
    'phlyrestfully' => array(
        'resources' => array(
            'Album\ApiController' => array(
                'identifier' => 'Albums',
                'listener' => 'Album\AlbumResourceListener',
                'resource_identifiers' => array('AlbumResource'),
                'accept_criteria' => array(
                    'PhlyRestfully\View\RestfulJsonModel' => array(
                        'application/json',
                        'text/json',
                        'application/hal+json'
                    ),
                ),
                'content_type' => array(
                    ResourceController::CONTENT_TYPE_JSON => array(
                        'application/json',
                        'application/hal+json',
                        'text/json',
                    ),
                ),


                'collection_http_options' => array('get', 'post','delete','options'),
                'collection_name' => 'albums',
                'page_size' => 10,
                'resource_http_options' => array('get', 'patch', 'put','delete'),
                'route_name' => 'v1/albums',
            ),
        ),
    ),
);

<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Book;

use Book\Controller\Factory\BookControllerFactory;
use Book\Form\Factory\BookFormFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Book\Form\BookForm;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'book' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/book[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\BookController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'form_elements' => [
        'factories' => [
            BookForm::class => BookFormFactory::class,
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\BookController::class => BookControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\BookManager::class => Service\Factory\BookManagerFactory::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];

<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host' => 'bibliotecadb',
                    'user' => 'biblioteca',
                    'password' => '123123',
                    'dbname' => 'biblioteca',
                ]
            ],
        ],
    ],
    // Session configuration.
    'session_config' => [
        // Session cookie will expire in 1 hour.
        'cookie_lifetime' => 60*60*1,
        // Session data will be stored on server maximum for 30 days.
        'gc_maxlifetime'     => 60*60*24*30,
    ],
    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
    'book_price' => [
        'normal' => 0.2,
        'ticket' => 0.4
    ]
    /**
     * Na factory do service ou do controller
     * public function __invoke(Container $container) : MyController
    {
    $config = $container->get('config');
    if (!isset($config['book_price']) || !is_string($config['book_price'])) {
    throw new Exception(); // Use a specific exception here.
    }
    $variable = $config['book_price']; // 'value'
    return new MyController($variable);
    }
     */
];
<?php
/**
 *
 */
namespace Album;

/**
 * Class Module
 * @package Album
 */
class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        $result = array(
            'factories' => array(
                'Album\AlbumResourceListener' => function ($sm) {
                    $persistence = $sm->get('doctrine.entitymanager.orm_default');
                    return new AlbumResourceListener($persistence);
                },
            ),
        );
        return $result;
    }
}
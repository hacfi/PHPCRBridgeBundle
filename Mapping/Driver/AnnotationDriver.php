<?php

namespace hacfi\PHPCRBridgeBundle\Mapping\Driver;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Mapping\MappingException;

class AnnotationDriver
{
    /**
     * @var AnnotationReader
     */
    protected $reader;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var array
     */
    private $loadedAnnotations;

    public function __construct($reader, $cache)
    {
        $this->reader = $reader;
        $this->cache = $cache;
    }

    public function loadMetadataForClass($className)
    {
        if (isset($this->loadedAnnotations[$className])) {
            return $this->loadedAnnotations[$className];
        }

        if (false === ($bridges = $this->cache->fetch($className))) {

            $class = new \ReflectionClass($className);
            $bridges = array();

            foreach ($class->getProperties() as $property) {
                if (null !== $bridge = $this->reader->getPropertyAnnotation($property, 'hacfi\PHPCRBridgeBundle\Mapping\PHPCRBridge\Entity')) {
                    $bridges[$property->getName()] = array(
                        'object'  => 'entity',
                        'name'    => $bridge->name,
                        'manager' => $bridge->manager
                    );
                }

                if (null !== $bridge = $this->reader->getPropertyAnnotation($property, 'hacfi\PHPCRBridgeBundle\Mapping\PHPCRBridge\Document')) {
                    $bridges[$property->getName()] = array(
                        'object'  => 'document',
                        'name'    => $bridge->name,
                        'manager' => $bridge->manager
                    );
                }
            }

            $this->cache->save($className, $bridges);
        }

        return $this->loadedAnnotations[$className] = $bridges;
    }


    static public function create($paths = array(), AnnotationReader $reader = null)
    {
        if ($reader == null) {
            $reader = new AnnotationReader();
        }

        return new self($reader, $paths);
    }
}

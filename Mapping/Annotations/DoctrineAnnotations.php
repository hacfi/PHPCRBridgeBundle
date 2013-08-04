<?php

namespace hacfi\PHPCRBridgeBundle\Mapping\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Entity
{
    /** @var string */
    public $name;
    /** @var string */
    public $manager = 'default';
}

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Document
{
    /** @var string */
    public $name;
    /** @var string */
    public $manager = 'default';
}

<?php

namespace hacfi\PHPCRBridgeBundle\Mapping\PHPCRBridge;

use Doctrine\Common\Annotations\Annotation;

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

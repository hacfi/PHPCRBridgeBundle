hacfi PHPCRBridgeBundle
===

Bridge Doctrine ORM entities to Doctrine PHPCR ODM documents - and vice versa


Install
---

app/AppKernel.php:

```php
            new hacfi\PHPCRBridgeBundle\hacfiPHPCRBridgeBundle(),
```

app/autoload.php:

```php
AnnotationRegistry::registerFile(__DIR__.'/../vendor/hacfi/phpcrbridge-bundle/hacfi/PHPCRBridgeBundle/Mapping/Driver/DoctrineAnnotations.php');
```

Example
---

/src/hacfi/AppBundle/Entity/Product.php:

```php
<?php
namespace hacfi\AppBundle\Entity;

use hacfi\AppBundle\Document\ProductProperties;

use Doctrine\ORM\Mapping as ORM;
use hacfi\PHPCRBridgeBundle\Mapping\PHPCRBridge;

/**
 * Product
 *
 * @ORM\Table(name="ecommerce_product")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Product implements ProductInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

...

    /**
     * @ORM\Column(name="properties", type="string", length=255, nullable=false)
     *
     * @PHPCRBridge\Document(name="hacfiAppBundle:ProductProperties", manager="default")
     */
    private $properties;

}

```

/src/hacfi/AppBundle/Document/ProductProperties.php:

```php
<?php
namespace hacfi\AppBundle\Document;

use hacfi\AppBundle\Entity\Product;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use hacfi\PHPCRBridgeBundle\Mapping\PHPCRBridge;

/**
 * ProductProperties
 *
 * @PHPCRODM\Document(referenceable=true)
 */
class ProductProperties
{
    /** @PHPCRODM\Id(strategy="parent") */
    protected $id;

...


    /**
     * @PHPCRODM\String
     *
     * @PHPCRBridge\Entity(name="hacfiAppBundle:Product", manager="default")
     */
    protected $product;

}

```
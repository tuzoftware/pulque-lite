<?php


class PropertyAccessorExtension extends \Twig_Extension
{
    /** @var  PropertyAccess */
    protected $accessor;


    public function __construct()
    {
        //$this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('obtenerAtributo', array($this, 'obtenerAtributo'))
        );
    }

    public function obtenerAtributo($entity, $property) {
    return $entity->$property;
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     *
     */
    public function getName()
    {
        return 'property_accessor_extension';
    }
}
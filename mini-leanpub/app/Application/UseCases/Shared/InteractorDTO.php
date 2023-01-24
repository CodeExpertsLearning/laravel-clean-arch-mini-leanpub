<?php 
namespace MiniLeanpub\Application\UseCases\Shared;

abstract class InteractorDTO
{
    public function getData(): array 
    {
        $reflex = new \ReflectionClass($this);
        $props  = $reflex->getProperties(\ReflectionProperty::IS_PUBLIC);

        $propsValues = [];

        foreach($props as $prop) {
            $propsValues[$prop->getName()] = $prop->getValue($this);
        }

        return $propsValues;
    }
}
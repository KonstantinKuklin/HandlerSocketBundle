<?php

namespace KonstantinKuklin\HandlerSocketBundle;

use KonstantinKuklin\HandlerSocketBundle\DependencyInjection\HSExtension;
use KonstantinKuklin\HandlerSocketBundle\DependencyInjection\HandlerSocketExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HandlerSocketBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerExtension(new HandlerSocketExtension());
        $container->registerExtension(new HSExtension());
    }
}

//$reader     = new \Doctrine\Common\Annotations\AnnotationReader();
//$result     = $reader->getClassAnnotations($refl);
//print_r($result);
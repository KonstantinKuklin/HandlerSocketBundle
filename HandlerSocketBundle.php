<?php

namespace KonstantinKuklin\HandlerSocketBundle;

use KonstantinKuklin\MySQLHandlerSocketBundle\DependencyInjection\HSExtension;
use KonstantinKuklin\MySQLHandlerSocketBundle\DependencyInjection\MySQLHandlerSocketExtension;
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
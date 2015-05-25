<?php

namespace KnpU\GuardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use KnpU\GuardBundle\DependencyInjection\GuardAuthenticationFactory;

class KnpUGuardBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new GuardAuthenticationFactory());
    }
}
<?php

namespace KnpU\Guard\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use KnpU\Guard\Bundle\DependencyInjection\GuardAuthenticationFactory;

class KnpUGuardBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new GuardAuthenticationFactory());
    }
}
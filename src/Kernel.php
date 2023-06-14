<?php

namespace App;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

      /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    protected function configureRoutes(RoutingConfigurator $routes): void
{
    $routes->import($this->getProjectDir().'/config/routes.yaml');
}
}

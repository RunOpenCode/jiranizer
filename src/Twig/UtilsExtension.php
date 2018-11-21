<?php

namespace AppBundle\Twig;

use Symfony\Bridge\Twig\Extension\HttpKernelRuntime;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class UtilsExtension extends \Twig_Extension
{
    /**
     * @var HttpKernelRuntime
     */
    private $kernelRuntime;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(HttpKernelRuntime $kernelRuntime, FlashBagInterface $flashBag) {
        $this->kernelRuntime    = $kernelRuntime;
        $this->flashBag         = $flashBag;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('clear_flash_bag', \Closure::bind(function () {
                $this->flashBag->clear();
            }, $this)),
        ];
    }

    public function getFilters()
    {
        return [];
    }
}

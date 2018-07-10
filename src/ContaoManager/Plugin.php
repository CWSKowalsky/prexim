<?php

namespace SKowalsky\Prexim\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{

    public function getBundles(ParserInterface $parser)
    {
        return [
            (new BundleConfig('SKowalsky\Prexim\SKowalskyPrexim'))
                ->setReplace(['sk-prexim'])
                ->setLoadAfter(['LeadingSystems\MerconisBundle\LeadingSystemsMerconisBundle'])
        ];
    }
    
}

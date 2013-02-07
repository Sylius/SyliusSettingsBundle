<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SettingsBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\MoneyType as BaseMoneyType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MoneyType extends BaseMoneyType
{
    private $container = null;
    
    public function setContainer($container)
    {
        $this->container = $container;
    }

	/**
	* {@inheritdoc}
	*/
    public function setDefaultOptions(OptionsResolverInterface $resolver)
   	{
        $resolver->setDefaults(array(
            'precision' => 2,
            'grouping'  => false,
            'divisor'   => 1,
            'currency'  => $this->container->getParameter('currency'),
            'compound'  => false,
        ));
    }



}
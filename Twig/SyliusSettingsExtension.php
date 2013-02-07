<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SettingsBundle\Twig;

use Sylius\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use Twig_Extension;
use Twig_Function_Method;
use Twig_Filter_Method;

/**
 * Sylius settings extension for Twig.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusSettingsExtension extends Twig_Extension
{
    /**
     * Settings manager.
     *
     * @var SettingsManagerInterface
     */
    private $settingsManager;

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * Constructor.
     *
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'sylius_settings_all' => new Twig_Function_Method($this, 'getSettings'),
            'sylius_settings_get' => new Twig_Function_Method($this, 'getParameter'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'sylius_currency_format' => new Twig_Filter_Method($this, 'formatCurrency')
        );
    }

    /**
     * @var ContainerInterface
     */
    public function setContainer($container)
    {
        $this->container = $container;

    }   

    /**
     * @var number Currency amount to format
     * @var string Optional currency to format to
     * @var string Optional local value
     *
     * @return string Formatted currency value with currency type
     */
    public function formatCurrency($value, $currency = null, $locale = null)
    {
        if (!is_numeric($value))
            return null;

        $useLocale = $locale === null ? $this->container->get('request')->getLocale() : $locale;
        $useCurrency = $currency === null ? $this->container->getParameter('currency') : $currency;

        $formatter = new \NumberFormatter($useLocale, \NumberFormatter::CURRENCY);
        return  $formatter->formatCurrency($value, $useCurrency);
    }

    /**
     * Load settings from given namespace.
     *
     * @param string $namespace
     *
     * @return array
     */
    public function getSettings($namespace)
    {
        return $this->settingsManager->loadSettings($namespace);
    }

    /**
     * Load settings parameter for given namespace and name.
     *
     * @param string $namespace
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter($namespace, $name)
    {
        $settings = $this->settingsManager->loadSettings($namespace);

        return $settings[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_settings';
    }
}

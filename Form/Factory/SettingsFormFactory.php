<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SettingsBundle\Form\Factory;

use Sylius\Bundle\SettingsBundle\Schema\SchemaRegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Settings form factory.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SettingsFormFactory implements SettingsFormFactoryInterface
{
    /**
     * Validation groups.
     *
     * @var array
     */
    protected $validationGroups;

    /**
     * Schema registry.
     *
     * @var SchemaRegistryInterface
     */
    protected $schemaRegistry;

    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * Constructor.
     *
     * @param array                   $validationGroups
     * @param SchemaRegistryInterface $schemaRegistry
     * @param FormFactoryInterface    $formFactory
     */
    public function __construct(array $validationGroups, SchemaregistryInterface $schemaRegistry, FormFactoryInterface $formFactory)
    {
        $this->validationGroups = $validationGroups;
        $this->schemaRegistry = $schemaRegistry;
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create($namespace)
    {
        $schema = $this->schemaRegistry->getSchema($namespace);
        $builder = $this->formFactory->createBuilder(
            'form',
            null,
            array(
                'data_class'        => null,
                'validation_groups' => $this->validationGroups,
            )
        );

        $schema->buildForm($builder);

        return $builder->getForm();
    }
}

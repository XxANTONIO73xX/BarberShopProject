<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20211231\Symfony\Component\DependencyInjection\ParameterBag;

use RectorPrefix20211231\Symfony\Component\DependencyInjection\Container;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ContainerBag extends \RectorPrefix20211231\Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag implements \RectorPrefix20211231\Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface
{
    private $container;
    public function __construct(\RectorPrefix20211231\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->container->getParameterBag()->all();
    }
    /**
     * {@inheritdoc}
     *
     * @return array|bool|string|int|float|null
     */
    public function get(string $name)
    {
        return $this->container->getParameter($name);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function has(string $name)
    {
        return $this->container->hasParameter($name);
    }
}

<?php

declare(strict_types=1);

namespace MicroModule\TaskBundle\DependencyInjection;

use MicroModule\Task\Application\EventListener\JobCommandBusEventListenerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterTaskEventCompilerPass.
 */
class RegisterEventListenerCompilerPass implements CompilerPassInterface
{
    /**
     * EventDispatcher service is.
     *
     * @var string
     */
    private $eventDispatcherId;

    /**
     * Tag name for event listeners.
     *
     * @var string
     */
    private $serviceTag;

    /**
     * RegisterEventListenerCompilerPass constructor.
     *
     * @param string $eventDispatcherId
     * @param string $serviceTag
     */
    public function __construct(string $eventDispatcherId, string $serviceTag)
    {
        $this->eventDispatcherId = $eventDispatcherId;
        $this->serviceTag = $serviceTag;
    }

    /**
     * Modify the container before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @SuppressWarnings(PHPMD)
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->eventDispatcherId) && !$container->hasAlias($this->eventDispatcherId)) {
            return;
        }
        $definition = $container->findDefinition($this->eventDispatcherId);

        foreach ($container->findTaggedServiceIds($this->serviceTag) as $id => $attributes) {
            $this->processListenerDefinition($definition, $id);
        }
    }

    /**
     * Register task event listeners.
     *
     * @param Definition $dispatcher
     * @param string     $listenerId
     */
    private function processListenerDefinition(Definition $dispatcher, string $listenerId): void
    {
        foreach (JobCommandBusEventListenerInterface::EVENT_TAGS as $event => $method) {
            $dispatcher->addMethodCall(
                'addListener',
                [
                    $event,
                    [
                        new Reference($listenerId),
                        $method,
                    ],
                ]
            );
        }
    }
}

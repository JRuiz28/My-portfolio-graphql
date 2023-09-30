<?php

namespace Drupal\drupal_graphql\Plugin\GraphQL\DataProducer\User;

use Drupal\Core\Cache\RefinableCacheableDependencyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\graphql\GraphQL\Buffers\EntityBuffer;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\graphql\Plugin\GraphQL\DataProducer\DataProducerPluginBase;
use GraphQL\Deferred;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;

/**
 * Query to nodes related.
 *
 * @DataProducer(
 *   id = "query_user_content",
 *   name = @Translation("Load nodes with a user"),
 *   description = @Translation("Loads a list of User Nodes."),
 *   produces = @ContextDefinition("any",
 *     label = @Translation("Node entities")
 *   ),
 *   consumes = {
 *     "entity" = @ContextDefinition("entity",
 *       label = @Translation("Parent entity")
 *     ),
 *     "bundles" = @ContextDefinition("string",
 *       label = @Translation("Entity bundle(s) to restrict"),
 *       multiple = TRUE
 *     ),
 *   }
 * )
 */
class UserContent extends DataProducerPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity buffer service.
   *
   * @var \Drupal\graphql\GraphQL\Buffers\EntityBuffer
   */
  protected $entityBuffer;

  /**
   * {@inheritdoc}
   *
   * @codeCoverageIgnore
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('graphql.buffer.entity')
    );
  }

  /**
   * QueryNodes constructor.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $pluginId
   *   The plugin id.
   * @param mixed $pluginDefinition
   *   The plugin definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager service.
   * @param \Drupal\graphql\GraphQL\Buffers\EntityBuffer $entityBuffer
   *   The entity buffer service.
   *
   * @codeCoverageIgnore
   */
  public function __construct(array $configuration, $pluginId, $pluginDefinition, EntityTypeManagerInterface $entityTypeManager, EntityBuffer $entityBuffer) {
    parent::__construct($configuration, $pluginId, $pluginDefinition);
    $this->entityTypeManager = $entityTypeManager;
    $this->entityBuffer = $entityBuffer;
  }

  /**
   * Resolves related nodes.
   *
   * @param \Drupal\user\Entity\User $entity
   *   The node entity.
   * @param array|null $bundles
   *   The bundles to restrict.
   * @param \Drupal\Core\Cache\RefinableCacheableDependencyInterface $metadata
   *   The metadata object.
   *
   * @return \GraphQL\Deferred|null
   *   Array of \Drupal\user\Entity\User nodes or null.
   */
  public function resolve(User $entity, ?array $bundles, RefinableCacheableDependencyInterface $metadata) {

    $storage = $this->entityTypeManager->getStorage('node');
    $entityType = $storage->getEntityType();
    $entityTypeId = $storage->getEntityTypeId();
    $query = $storage->getQuery()
      ->currentRevision()
      ->accessCheck();

    $query->condition($entityType->getKey('bundle'), $bundles, 'IN');
    $query->condition('status', Node::PUBLISHED);
    $query->condition('uid', $entity->id());
    $result = $query->execute();

    $metadata->addCacheTags($entityType->getListCacheTags());
    $metadata->addCacheContexts($entityType->getListCacheContexts());

    $resolver = $this->entityBuffer->add($entityTypeId, array_values($result));
    return new Deferred(function () use ($resolver) {
      $entities = $resolver() ?: NULL;
      return $entities;
    });
  }

}

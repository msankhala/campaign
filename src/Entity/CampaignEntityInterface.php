<?php

namespace Drupal\campaign\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Campaign entities.
 *
 * @ingroup campaign
 */
interface CampaignEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Campaign name.
   *
   * @return string
   *   Name of the Campaign.
   */
  public function getName();

  /**
   * Sets the Campaign name.
   *
   * @param string $name
   *   The Campaign name.
   *
   * @return \Drupal\campaign\Entity\CampaignEntityInterface
   *   The called Campaign entity.
   */
  public function setName($name);

  /**
   * Gets the Campaign creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Campaign.
   */
  public function getCreatedTime();

  /**
   * Sets the Campaign creation timestamp.
   *
   * @param int $timestamp
   *   The Campaign creation timestamp.
   *
   * @return \Drupal\campaign\Entity\CampaignEntityInterface
   *   The called Campaign entity.
   */
  public function setCreatedTime($timestamp);

}

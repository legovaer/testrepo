<?php

/**
 * @file
 * Contains \Drupal\scheduler\Tests\SchedulerTestBase
 */

namespace Drupal\scheduler\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Base class to provide common test setup.
 */
abstract class SchedulerTestBase extends WebTestBase {

  /**
   * The profile to install as a basis for testing.
   *
   * @var string
   */
  protected $profile = 'testing';

  /**
   * The modules to be loaded for these tests.
   */
  public static $modules = ['node', 'scheduler'];

  /**
   * A user with administration rights.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $adminUser;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create a 'Basic Page' content type.
    /** @var NodeTypeInterface $node_type */
    $this->nodetype = $this->drupalCreateContentType(['type' => 'page', 'name' => t('Basic page')]);
    ### @TODO Remove all NodeType::load('page') and use $this->nodetype
    ### @TODO Remove all 'page' and use $this->nodetype->get('type')
    ### @TODO Remove all 'Basic page' and use $this->nodetype->get('name')

    // Add scheduler functionality to the node type.
    $this->nodetype->setThirdPartySetting('scheduler', 'publish_enable', TRUE)
      ->setThirdPartySetting('scheduler', 'unpublish_enable', TRUE)
      ->save();

    // Create an administrator user.
    $this->adminUser = $this->drupalCreateUser([
      'access content',
      'administer scheduler',
      'create page content',
      'edit own page content',
      'delete own page content',
      'view own unpublished content',
      'administer nodes',
      'schedule publishing of nodes',
    ]);
  }

}

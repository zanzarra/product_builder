<?php

/**
 * @file
 * Contains product_builder.page.inc.
 *
 * Page callback for Product builder entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Product builder templates.
 *
 * Default template: product_builder.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_product_builder(array &$variables) {
  // Fetch ProductBuilder Entity Object.
  $product_builder = $variables['elements']['#product_builder'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

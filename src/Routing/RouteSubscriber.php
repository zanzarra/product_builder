<?php

namespace Drupal\product_builder\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
* Listens to the dynamic route events.
*/
class RouteSubscriber extends RouteSubscriberBase {

 /**
  * {@inheritdoc}
  */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('entity.product_builder.add_form')) {
      $route->setDefault('_title_callback', '\Drupal\product_builder\Form\ProductBuilderForm::addProductBuilderTitle');
      $route->addOptions(['_admin_route' => FALSE]);
    }
    if ($route = $collection->get('entity.product_builder.edit_form')) {
      $route->addOptions(['_admin_route' => FALSE]);
    }
    if ($route = $collection->get('entity.product_builder.canonical')) {
      $route->addOptions(['_admin_route' => FALSE]);
    }
  }


}

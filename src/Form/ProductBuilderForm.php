<?php

namespace Drupal\product_builder\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Form controller for Product builder edit forms.
 *
 * @ingroup product_builder
 */
class ProductBuilderForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\product_builder\Entity\ProductBuilder */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Product builder.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Product builder.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.product_builder.canonical', ['product_builder' => $entity->id()]);
  }

  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);

    if ($this->operation == 'add') {
      $actions['submit']['#value'] = $this->t('Save and add to the Cart');
      $storage = $form_state->getStorage();
      //Change button name for Embed formatter.
      if (isset($storage['builder_type']) && $storage['builder_type'] == 'embed') {
        $builder_bundle = $storage['builder_bundle'];
        $button_text = $storage['builder_button_text'];
        $builder_bundles = \Drupal::service('entity_type.bundle.info')->getBundleInfo('product_builder');
        $bundle_label = $builder_bundles[$builder_bundle]['label'];
        $button_text = t($button_text, array('@bundle' => $bundle_label));
        $actions['submit']['#value'] = $button_text;
      }
    }

    return $actions;
  }

  /**
   * Provides a generic edit title callback.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   * @param \Drupal\Core\Entity\EntityInterface $_entity
   *   (optional) An entity, passed in directly from the request attributes.
   *
   * @return string|null
   *   The title for the entity edit page, if an entity was found.
   */
  function addProductBuilderTitle(RouteMatchInterface $route_match, $entity_type_id, $bundle_parameter) {
    $variation_id = \Drupal::request()->query->get('variation_id');
    if ($variation_id && ($variation = \Drupal::entityTypeManager()->getStorage('commerce_product_variation')->load($variation_id))) {
      $product = $variation->getProduct();
      return $this->t('Create your own @product', ['@product' => $product->getTitle()]);
    }

    $controller_resolver = \Drupal::service('controller_resolver');
    $callable = $controller_resolver->getControllerFromDefinition('Drupal\Core\Entity\Controller\EntityController::addBundleTitle');
    return call_user_func_array($callable, [$route_match, $entity_type_id, $bundle_parameter]);
  }

}

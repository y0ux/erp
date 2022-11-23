<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use Yii;

/**
 * Nav renders a nav HTML component.
 *
 * For example:
 *
 * ```php
 * echo Nav::widget([
 *     'items' => [
 *         [
 *             'label' => 'Home',
 *             'url' => ['site/index'],
 *             'linkOptions' => [...],
 *         ],
 *         [
 *             'label' => 'Dropdown',
 *             'items' => [
 *                  ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
 *                  '<div class="dropdown-divider"></div>',
 *                  '<div class="dropdown-header">Dropdown Header</div>',
 *                  ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
 *             ],
 *         ],
 *         [
 *             'label' => 'Login',
 *             'url' => ['site/login'],
 *             'visible' => Yii::$app->user->isGuest
 *         ],
 *     ],
 *     'options' => ['class' =>'nav-pills'], // set this to nav-tabs to get tab-styled navigation
 * ]);
 * ```
 *
 * Note: Multilevel dropdowns beyond Level 1 are not supported in Bootstrap 4.
 *
 * @see https://getbootstrap.com/docs/4.5/components/navs/
 * @see https://getbootstrap.com/docs/4.5/components/dropdowns/
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 */
class Nav extends \yii\bootstrap4\Nav
{
  /**
   * Renders a widget's item.
   * @param string|array $item the item to render.
   * @return string the rendering result.
   * @throws InvalidConfigException
   * @throws \Exception
   */
  public function renderItem($item)
  {
      if (is_string($item)) {
          return $item;
      }
      if (!isset($item['label'])) {
          throw new InvalidConfigException("The 'label' option is required.");
      }
      $icon = ArrayHelper::getValue($item, 'icon', "");
      $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
      $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
      if (!empty($icon))
        $label = '<i class="'.$icon.'"></i>'.$label;
      $options = ArrayHelper::getValue($item, 'options', []);
      $items = ArrayHelper::getValue($item, 'items');
      $url = ArrayHelper::getValue($item, 'url', '#');
      $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
      $disabled = ArrayHelper::getValue($item, 'disabled', false);
      $active = $this->isItemActive($item);

      if (empty($items)) {
          $items = '';
          Html::addCssClass($options, ['widget' => 'nav-item']);
          Html::addCssClass($linkOptions, ['widget' => 'nav-link']);
      } else {
          $linkOptions['data-toggle'] = 'dropdown';
          Html::addCssClass($options, ['widget' => 'dropdown nav-item']);
          Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle nav-link']);
          if (is_array($items)) {
              $items = $this->isChildActive($items, $active);
              $items = $this->renderDropdown($items, $item);
          }
      }

      if ($disabled) {
          ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
          ArrayHelper::setValue($linkOptions, 'aria-disabled', 'true');
          Html::addCssClass($linkOptions, ['disable' => 'disabled']);
      } elseif ($this->activateItems && $active) {
          Html::addCssClass($linkOptions, ['activate' => 'active']);
      }

      return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
  }
}

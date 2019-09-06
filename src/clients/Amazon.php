<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\authclient\clients;

use yii\authclient\OAuth2;
use yii\authclient\OAuthToken;

/**
 * Amazon allows authentication via AWS OAuth.
 *
 * In order to use Facebook OAuth you must register your application at <https://login.amazon.com/>.
 * Add an app. Click on "Register new application" button. There you need to provide some information about your app
 * and click save. Once saved, you will get your client id and client secret to use in configurations under web settings.
 * Click on edit under Web Settings and provide Allowed Return URLs. These urls will be used as return URIs list.
 *
 * Example application configuration:
 *
 * ```php
 * 'components' => [
 *     'authClientCollection' => [
 *         'class' => 'yii\authclient\Collection',
 *         'clients' => [
 *             'amazon' => [
 *                 'class' => 'yii\authclient\clients\Amazon',
 *                 'clientId' => 'aws_client_id',
 *                 'clientSecret' => 'aws_client_secret',
 *                 'scope' => [  // default scope is profile
 *                    'profile',
 *                    'postal_code'
 *                 ]
 *             ],
 *         ],
 *     ]
 *     // ...
 * ]
 * ```
 *
 * @author Tarun Jangra <tarun.jangra@hotmail.com>
 * @since 2.0
 */
class Amazon extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    public $authUrl = 'https://www.amazon.com/ap/oa';
    /**
     * {@inheritdoc}
     */
    public $tokenUrl = 'https://api.amazon.com/auth/o2/token';
    /**
     * {@inheritdoc}
     */
    public $apiBaseUrl = 'https://api.amazon.com';


  /**
   * {@inheritdoc}
   */
  public function init()
  {
    parent::init();
    if ($this->scope === null) {
      $this->scope = 'profile';
    }else{
      $this->scope = implode(' ', $this->scope);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function defaultNormalizeUserAttributeMap()
  {
    return [
      'id' => function ($attributes) {
        return $attributes['user_id'];
      }
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function initUserAttributes()
  {
    $attributes = $this->api('user/profile', 'GET');
    return $attributes;
  }

    /**
     * {@inheritdoc}
     */
    protected function defaultName()
    {
        return 'amazon';
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultTitle()
    {
        return 'Amazon';
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
        ];
    }

}
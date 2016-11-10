<?php

declare(strict_types=1);

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\Graylog;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication\BasicAuth;
use Http\Message\MessageFactory;
use Nexy\Graylog\Api\AbstractApi;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method Api\User user
 * @method Api\Search search
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Graylog
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var bool
     */
    private $httpClientModified = true;

    /**
     * @var Plugin[]
     */
    private $plugins = [];

    /**
     * The final client used by the API classes.
     * It contains the HttpClient and the needed plugins.
     *
     * @var HttpMethodsClient
     */
    private $pluginClient;

    /**
     * @var AbstractApi
     */
    private $apis;

    /**
     * @var array
     */
    private $options;

    /**
     * @param array           $options
     * @param HttpClient|null $httpClient
     */
    public function __construct(array $options = [], HttpClient $httpClient = null)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);

        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->messageFactory = MessageFactoryDiscovery::find();

        $this->addPlugin(new Plugin\BaseUriPlugin(UriFactoryDiscovery::find()->createUri($options['base_uri'])));
        $this->addPlugin(new Plugin\HeaderDefaultsPlugin([
            'Accept' => 'application/json',
        ]));
        $this->addPlugin(new Plugin\ErrorPlugin());
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return AbstractApi
     */
    public function __call($name, $arguments)
    {
        try {
            return $this->api(ucfirst(str_replace('api', '', $name)));
        } catch (\InvalidArgumentException $e) {
            throw new \BadMethodCallException(sprintf('Undefined method %s', $name));
        }
    }

    /**
     * @param string      $usernameOrToken
     * @param string|null $password
     */
    public function auth(string $usernameOrToken, string $password = null)
    {
        // For token usage, we have to use basic auth with 'token' as password and the token as login.
        $auth = new BasicAuth($usernameOrToken, $password ?: 'token');

        $this->removePlugin(Plugin\AuthenticationPlugin::class);
        $this->addPlugin(new Plugin\AuthenticationPlugin($auth));
    }

    /**
     * @param string $apiClass
     *
     * @return AbstractApi
     */
    private function api(string $apiClass): AbstractApi
    {
        if (!isset($this->apis[$apiClass])) {
            $apiFQNClass = '\\Nexy\\Graylog\\Api\\'.$apiClass;

            if (false === class_exists($apiFQNClass)) {
                throw new \InvalidArgumentException(sprintf('Undefined api class %s', $apiClass));
            }

            $this->apis[$apiClass] = new $apiFQNClass($this);
        }

        return $this->apis[$apiClass];
    }

    /**
     * @param OptionsResolver $resolver
     */
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired([
                'base_uri',
            ])
            ->setAllowedTypes('base_uri', 'string')
        ;
    }

    /**
     * @param Plugin $plugin
     */
    private function addPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;
        $this->httpClientModified = true;
    }

    /**
     * @param string $pluginClass
     */
    private function removePlugin(string $pluginClass)
    {
        foreach ($this->plugins as $p => $plugin) {
            if ($plugin instanceof $pluginClass) {
                unset($this->plugins[$p]);
                $this->httpClientModified = true;
            }
        }
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient(): HttpMethodsClient
    {
        if ($this->httpClientModified) {
            $this->httpClientModified = false;

            $this->pluginClient = new HttpMethodsClient(
                new PluginClient($this->httpClient, $this->plugins),
                $this->messageFactory
            );
        }

        return $this->pluginClient;
    }
}

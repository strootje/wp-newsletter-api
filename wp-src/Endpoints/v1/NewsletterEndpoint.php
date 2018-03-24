<?php

namespace WPNewsletterApi\Endpoints\v1;
use WPNewsletterApi\Client\Client;
use WPNewsletterApi\Client\ClientFactory;

class NewsletterEndpoint {
	private static $namespace = 'newsletter/v1';
	private static $route = '/subscribe';

	private $options;
	private $client;

	public function __construct() {
		$this->options = get_option('newsletter_options', false)['mailchimp'];
		if (ClientFactory::canCreate()) {
			$this->client = ClientFactory::create();
		}
	}

	public function register() {
		register_rest_route(self::$namespace, self::$route, $this->post());
	}

	public function post() {
		return [
			'methods' => \WP_REST_Server::EDITABLE,
			'callback' => function( $args ) {
				try {
					$this->client->addMemberToList($this->options['listid'], $args['email'], [
						'FNAME' => $args['name']
					]);
				}
				catch(Exception $exc) {
					return [
						'status' => 'nok',
						'message' => $exc->getMessage()
					];
				}

				return [
					'status' => 'ok'
				];
			}
		];
	}
}

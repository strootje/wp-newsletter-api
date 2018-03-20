<?php

namespace WPNewsletterApi\Graphql\Types;
use WPNewsletterApi\Client\ClientFactory;
use \WPGraphQL\Type\WPInputObjectType;
use \WPGraphQL\Type\WPObjectType;
use \WPGraphQL\Types;

class NewsletterType extends WPObjectType {
	public static $type_name = 'newsletter';
	private static $fields;

	public function __construct() {
		$config = [
			'name' => self::$type_name,
			'fields' => self::fields()
		];

		parent::__construct($config);
	}

	public static function fields() {
		if (!isset(self::$fields)) {
			self::$fields = function() {
				$fields = [
					'subscribe' => [
						'type' => Types::string(),
						'args' => [
							'email' => Types::string(),
							'member' => new NewsletterMemberType()
						],
						'resolve' => function( $value, $args, $context, $info ) {
							$options = get_option('newsletter_options', false)['mailchimp'];
							$client = ClientFactory::create();

							$client->addMemberToList($options['listid'], $args['email'], [
								'FNAME' => $args['member']['name']
							]);

							return 'ok';
						}
					]
				];

				return self::prepare_fields($fields, self::$type_name);
			};
		}

		return self::$fields;
	}
}

class NewsletterMemberType extends WPInputObjectType {
	public static $type_name = 'newsletter_member';
	private static $fields;

	public function __construct() {
		$config = [
			'name' => self::$type_name,
			'fields' => [
				'name' => Types::string()
			]
		];

		parent::__construct($config);
	}
}


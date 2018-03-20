<?php

namespace WPNewsletterApi\Graphql;
use WPNewsletterApi\Graphql\Types;
use WPNewsletterApi\Graphql\Types\NewsletterType;

class Graphql {
	public static function IsGraphqlEnabled() {
		return class_exists('WPGraphQL');
	}

	public function addQueries( $fields ) {
		return $fields;
	}

	public function addMutations( $fields ) {
		$fields = self::newsletter($fields);
		return $fields;
	}

	private static function newsletter( $fields ) {
		$fields[NewsletterType::$type_name] = [
			'type' => Types::newsletter(),
			'resolve' => function( $value, $args, $context, $info ) {
				return [];
			}
		];

		return $fields;
	}
}

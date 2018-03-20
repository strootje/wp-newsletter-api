<?php

namespace WPNewsletterApi\Graphql;
use WPNewsletterApi\Graphql\Types\NewsletterType;

class Types {
	private static $newsletterType;

	public static function newsletter() {
		return self::$newsletterType ?: (self::$newsletterType = new NewsletterType());
	}
}

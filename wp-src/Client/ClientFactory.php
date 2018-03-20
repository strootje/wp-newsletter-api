<?php

namespace WPNewsletterApi\Client;
use WPNewsletterApi\Client\MailchimpClient;

class ClientFactory {
	public static function canCreate( $variant = null ) {
		$options = get_option('newsletter_options', false);
		return ($variant && isset($options[$variant])) || ($options && (
			isset($options['mailchimp']) ||
			isset($options['__more mail providers__'])
		));
	}

	public static function create() {
		if (!self::canCreate()) {
			throw new \Exception('options are false');
		}

		$options = get_option('newsletter_options', false);
		if (isset($options['mailchimp'])) {
			return new MailchimpClient($options['mailchimp']);
		}
	}

	public static function createVariant( $variant ) {
		if (!self::canCreate($variant)) {
			throw new \Exception('options are false');
		}

		$options = get_option('newsletter_options', false)[$variant];
		if ($variant == 'mailchimp') {
			return new MailchimpClient($options);
		}
	}
}

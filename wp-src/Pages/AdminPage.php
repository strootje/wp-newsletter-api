<?php

namespace WPNewsletterApi\Pages;
use Mailchimp\Mailchimp;

class AdminPage {
	public function addPage() {
		add_options_page(
			__('Newsletter Settings', PLUGINNAME), __('Newsletter', PLUGINNAME), 
			'manage_options', 'options-newsletter', 
			[ $this, 'renderPage' ]
		);
	}

	public function initPage() {
		register_setting(
			'newsletter_group',
			'newsletter_options',
			[ $this, 'sanitize' ]
		);
	}

	public function enqueueScripts() {
		wp_enqueue_script('oauth-helper', plugins_url('/wp-respapi-newsletter/src/assets/js/oauth-helper.js'), [ 'jQuery' ]);
	}

	public function renderPage() {
		include __DIR__ . '/../Views/AdminPage.php';
	}

	public function sanitize( $input ) {
		$sanitized = [];

		if (isset($input['mailchimp'])) {
			$sanitized['mailchimp'] = [];

			if (isset($input['mailchimp']['apikey'])) {
				try {
					$mailchimp = new Mailchimp($input['mailchimp']['apikey']);
					$sanitized['mailchimp']['apikey'] = sanitize_text_field($input['mailchimp']['apikey']);
				} catch(\Exception $e) {
					add_settings_error('newsletter_options[mailchimp][apikey]', 'invalid', $e->getMessage());
				}
			}

			if (isset($input['mailchimp']['listid'])) {
				$sanitized['mailchimp']['listid'] = sanitize_text_field($input['mailchimp']['listid']);
			}
		}

		return $sanitized;

		return [
			'mailchimp' => [
				'apikey' => $input['mailchimp']['apikey']
			]
		];
	}
}

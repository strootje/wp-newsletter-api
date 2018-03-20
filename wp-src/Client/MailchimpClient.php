<?php

namespace WPNewsletterApi\Client;
use WPNewsletterApi\Client\Client;
use Mailchimp\Mailchimp;

class MailchimpClient implements Client {
	private $client;

	public function __construct( $options ) {
		$this->client = new Mailchimp($options['apikey']);
	}

	public function getLists() {
		return $this->client->get('lists', [
			'fields' => 'lists.id,lists.name'
		]);
	}

	public function addMemberToList( $listId, $email, $member ) {
		$this->client->post("lists/{$listId}/members", [
			'email_address' => $email,
			'status' => 'subscribed',
			'merge_fields' => $member
		]);
	}
}

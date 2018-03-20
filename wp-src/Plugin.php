<?php

namespace WPNewsletterApi;
use WPNewsletterApi\Endpoints\v1\NewsletterEndpoint;
use WPNewsletterApi\Graphql\Graphql;
use WPNewsletterApi\Pages\AdminPage;

class Plugin {
	private $endpoint;
	private $page;
	private $schema;

	public function __construct() {
		$this->endpoint = new NewsletterEndpoint();
		$this->page = new AdminPage();
		$this->schema = new Graphql();
	}

	public function addActions() {
		add_action('rest_api_init', [ $this->endpoint, 'register' ]);
		add_action('admin_menu', [ $this->page, 'addPage' ]);
		add_action('admin_init', [ $this->page, 'initPage' ]);
		add_action('admin_enqueue_scripts', [ $this->page, 'enqueueScripts' ]);
	}

	public function addFilters() {
		if (Graphql::IsGraphqlEnabled()) {
			add_filter('graphql_rootQuery_fields', [ $this->schema, 'addQueries' ]);
			add_filter('graphql_rootMutation_fields', [ $this->schema, 'addMutations' ]);
		}
	}
}

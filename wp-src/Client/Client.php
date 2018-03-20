<?php

namespace WPNewsletterApi\Client;

interface Client {
	function getLists();
	function addMemberToList( $listId, $email, $member );
}

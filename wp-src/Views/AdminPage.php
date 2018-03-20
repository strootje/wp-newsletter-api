<div class="wrap">
	<h1><?php _e('Newsletter Settings', PLUGINNAME); ?></h1>
	
	<form method='post' action='options.php'>
		<?php $options = get_option('newsletter_options'); ?>
		<?php settings_fields('newsletter_group'); ?>
		<input type='hidden' name='newsletter_options[mailer]' value='mailchimp' />

		<section>
			<h2><?php _e('Mailchimp Options', PLUGINNAME); ?></h2>

			<table class='form-table'>
				<tbody>
					<tr>
						<th scope='row'><?php _e('ApiKey', PLUGINNAME); ?></th>
						<td><input type='text' class='regular-text' name='newsletter_options[mailchimp][apikey]' value='<?php echo $options['mailchimp']['apikey']; ?>' /></td>
					</tr>
				<?php if(WPNewsletterApi\Client\ClientFactory::canCreate('mailchimp')): ?>
					<?php $client = WPNewsletterApi\Client\ClientFactory::createVariant('mailchimp'); ?>
					<tr>
						<th scope='row'><?php _e('ListID', PLUGINNAME); ?></th>
						<td><select name='newsletter_options[mailchimp][listid]'>
							<option value=''><?php _e('< Select a list >', PLUGINNAME); ?></option>
							<?php foreach($client->getLists() as $list): ?>
								<option value='<?php echo $list->id; ?>'<?php if($options['mailchimp']['listid'] == $list->id) { echo ' selected'; } ?>>
									<?php echo $list->name; ?>
								</option>
							<?php endforeach; ?>
						</select></td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
		</section>

		<?php //	('options-newsletter'); ?>
		<?php submit_button(); ?>
	</form>
</div>

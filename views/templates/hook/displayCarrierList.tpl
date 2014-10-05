<div id="delivery-options">
{if !empty($mymodcarrier_relay_point)}
	<p><strong>{l s='Relay points:' mod='mymodcarrier'}</strong></p><br>
    {foreach from=$mymodcarrier_relay_point key=id_relay_point item=relay_point}
		<p>
			<input type="radio" name="relay_point" class="mymodcarrier_relay_point" value="{$relay_point.name|urlencode}:%20{$relay_point.address|urlencode}" {if $id_relay_point eq 0}checked="checked"{/if} />
			<strong>{$relay_point.name}:</strong> {$relay_point.address}
		</p><br>
    {/foreach}
{/if}
</div>

<script>
	var id_carrier_relay_point = {$id_carrier_relay_point};
	var mymodcarrier_ajax_link = '{$mymodcarrier_ajax_link}';
	$(document).ready(function() {
		mymodcarrier_load();
	});
</script>
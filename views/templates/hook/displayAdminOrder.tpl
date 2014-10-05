{if $relaypoint->id gt 0}
<div class="panel">
	<h3>
        <i class="icon-truck"></i>
        {l s='Relay point chosen by the customer' mod='mymodcarrier'}
    </h3>
	<p>{$relaypoint->relay_point}</p>
</div>
{/if}

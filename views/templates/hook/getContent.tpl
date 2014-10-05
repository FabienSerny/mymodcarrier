{if isset($confirmation)}
    {if $confirmation eq 'ok'}
<div class="alert alert-success">{l s='Congratulations, the configuration seems valid!' mod='mymodcarrier'}</div>
    {else}
<div class="alert alert-danger">{l s='The configuration seems invalid, please check your credentials.' mod='mymodcarrier'}</div>
    {/if}
{/if}
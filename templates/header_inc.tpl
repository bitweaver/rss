{if $gBitSystem->isPackageActive( 'rss' ) and $feedlink.url}
	<link rel="alternate" type="application/rss+xml" title="{$feedlink.title|escape}" href="{$feedlink.url}" />
{/if}

{if $gBitSystem->isPackageActive( 'rss' )}
	<link rel="rss feeds" title="{tr}RSS Syndication{/tr}" href="{$smarty.const.RSS_PKG_URL}" />
{/if}

{if $gBitSystem->isPackageActive( 'rss' ) and $feedlink.url}
	<link rel="alternate" type="application/rss+xml" title="{$feedlink.title|escape}" href="{$feedlink.url}" />
{/if}

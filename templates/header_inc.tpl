{* $Header: /cvsroot/bitweaver/_bit_rss/templates/header_inc.tpl,v 1.2 2005/07/17 17:36:14 squareing Exp $ *}
{strip}
{if $gBitSystem->isPackageActive( 'rss' )}
	{if $gBitLoc.ACTIVE_PACKAGE eq 'blogs' and $gBitUser->hasPermission( 'bit_p_read_blog' )}
		<link rel="alternate" type="application/rss+xml" title="{$title}{$post_info.blogtitle}" href="{$gBitLoc.BLOGS_PKG_URL}blogs_rss.php?blog_id={$blog_id}" />
	{/if}
	{if $gBitLoc.ACTIVE_PACKAGE eq 'wiki' and $gBitUser->hasPermission( 'bit_p_view' )}
		<link rel="alternate" type="application/rss+xml" title="{$siteTitle} - wiki" href="{$gBitLoc.RSS_PKG_URL}wiki_rss.php" />
	{/if}
{/if}
{/strip}

{* $Header: /cvsroot/bitweaver/_bit_rss/templates/header_inc.tpl,v 1.3 2005/08/07 17:44:21 squareing Exp $ *}
{strip}
{if $gBitSystem->isPackageActive( 'rss' )}
	{if $smarty.const.ACTIVE_PACKAGE eq 'blogs' and $gBitUser->hasPermission( 'bit_p_read_blog' )}
		<link rel="alternate" type="application/rss+xml" title="{$title}{$post_info.blogtitle}" href="{$smarty.const.BLOGS_PKG_URL}blogs_rss.php?blog_id={$blog_id}" />
	{/if}
	{if $smarty.const.ACTIVE_PACKAGE eq 'wiki' and $gBitUser->hasPermission( 'bit_p_view' )}
		<link rel="alternate" type="application/rss+xml" title="{$siteTitle} - wiki" href="{$smarty.const.RSS_PKG_URL}wiki_rss.php" />
	{/if}
{/if}
{/strip}

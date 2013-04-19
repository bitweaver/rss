{strip}
{if $packageMenuTitle}<a href="#"> {tr}{$packageMenuTitle|capitalize}{/tr}</a>{/if}
<ul class="{$packageMenuClass}">
	<li><a class="item" href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page=rss" title="{tr}Syndication{/tr}" >{tr}RSS{/tr}</a></li>
	<li><a class="item" href="{$smarty.const.RSS_PKG_URL}admin/admin_rssmodul class="dropdown-menu sub-menu"es.php" title="{tr}Syndication Modules{/tr}" >{tr}RSS Modules{/tr}</a></li>
</ul>
{/strip}

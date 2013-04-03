{strip}
<li class="dropdown-submenu">
    <a href="#" onclick="return(false);" tabindex="-1" class="sub-menu-root">{tr}{$smarty.const.RSS_PKG_NAME|capitalize}{/tr}</a>
	<ul class="dropdown-menu sub-menu">
		<li><a class="item" href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page=rss" title="{tr}Syndication Settings{/tr}" >{tr}RSS Settings{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.RSS_PKG_URL}admin/admin_rssmodul class="dropdown-menu sub-menu"es.php" title="{tr}Syndication Modules{/tr}" >{tr}RSS Modules{/tr}</a></li>
	</ul>
</li>
{/strip}

{strip}
{if $gBitSystem->isPackageActive('rss')}
	{bitmodule title="$moduleTitle" name="rss_feed"}
		<ul class="rss">
			{section name=ix loop=$modRSSItems}
				<li class="{cycle values="odd,even"}">
					<div class="title"><a href="{$modRSSItems[ix].link}">{$modRSSItems[ix].title}</a></div>
					<div class="date">{$modRSSItems[ix].pubdate}
					<br />
					{if $modRSSItems[ix].author}by {$modRSSItems[ix].author}{/if}</div>
					{$modRSSItems[ix].description}&nbsp;
					<a class="more" href="{$modRSSItems[ix].link}">Read more</a>
				</li>
			{sectionelse}
				<li></li>
			{/section}
		</ul>
	{/bitmodule}
{/if}
{/strip}
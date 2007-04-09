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
					{if !$hideDesc}{$modRSSItems[ix].description}&nbsp;{/if}
					<a class="more" href="{$modRSSItems[ix].link|escape:"url"}">Read more</a>
				</li>
			{sectionelse}
				<li></li>
			{/section}
		</ul>
	{/bitmodule}
{/if}
{/strip}
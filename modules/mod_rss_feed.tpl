{strip}
{if $gBitSystem->isPackageActive('rss')}
	{bitmodule title="$moduleTitle" name="rss_feed"}
		<ul class="rss">
			{section name=ix loop=$modRSSItems max=$max}
				<li class="{cycle values="odd,even"}">
					<div class="title"><a href="{$modRSSItems[ix]->get_permalink()}">{$modRSSItems[ix]->get_title()}</a></div>
					<div class="date">{$modRSSItems[ix]->get_date('j M Y | g:i a T')}
					<br />
					{if $modRSSItems[ix]->get_author()}
					{assign var='author' value=$modRSSItems[ix]->get_author()}
						{if $author->get_name()}
							by {$author->get_name()}
						{elseif $author->get_email()}
							by {$author->get_email()}
						{/if}
					{/if}
					{assign var='source' value=$modRSSItems[ix]->get_feed()} at <a href="{$source->get_link()}">{$source->get_title()}</a>
					</div>
					{if !$hideDesc}{$modRSSItems[ix]->get_description()}&nbsp;{/if}
					{if $short_desc[ix]}{$short_desc[ix]}&nbsp;{/if}
					<a class="more" href="{$modRSSItems[ix]->get_link()}">{biticon iname=go-next iexplain="Read More"}</a>
				</li>
			{sectionelse}
				<li></li>
			{/section}
		</ul>
	{/bitmodule}
{/if}
{/strip}

{*
$story = $item->get_feed(); 
print_r( "<a href='" . $item->get_permalink() . "'>" . $item->get_title() . "</a>" . " | " . $item->get_date('j M Y | g:i a T') . " | Source: " . $story->get_title() );
*}
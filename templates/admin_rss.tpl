{strip}

{form}
	{jstabs}
		{jstab title="Syndication Feeds"}
			{legend legend="Syndication Feeds"}
				<input type="hidden" name="page" value="{$page}" />
				{foreach from=$formRSSFeeds key=pkg_rss item=output}
					<div class="control-group">
						{formlabel label="Feed for `$output.label`" for=$pkg_rss}
						{forminput}
							{html_checkboxes name="$pkg_rss" values="y" checked=$gBitSystem->getConfig($pkg_rss) labels=false id=$pkg_rss}
							{assign var="rss_max"          value="`$pkg_rss`_max_records"}
							{assign var="rss_title"        value="`$pkg_rss`_title"}
							{assign var="rss_description"  value="`$pkg_rss`_description"}
							{formhelp note=`$output.note`}
						{/forminput}
					</div>

					<div class="control-group">
						{formlabel label="Items" for=$rss_max}
						{forminput}
							<input type="text" id="{$rss_max}" name="{$rss_max}" size="5" value="{$gBitSystem->getConfig($rss_max)|default:10}" />
						{/forminput}
					</div>

					<div class="control-group">
						{formlabel label="Title" for=$rss_title}
						{forminput}
							<input type="text" id="{$rss_title}" name="{$rss_title}" size="35" value="{$gBitSystem->getConfig($rss_title)}" />
						{/forminput}
					</div>

					<div class="control-group">
						{formlabel label="Description" for=$rss_description}
						{forminput}
							<input type="text" id="{$rss_description}" name="{$rss_description}" size="35" value="{$gBitSystem->getConfig($rss_description)}" />
						{/forminput}
					</div>
					<hr />
				{/foreach}

				{formhelp note="<dl>
					<dt>Title</dt>
					<dd>Name that appears when user calls RSS feed. In some cases, such as blogs, the Title is prepended to the actual title of the blog. If you prefer using the blog title as the title on it's own, please leave this blank.</dd>
					<dt>Description</dt>
					<dd>Description of the RSS feed. In some cases, such as blogs, the description is prepended to the actual description of the blog. If you prefer using the blog description as the description on it's own, please leave this blank.</dd>
					<dt>Items</dt>
					<dd>Maximum number of items that are broadcast when accessing the RSS feed.</dd></dl>"}
			{/legend}
		{/jstab}

		{jstab title="Syndication Settings"}
			{legend legend="Syndication Settings"}
				<div class="control-group">
					{formlabel label="Default Feed Type" for="rssfeed_default_version"}
					{forminput}
						{html_options name=rssfeed_default_version id=rssfeed_default_version values=$feedTypes options=$feedTypes selected=$gBitSystem->getConfig('rssfeed_default_version')}
						{formhelp note="Even after settings this, it will still be possible to use the other types of feeds."}
					{/forminput}
				</div>

				<div class="control-group">
					{formlabel label="Cache Time" for="rssfeed_cache_time"}
					{forminput}
						{html_options name=rssfeed_cache_time id=rssfeed_cache_time values=$cacheTimes options=$cacheTimes selected=$gBitSystem->getConfig('rssfeed_cache_time')}
						{formhelp note="Set the cache time of the individual rss feeds. Setting this to 0 will disable caching (recommended for sites with a complex permission setup)."}
					{/forminput}
				</div>

				{foreach from=$formRSSSettings key=setting item=output}
					<div class="control-group">
						{formlabel label=`$output.label` for=$setting}
						{forminput}
							<input type="text" name="{$setting}" id="{$setting}" size="50" value="{$gBitSystem->getConfig($setting)}" />
							{formhelp note=`$output.note`}
						{/forminput}
					</div>
				{/foreach}

				{foreach from=$formRSSOptions key=item item=output}
				<div class="control-group">
					{formlabel label=`$output.label` for=$item}
					{forminput}
						{html_checkboxes name="$item" values="y" checked=$gBitSystem->getConfig($item) labels=false id=$item}
						{formhelp note=`$output.note` page=`$output.page`}
					{/forminput}
				</div>
				{/foreach}
			{/legend}
		{/jstab}
	{/jstabs}

	<div class="control-group submit">
		<input type="submit" class="btn" name="feed_settings" value="{tr}Change preferences{/tr}" />
	</div>
{/form}

{/strip}

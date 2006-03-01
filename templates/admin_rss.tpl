{strip}

{form}
	{jstabs}
		{jstab title="Syndication Feeds"}
			{legend legend="Syndication Feeds"}
				<input type="hidden" name="page" value="{$page}" />
				{foreach from=$formRSSFeeds key=rss_pkg item=output}
					<div class="row">
						{formlabel label="Feed for `$output.label`" for=$rss_pkg}
						{forminput}
							{html_checkboxes name="$rss_pkg" values="y" checked=`$gBitSystem->getConfig($rss_pkg) labels=false id=$rss_pkg}
							{assign var="max_rss" value="max_`$rss_pkg`"}
							{assign var="title_rss" value="title_`$rss_pkg`"}
							{assign var="desc_rss" value="desc_`$rss_pkg`"}
							{formhelp note=`$output.note`}
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Items" for=`$rss_pkg`_items}
						{forminput}
							<input type="text" id="{$rss_pkg}_items" name="{$max_rss}" size="5" value="{$gBitSystem->getConfig($max_rss)|default:10}" />
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Title" for=`$rss_pkg`_title}
						{forminput}
							<input type="text" id="{$rss_pkg}_title" name="{$title_rss}" size="35" value="{$gBitSystem->getConfig($title_rss)}" />
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Description" for=`$rss_pkg`_desc}
						{forminput}
							<input type="text" id="{$rss_pkg}_desc" name="{$desc_rss}" size="35" value="{$gBitSystem->getConfig($desc_rss)}" />
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
				<div class="row">
					{formlabel label="Default Feed Type" for="rssfeed_default_version"}
					{forminput}
						{html_options name=rssfeed_default_version id=rssfeed_default_version values=$feedTypes options=$feedTypes selected=$gBitSystem->mPrefs.rssfeed_default_version}
						{formhelp note="Even after settings this, it will still be possible to use the other types of feeds."}
					{/forminput}
				</div>

				{foreach from=$formRSSSettings key=setting item=output}
					<div class="row">
						{formlabel label=`$output.label` for=$setting}
						{forminput}
							<input type="text" name="{$setting}" id="{$setting}" size="50" value="{$gBitSystem->getConfig($setting)}" />
							{formhelp note=`$output.note`}
						{/forminput}
					</div>
				{/foreach}
			{/legend}
		{/jstab}
	{/jstabs}

	<div class="row submit">
		<input type="submit" name="feed_settings" value="{tr}Change preferences{/tr}" />
	</div>
{/form}

{/strip}

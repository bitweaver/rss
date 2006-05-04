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
							{html_checkboxes name="$rss_pkg" values="y" checked=$gBitSystem->getConfig($rss_pkg) labels=false id=$rss_pkg}
							{assign var="rss_max"          value="`$rss_pkg`_max_records"}
							{assign var="rss_title"        value="`$rss_pkg`_title"}
							{assign var="rss_description"  value="`$rss_pkg`_description"}
							{formhelp note=`$output.note`}
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Items" for=$rss_max}
						{forminput}
							<input type="text" id="{$rss_max}" name="{$rss_max}" size="5" value="{$gBitSystem->getConfig($rss_max)|default:10}" />
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Title" for=$rss_title}
						{forminput}
							<input type="text" id="{$rss_title}" name="{$rss_title}" size="35" value="{$gBitSystem->getConfig($rss_title)}" />
						{/forminput}
					</div>

					<div class="row">
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

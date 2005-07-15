{strip}

{form}
	{jstabs}
		{jstab title="RSS Feeds"}
			{legend legend="RSS Feeds"}
				<input type="hidden" name="page" value="{$page}" />
				{foreach from=$formRSSFeeds key=rss_pkg item=output}
					<div class="row">
						{formlabel label="RSS feed for `$output.label`" for=$rss_pkg}
						{forminput}
							{html_checkboxes name="$rss_pkg" values="y" checked=`$gBitSystemPrefs.$rss_pkg` labels=false id=$rss_pkg}
							{assign var="max_rss" value="max_`$rss_pkg`"}
							{assign var="title_rss" value="title_`$rss_pkg`"}
							{assign var="desc_rss" value="desc_`$rss_pkg`"}
							{formhelp note=`$output.note`}
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Items" for=$rss_pkg}
						{forminput}
							<input type="text" name="{$max_rss}" size="5" value="{$gBitSystemPrefs.$max_rss|default:10}" />
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Title" for=$rss_pkg}
						{forminput}
							<input type="text" name="{$title_rss}" size="35" value="{$gBitSystemPrefs.$title_rss}" />
						{/forminput}
					</div>

					<div class="row">
						{formlabel label="Description" for=$rss_pkg}
						{forminput}
							<input type="text" name="{$desc_rss}" size="35" value="{$gBitSystemPrefs.$desc_rss}" />
						{/forminput}
					</div>
					<hr />
				{/foreach}

				<div class="row submit">
					<input type="submit" name="feedsTabSubmit" value="{tr}Change preferences{/tr}" />
				</div>

				{formhelp note="<dl>
					<dt>Title</dt>
					<dd>Name that appears when user calls RSS feed. In some cases, such as blogs, the Title is prepended to the actual title of the blog. If you prefer using the blog title as the title on it's own, please leave this blank.</dd>
					<dt>Description</dt>
					<dd>Description of the RSS feed. In some cases, such as blogs, the description is prepended to the actual description of the blog. If you prefer using the blog description as the description on it's own, please leave this blank.</dd>
					<dt>Items</dt>
					<dd>Maximum number of items that are broadcast when accessing the RSS feed.</dd></dl>"}

			{/legend}
		{/jstab}

		{jstab title="RSS Settings"}
			{legend legend="RSS Settings"}
				<div class="row">
					{formlabel label="Default RDF version" for="rssfeed_default_version"}
					{forminput}
						<input type="text" name="rssfeed_default_version" id="rssfeed_default_version" size="1" value="{$gBitSystemPrefs.rssfeed_default_version}" />.0
						{formhelp note="<a class=\"external\" href=\"http://www.w3.org/TR/rdf-schema/\">{tr}RDF 1.0 Specification{/tr}</a> and <a class=\"external\" href=\"http://blogs.law.harvard.edu/tech/rss#optionalChannelElements\" title=\"RDF Documentation\">RDF 2.0 Specification</a>"}
					{/forminput}
				</div>

				<div class="row">
					{formlabel label="Append CSS file" for="rssfeed_css"}
					{forminput}
						<input type="checkbox" name="rssfeed_css" id="rssfeed_css" value="y" {if $gBitSystem->isFeatureActive( 'rssfeed_css' )}checked="checked"{/if} />
						{formhelp note=""}
					{/forminput}
				</div>

				{foreach from=$formRSSSettings key=setting item=output}
					<div class="row">
						{formlabel label=`$output.label` for=$setting}
						{forminput}
							<input type="text" name="{$setting}" id="{$setting}" size="50" value="{$gBitSystemPrefs.$setting}" />
							{formhelp note=`$output.note`}
						{/forminput}
					</div>
				{/foreach}

				{formhelp note="More help regarding RSS feeds can be found here: <a class=\"external\" href=\"http://www.w3.org/TR/rdf-schema/\">{tr}RDF 1.0 Specification{/tr}</a> and <a class=\"external\" href=\"http://blogs.law.harvard.edu/tech/rss#optionalChannelElements\" title=\"RDF Documentation\">RDF 2.0 Specification</a>"}

				<div class="row submit">
					<input type="submit" name="settingsTabSubmit" value="{tr}Change preferences{/tr}" />
				</div>
			{/legend}
		{/jstab}
	{/jstabs}
{/form}

{/strip}

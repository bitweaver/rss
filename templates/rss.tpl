{strip}
{form}
	{legend legend="Syndication Feeds"}
		{if $feedlink}
			<div id="rssid" class="fade-000000 row">
				{formlabel label="Requested Feed"}
				{forminput}
					<strong><a href="{$feedlink.url}">{$feedlink.title|escape}</a></strong>
					{formhelp note="Use this link for your feed aggregator."}
				{/forminput}
			</div>
			<hr />
		{/if}

		<div class="row">
			{formlabel label="Feed Format" for="format"}
			{forminput}
				{html_options name=format id=format values=$feedFormat options=$feedFormat selected=$feedlink.format}
				{formhelp note="Select your preferred feed format."}
			{/forminput}
		</div>

		<div class="row">
			{formlabel label="Feed" for="pkg"}
			{forminput}
				{html_options name=pkg id=pkg values=$pkgs options=$pkgs selected=$feedlink.pkg}
				{formhelp note=""}
			{/forminput}
		</div>

		<div class="row submit">
			<input type="submit" name="get_feed" value="Get Feed" />
		</div>
	{/legend}
{/form}
{/strip}

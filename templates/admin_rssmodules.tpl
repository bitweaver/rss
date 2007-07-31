{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin rssmodules">
	<div class="header">
		<h1>{tr}Admin RSS modules{/tr}</h1>
	</div>

	<div class="body">

		{if $items}
			{box title="Feed Preview"}
				<ul>
					{section name=ix loop=$items}
						<li><a href="{$items[ix]->get_permalink()}">{$items[ix]->get_title()}</a></li>
					{/section}
				</ul>
			{/box}
		{/if}

		{form legend="Create / Edit Syndication Module"}
			<input type="hidden" name="rss_id" value="{$rss_id}" />
			<div class="row">
				{formlabel label="Title" for="name"}
				{forminput}
					<input type="text" name="name" id="name" value="{$name|escape}" />
					{formhelp note="This will appear at the top of the module."}
				{/forminput}
			</div>

			<div class="row">
				{formlabel label="Description" for="description"}
				{forminput}
					<textarea name="description" id="description" rows="3" cols="40">{$description|escape}</textarea>
					{formhelp note=""}
				{/forminput}
			</div>

			<div class="row">
				{formlabel label="URL" for="url"}
				{forminput}
					<input size="50" type="text" name="url" id="url" value="{$url|escape}" />
					{formhelp note=""}
				{/forminput}
			</div>

			<div class="row">
				{formlabel label="Refresh Rate" for="refresh"}
				{forminput}
					<select name="refresh" id="refresh">
						<option value="1"    {if $minutes eq 60}selected="selected"{/if}   >1   </option>
						<option value="5"    {if $refresh eq 300}selected="selected"{/if}  >5   </option>
						<option value="10"   {if $refresh eq 600}selected="selected"{/if}  >10  </option>
						<option value="15"   {if $refresh eq 900}selected="selected"{/if}  >15  </option>
						<option value="20"   {if $refresh eq 1200}selected="selected"{/if} >20  </option>
						<option value="30"   {if $refresh eq 1800}selected="selected"{/if} >30  </option>
						<option value="45"   {if $refresh eq 2700}selected="selected"{/if} >45  </option>
						<option value="60"   {if $refresh eq 3600}selected="selected"{/if} >60  </option>
						<option value="90"   {if $refresh eq 5400}selected="selected"{/if} >90  </option>
						<option value="120"  {if $refresh eq 7200}selected="selected"{/if} >120 </option>
						<option value="360"  {if $refresh eq 21600}selected="selected"{/if}>360 </option>
						<option value="720"  {if $refresh eq 43200}selected="selected"{/if}>720 </option>
						<option value="1440" {if $refresh eq 86400}selected="selected"{/if}>1440</option>
					</select> {tr}minutes{/tr}
					{formhelp note=""}
				{/forminput}
			</div>

			<div class="row">
				{formlabel label="Show Feed Title" for="show-title"}
				{forminput}
					<input type="checkbox" name="show_title" id="show-title" {if $show_title eq 'y'}checked="checked"{/if} />
					{formhelp note="Might not work as expected."}
				{/forminput}
			</div>

			<div class="row">
				{formlabel label="Publication Time" for="pub-date"}
				{forminput}
					<input type="checkbox" name="show_pub_date" id="pub-date" {if $show_pub_date eq 'y'}checked="checked"{/if} />
					{formhelp note="Show the time at which the feed was published."}
				{/forminput}
			</div>

			<div class="row submit">
				<input type="submit" name="save" value="{tr}Save{/tr}" />
			</div>
		{/form}

		{minifind}

		<table class="data">
			<caption>{tr}RSS Modules{/tr}</caption>
			<tr>
				<th>{smartlink ititle="ID" isort=rss_id offset=$offset}</th>
				<th>
					{smartlink ititle="Name" isort=name offset=$offset}
					<br />
					{smartlink ititle="Description" isort=description offset=$offset}
					<br />
					{smartlink ititle="URL" isort=url offset=$offset}
				</th>
				<th>{smartlink ititle="Last Update" isort=last_updated offset=$offset}</th>
				<th>{smartlink ititle="Refresh" isort=refresh offset=$offset}</th>
				<th>
					{smartlink ititle="Feed Title" isort=show_title offset=$offset}
					<br />
					{smartlink ititle="Publication Date" isort=show_pub_date offset=$offset}
				</th>
				<th>{tr}Actions{/tr}</th>
			</tr>
			{section name=user loop=$channels}
			<tr class="{cycle values='odd,even'}">
				<td>{$channels[user].rss_id}</td>
				<td>
					<h2>{$channels[user].name}</h2>
					{$channels[user].description}
					<br />
					{$channels[user].url}
				</td>
				<td>{$channels[user].last_updated|bit_short_datetime}</td>
				<td>{$channels[user].minutes} min</td>
				<td style="text-align:center;">
					{if $channels[user].show_title eq 'y'}{biticon ipackage="icons" iname="face-smile" iexplain="Show Title"}{else}{biticon ipackage="icons" iname="face-sad" iexplain="Show Title"}{/if}
					<br />
					{if $channels[user].show_pub_date eq 'y'}{biticon ipackage="icons" iname="face-smile" iexplain="Show Publication Time"}{else}{biticon ipackage="icons" iname="face-sad" iexplain="Show Publication Time"}{/if}
				</td>
				<td>
				   <a href="{$smarty.const.RSS_PKG_URL}admin/admin_rssmodules.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;view={$channels[user].rss_id}">{biticon ipackage="icons" iname="document-open" iexplain=view}</a>
				   <a href="{$smarty.const.RSS_PKG_URL}admin/admin_rssmodules.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;rss_id={$channels[user].rss_id}">{biticon ipackage="icons" iname="accessories-text-editor" iexplain=edit}</a>
				   <a href="{$smarty.const.RSS_PKG_URL}admin/admin_rssmodules.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;remove={$channels[user].rss_id}">{biticon ipackage="icons" iname="edit-delete" iexplain=remove}</a>
				</td>
			</tr>
			{sectionelse}
				<tr class="norecords"><td colspan="9">{tr}No records found{/tr}</td></tr>
			{/section}
		</table>

		{pagination}
	</div><!-- end .body -->
</div><!-- end .rss -->
{/strip}

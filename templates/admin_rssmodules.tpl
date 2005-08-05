<div class="floaticon">{bithelp}</div>

<div class="admin rssmodules">
<div class="header">
<h1>{tr}Admin RSS modules{/tr}</h1>
</div>

<div class="body">

{if $preview eq 'y'}
<div class="admin box">
<div class="boxtitle">{tr}Content for the feed{/tr}</div>
<div class="boxcontent">
<ul>
{section name=ix loop=$items}
<li><a href="{$items[ix].link}">{$items[ix].title}</a></li>
{/section}
</ul>
</div>
</div>
{/if}

{if $rss_id > 0}
<h2>{tr}Edit this RSS module:{/tr} {$name}</h2>
<a href="{$smarty.const.RSS_PKG_URL}admin/index.php">{tr}Create new RSS module{/tr}</a>
{else}
<h2>{tr}Create new RSS module{/tr}</h2>
{/if}
<form action="{$smarty.const.RSS_PKG_URL}admin/index.php" method="post">
<input type="hidden" name="rss_id" value="{$rss_id|escape}" />
<table class="panel">
<tr><td>
{tr}Name{/tr}:</td><td>
<input type="text" name="name" value="{$name|escape}" />
</td></tr>
<tr><td>
{tr}Description{/tr}:</td><td>
<textarea name="description" rows="4" cols="40">{$description|escape}</textarea>
</td></tr>
<tr><td>
{tr}URL{/tr}:</td><td>
<input size="47" type="text" name="url" value="{$url|escape}" />
</td></tr>
<tr><td>
{tr}Refresh rate{/tr}:</td><td>
<select name="refresh">
<option value="1" {if $minutes eq 60}selected="selected"{/if}>{tr}1 minute{/tr}</option>
<option value="5" {if $refresh eq 300}selected="selected"{/if}>{tr}5 minutes{/tr}</option>
<option value="10" {if $refresh eq 600}selected="selected"{/if}>{tr}10 minutes{/tr}</option>
<option value="15" {if $refresh eq 900}selected="selected"{/if}>{tr}15 minutes{/tr}</option>
<option value="20" {if $refresh eq 1200}selected="selected"{/if}>{tr}20 minutes{/tr}</option>
<option value="30" {if $refresh eq 1800}selected="selected"{/if}>{tr}30 minutes{/tr}</option>
<option value="45" {if $refresh eq 2700}selected="selected"{/if}>{tr}45 minutes{/tr}</option>
<option value="60" {if $refresh eq 3600}selected{/if}>{tr}1 hour{/tr}</option>
<option value="90" {if $refresh eq 5400}selected="selected"{/if}>{tr}1.5 hours{/tr}</option>
<option value="120" {if $refresh eq 7200}selected="selected"{/if}>{tr}2 hours{/tr}</option>
<option value="360" {if $refresh eq 21600}selected="selected"{/if}>{tr}6 hours{/tr}</option>
<option value="720" {if $refresh eq 43200}selected="selected"{/if}>{tr}12 hours{/tr}</option>
<option value="1440" {if $refresh eq 86400}selected="selected"{/if}>{tr}1 day{/tr}</option>
</select>
</td></tr>
<tr><td>
{tr}show feed title{/tr}:<b>(work in progress)</b></td><td>
<input type="checkbox" name="show_title" {if $show_title eq 'y'}checked="checked"{/if}>
</td></tr>
<tr><td>{tr}show publish date{/tr}:</td><td><input type="checkbox" name="show_pub_date" {if $show_pub_date eq 'y'}checked="checked"{/if}></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="save" value="{tr}Save{/tr}" /></td></tr>
</table>
</form>

<h2>{tr}Rss channels{/tr}</h2>
<table class="find">
<tr><td>{tr}Find{/tr}</td>
   <td>
   <form method="get" action="{$smarty.const.RSS_PKG_URL}admin/index.php">
     <input type="text" name="find" value="{$find|escape}" />
     <input type="submit" value="{tr}find{/tr}" name="search" />
     <input type="hidden" name="sort_mode" value="{$sort_mode|escape}" />
   </form>
   </td>
</tr>
</table>

<table class="data">
<tr>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'rss_id_desc'}rss_id_asc{else}rss_id_desc{/if}">{tr}ID{/tr}</a></th>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'name_desc'}name_asc{else}name_desc{/if}">{tr}Name{/tr}</a></th>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'description_desc'}description_asc{else}description_desc{/if}">{tr}Description{/tr}</a></th>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'url_desc'}url_asc{else}url_desc{/if}">{tr}URI{/tr}</a></th>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'last_updated_desc'}last_updated_asc{else}last_updated_desc{/if}">{tr}Last update{/tr}</a></th>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'refresh_desc'}refresh_asc{else}refresh_desc{/if}">{tr}refresh{/tr}</a></th>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'last_updated_desc'}show_title_asc{else}show_title_desc{/if}">{tr}Show feed title{/tr}</a></th>
<th><a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={if $sort_mode eq 'refresh_desc'}show_pub_date_asc{else}show_pub_date_desc{/if}">{tr}Show publication date{/tr}</a></th>
<th>{tr}action{/tr}</th>
</tr>
{cycle values="even,odd" print=false}
{section name=user loop=$channels}
<tr class="{cycle}">
<td>{$channels[user].rss_id}</td>
<td>{$channels[user].name}</td>
<td>{$channels[user].description}</td>
<td>{$channels[user].url}</td>
<td>{$channels[user].last_updated|bit_short_datetime}</td>
<td>{$channels[user].minutes} min</td>
<td>{$channels[user].show_title}</td>
<td>{$channels[user].show_pub_date}</td>
<td>
   <a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;remove={$channels[user].rss_id}">{tr}remove{/tr}</a>
   <a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;rss_id={$channels[user].rss_id}">{tr}edit{/tr}</a>
   <a href="{$smarty.const.RSS_PKG_URL}admin/index.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;view={$channels[user].rss_id}">{tr}view{/tr}</a>
</td>
</tr>
{sectionelse}
<tr class="norecords"><td colspan="9">{tr}No records found{/tr}</td></tr>
{/section}
</table>

</div> {* end .body *}

<div class="pagination">
{if $prev_offset >= 0}
[<a href="{$smarty.const.RSS_PKG_URL}admin/index.php?find={$find}&amp;offset={$prev_offset}&amp;sort_mode={$sort_mode}">{tr}prev{/tr}</a>]&nbsp;
{/if}
{tr}Page{/tr}: {$actual_page}/{$cant_pages}
{if $next_offset >= 0}
&nbsp;[<a href="{$smarty.const.RSS_PKG_URL}admin/index.php?find={$find}&amp;offset={$next_offset}&amp;sort_mode={$sort_mode}">{tr}next{/tr}</a>]
{/if}
{if $direct_pagination eq 'y'}
<br />
{section loop=$cant_pages name=foo}
{assign var=selector_offset value=$smarty.section.foo.index|times:$maxRecords}
<a href="{$smarty.const.RSS_PKG_URL}admin/index.php?find={$find}&amp;offset={$selector_offset}&amp;sort_mode={$sort_mode}">
{$smarty.section.foo.index_next}</a>&nbsp;
{/section}
{/if}
</div>

</div> {* end .admin *}

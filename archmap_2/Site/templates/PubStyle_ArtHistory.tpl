{if $pub.type == "book"}
{$pub.authors|replace:';':', '}, <span class="book biblio-title" >{$pub.name}</span>, {$pub.location}, (<span class="pub-date">{$pub.date}</span>){elseif $pub.type == "thesis"}
{$pub.authors|replace:';':', '}, <span class="book biblio-title" >{$pub.name}</span>, {$pub.location}, (<span class="pub-date">{$pub.date}</span>)
{elseif $pub.type == "chapter"|| $pub.type == "paper-conference"}
{$pub.authors|replace:';':', '}, "<span class="article biblio-title">{$pub.name}</span>" in <span class="book biblio-title" >{$pub.container_title}</span>, (<span class="pub-date">{$pub.date}</span>), {$pub.jpages}
{elseif $pub.type == "article-journal"}
{$pub.authors|replace:';':', '}, "<span class="article biblio-title">{$pub.name}</span>",  <span class="book biblio-title" >{$pub.container_title}</span>, (<span class="pub-date">{$pub.date}</span>), {$pub.jpages}
{if $pub.url|strpos:"jstor"}<a href="{$pub.url}" target="_blank">[@jstor]</a>{/if}
{if $pub.url|strpos:"sciencedirect"}<a href="{$pub.url}" target="_blank">[@sciencedirect]</a>{/if}
{/if}
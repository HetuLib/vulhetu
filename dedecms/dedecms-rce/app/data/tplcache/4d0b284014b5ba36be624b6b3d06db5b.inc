<div>
<article class="uk-card uk-card-default uk-card-small uk-article uk-overflow-hidden uk-box-shadow-hover-large tm-ignore-container">
<div class="uk-card-header">{dede:field name='typename'/} </div>
<div class="uk-card-body">
<ul class="uk-list uk-list-small uk-list-divider">
{dede:arclist titlelen='255' row='8'}
<li><span>[field:pubdate function="MyDate('m-d',@me)"/]</span> <a href="[field:arcurl /]">[field:title /]</a></li>
{/dede:arclist}
</ul>
</div>
</article>
</div>
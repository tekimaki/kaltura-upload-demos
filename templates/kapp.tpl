{include file="header.tpl"}
{strip}
	<div id="outerwrapper">
		<div id="header">
		</div><!-- end #header -->

		<div id="container">
    		<div id="wrapper">
    			<div id="content">
    				<div id="main">
    					{include file=$centerTpl}
    				</div><!-- end #main -->
    			</div><!-- end #content -->
    		</div><!-- end #wrapper -->
    
    		{if $l_column}
    			<div id="navigation">
					{$l_column}
    			</div><!-- end #navigation -->
    		{/if}
    
    		{if $r_column}
    			<div id="extra">
					{$r_column}
    			</div><!-- end #extra -->
    		{/if}
        </div>
		<div style="clear:both">&nbsp;</div>
	</div><!-- end #container -->
	<div id="footer">
	</div><!-- end #footer -->
{/strip}
{include file="footer.tpl"}

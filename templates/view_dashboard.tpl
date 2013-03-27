{strip}
<h2> kWidget Authentication</h2>
<p>Please login to access demos</p>
<ul>
{foreach from=$demos item=demo}
<li><a href="./index.php?view={$demo.type}">{$demo.title}</a><li>
{/foreach}
<ul>
<div id="hostedAuthWidget"></div>
{/strip}
{literal}
<script> 
	kWidget.auth.getWidget( "hostedAuthWidget", function( userObject ){
		$.cookie("ks", userObject.ks, { expires : 10 });
		$authTable = $('<table>').css( 'width', '350px' );
		$.each( userObject, function( key, value){
			$authTable.append( 
				$('<tr>').append(
					$('<td>').text( key ),
					$('<td>').text( value )
				)
			)
		});
		$('#hostedAuthWidget').after( 
			"Got login info: ",
			$authTable 
		);
	});
</script>
{/literal}

{strip}
<h2>Kaltura Uploader Demos</h2>
<ul>
{foreach from=$demos item=demo}
<li><a href="./index.php?view={$demo.type}">{$demo.title}</a></li>
{/foreach}
</ul>
{if $error eq 'loginrequired'}
<p><strong>Please login to access an uploader</strong></p>
{/if}
<p id="loginMsg">Please login to access demos</p>
<div id="hostedAuthWidget"></div>
{/strip}
{literal}
<script> 
	kWidget.auth.getWidget( "hostedAuthWidget", function( userObject ){
		$.cookie("ks", userObject.ks, { expires : 10 });
		$.cookie("partnerId", userObject.partnerId, { expires : 10 });
		/*
		$authTable = $('<table>').css( 'width', '350px' );
		$.each( userObject, function( key, value){
			$authTable.append( 
				$('<tr>').append(
					$('<td>').text( key ),
					$('<td>').text( value )
				)
			)
		})
		$('#hostedAuthWidget').after( 
			"Got login info: ",
			$authTable 
		)
		*/
		$('#loginMsg').text( 
			"Login successful"
		)
	});
</script>
{/literal}

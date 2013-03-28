{strip}
{include file="header_inc.tpl"}
<div id="flashContainer">
	<div id="kcw"></div>
</div>
{/strip}

<!--include external scripts and define constants -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>

<script type="text/javascript">
{literal}
if ( ! window.console ) console = { log: function(){} };

function onContributionWizardAfterAddEntry(entries) {
        alert(entries.length + " media file/s was/were succsesfully uploaded");
        for(var i = 0; i < entries.length; i++) {
                alert("entries["+i+"]:EntryID = " + entries[i].entryId);
        }
}
function onContributionWizardClose() {
        alert("Thank you for using Kaltura Contribution Wizard");
}

var params = {
	allowScriptAccess: "always",
	allowNetworking: "all",
	wmode: "opaque"
};
{/literal}

var flashVars = {ldelim}
	uid: "{$userId}",
	partnerId: "{$partnerId}",
	ks: "{$ks}",
	afterAddEntry: "onContributionWizardAfterAddEntry",
	close: "onContributionWizardClose",
	showCloseButton: false, 
	Permissions: 1
{rdelim};

swfobject.embedSWF("http://www.kaltura.com/kcw/ui_conf_id/{$uiconfId}", "kcw", "680", "360", "9.0.0", "expressInstall.swf", flashVars, params);
</script>

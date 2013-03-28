<!---set style to enable widget overlap -->
<style>
		#flashContainer{ position:relative; }
		#flashContainer div{ color:#333; font-size:16px; }
		object, embed{ position:relative; top:-40; left:0; z-index:999;}
</style>

<div id="flashContainer">
	<form>
		<!--<input type="button" value="Step 1 - Browse for content">-->
	</form>
	<div id="uploader"></div>
</div>
<div id="userInput">
	<form>
		<input type="button" value="Step 2 - Upload selected content" onclick="upload()">
		&nbsp;
		<input type="button" value="Step 3 - Add entries" onclick="addEntries()">
		&nbsp;
		<input type="button" value="Cancel uploads" onclick="stopUploads()">
	</form>
</div>
<div id="resultsLog">Log</div>
<div id="progressbar"></div>

<!--include external scripts and define constants -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>

<!---	JavaScript handler methods to react to upload events. -->
<script type="text/javascript">
{literal}
	if ( ! window.console ) console = { log: function(){} };

	var flashObj;
	var delegate = {};
	var resultsLog = "";
	var UploadProgressText = "";
	var UploadProgressTitle = "";

	//KSU handlers

	//This handler checks if the SWF object was loaded or not
	delegate.readyHandler = function()
	{
		flashObj = document.getElementById("uploader"); //do not wrap with jquery $('') or js interface will break
		var pLoad = confirm("Uploader object loaded successfully!\n\nClick 'OK' to continue to the next step.");
		console.log( 'KSU Loaded' );
	}

	//This handler knows when content was selected for upload
	delegate.selectHandler = function()
	{
		$("#resultsLog").append( $('<p>').text('Total size to upload: ' + flashObj.getTotalSize()) );
		if( error = flashObj.getError() ){
			console.log( 'Error '+error );
		}
	}

	//This handler fires when a single file is done uploading
	delegate.singleUploadCompleteHandler = function(args)
	{
		$("#resultsLog").append( $('<p>').text('Upload complete') );
		if( error = flashObj.getError() ){
			console.log( 'Error '+error );
		}
	}

	//This handler fires when all files are done uploading
	delegate.allUploadsCompleteHandler = function()
	{
		$("#resultsLog").append( $('<p>').text('All files are done uploading.') );
		if( error = flashObj.getError() ){
			console.log( 'Error '+error );
		}
	}

	//This handler fires up when the uploaded files are set as entries in the KMC.
	delegate.entriesAddedHandler = function(entries)
	{
		$("#resultsLog").append( $('<p>').text('Completed adding entries.') );
		var txtEntries = "";
		for(var i=0;i<entries.length;i++)
		{
			txtEntries = txtEntries + "* " + entries[i].title + ": " + entries[i].entryId + "\n";
		}
		$("#resultsLog").append( $('<p>').text(txtEntries) );
		if( error = flashObj.getError() ){
			console.log( 'Error '+error );
		}
	}

	//This handler returns the upload progress for each file selected for uploading
	delegate.progressHandler = function(args)
	{
		UploadProgressText = "Uploading - " + args[2].title + ": " + args[0] + " / " + args[1];
		$("#resultsLog").append( $('<p>').text(UploadProgressText) );
	}

	delegate.uiConfErrorHandler = function()
	{
		console.log("uiconf loading error");
	}

	<!--- JavaScript callback methods to activate Kaltura services via the KSU widget.-->
	
	//This function fires the upload
	function upload()
	{
		flashObj.upload();
	}

	function getFiles()
	{
		var files = flashObj.getFiles();
		$("#resultsLog").value = $("#resultsLog").value + "Here are the uploaded files:\n-----------------------------\n";
		for(var i=0;i<files.length;i++)
		{
			$("#resultsLog").value = $("#resultsLog").value + "* " + files[i] + "\n\n";
		}
	}

	//This function connect to the Kaltura networks and adds the uploaded content as entries into the KMC
	function addEntries()
	{
		flashObj.addEntries();
		$("#resultsLog").value = $("#resultsLog").value + "Setting entries. Please wait ... "
	}

	//This function stops all active uploads
	function stopUploads()
	{
		flashObj.stopUploads();
		$("#resultsLog").value = $("#resultsLog").value + "All active uploads stopped.\n\n";
	}

	function removeFilesFromForm()
	{
		var startIndex = parseInt(removeStartIndex.value);
		var endIndex = parseInt(removeEndIndex.value);
		flashObj.removeFiles(startIndex, endIndex)
		console.log(flashObj.getTotalSize());
	}

// setup KSU
	var params = {
		allowScriptAccess: "always",
		allowNetworking: "all",
		wmode: "window"
	};
	var attributes = {
		id: "uploader",
		name: "KUploader"
	};
	// set flashVar object
	// conversionMapping: "pdf: 3177041; flv: 3177041",
 
	{/literal}
	var flashVars = {ldelim}
		uid: "{$userId}",
		partnerId: "{$partnerId}",
		entryId: -1,
		ks: "{$ks}",
		uiConfId: "{$uiconfId}",
		conversionProfile: "{$conversionProfileId}",
		//conversionMapping: "pdf,doc,docx: 3177041; flv,mp4,m4v: 493041",
		browseImgSrc: "./templates/images/browseBtn.png",
		browseBtnName: "browse",
		jsDelegate: "delegate" 
	{rdelim};
	
	swfobject.embedSWF("http://www.kaltura.com/kupload/ui_conf_id/{$uiconfId}", "uploader", "180", "20", "9.0.0", "expressInstall.swf", flashVars, params, attributes);
</script>



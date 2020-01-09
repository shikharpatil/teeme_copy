(function(window){

  var WORKER_PATH = baseUrl+'froala_editor/assets/js/recorderWorker.js';
  var encoderWorker = new Worker(baseUrl+'froala_editor/assets/js/mp3Worker.js');

  var Recorder = function(source, cfg){
    var config = cfg || {};
    var bufferLen = config.bufferLen || 4096;
    var numChannels = config.numChannels || 2;
    this.context = source.context;
    this.node = (this.context.createScriptProcessor ||
                 this.context.createJavaScriptNode).call(this.context,
                 bufferLen, numChannels, numChannels);
    var worker = new Worker(config.workerPath || WORKER_PATH);
    worker.postMessage({
      command: 'init',
      config: {
        sampleRate: this.context.sampleRate,
        numChannels: numChannels
      }
    });
    var recording = false,
      currCallback;

    this.node.onaudioprocess = function(e){
      if (!recording) return;
      var buffer = [];
      for (var channel = 0; channel < numChannels; channel++){
          buffer.push(e.inputBuffer.getChannelData(channel));
      }
      worker.postMessage({
        command: 'record',
        buffer: buffer
      });
    }

    this.configure = function(cfg){
      for (var prop in cfg){
        if (cfg.hasOwnProperty(prop)){
          config[prop] = cfg[prop];
        }
      }
    }

    this.record = function(){
      recording = true;
    }

    this.stop = function(){
      recording = false;
    }

    this.clear = function(){
      worker.postMessage({ command: 'clear' });
    }

    this.getBuffer = function(cb) {
      currCallback = cb || config.callback;
      worker.postMessage({ command: 'getBuffer' })
    }

    this.exportWAV = function(cb, type){
      currCallback = cb || config.callback;
      type = type || config.type || 'audio/wav';
      if (!currCallback) throw new Error('Callback not set');
      worker.postMessage({
        command: 'exportWAV',
        type: type
      });
    }

	//Mp3 conversion
    worker.onmessage = function(e){
      var blob = e.data;
	  //console.log("the blob " +  blob + " " + blob.size + " " + blob.type);

	  var arrayBuffer;
	  var fileReader = new FileReader();

	  fileReader.onload = function(){
		arrayBuffer = this.result;
		var buffer = new Uint8Array(arrayBuffer),
        data = parseWav(buffer);

        console.log(data);
		console.log("Converting to Mp3");
		//log.innerHTML += "\n" + "Converting to Mp3";

        encoderWorker.postMessage({ cmd: 'init', config:{
            mode : 3,
			channels:1,
			samplerate: data.sampleRate,
			bitrate: data.bitsPerSample
        }});

        encoderWorker.postMessage({ cmd: 'encode', buf: Uint8ArrayToFloat32Array(data.samples) });
        encoderWorker.postMessage({ cmd: 'finish'});
        encoderWorker.onmessage = function(e) {
            if (e.data.cmd == 'data') {

				console.log("Done converting to Mp3");
				//log.innerHTML += "\n" + "Done converting to Mp3";

				/*var audio = new Audio();
				audio.src = 'data:audio/mp3;base64,'+encode64(e.data.buf);
				audio.play();*/

				//console.log ("The Mp3 data " + e.data.buf);
				var usrtagname=window.usrtagname;
				var mp3Blob = new Blob([new Uint8Array(e.data.buf)], {type: 'audio/mp3'});
				uploadAudio(mp3Blob);

				var url = 'data:audio/mp3;base64,'+encode64(e.data.buf);
				//var li = document.createElement('li');
				var p = document.createElement('p');
				var au = document.createElement('audio');
				//var hf = document.createElement('a');
				var hf = document.createElement('span');
				var divclear = document.createElement('div');
				//p.className = "record_list";
				divclear.className = "clrdiv";
				au.controls = true;
				au.src = url;
				//hf.href = url;
				hf.className = "audioRecordTxt";
				hf.download = 'audio_'+usrtagname+'_' + new Date().getTime() + '.mp3';
				hf.innerHTML = hf.download;
				p.appendChild(au);
				//li.appendChild(hf);
				//document.getElementsByClassName("fr-element")[0].appendChild(p);
				
				var audioPlyr='<p><audio controls="true" src='+url+'></audio></p>';
				var audioNameTxt='<p><span class="audioRecordTxt">audio_'+usrtagname+'_' + new Date().getTime() + '.mp3</span></p>';
				//Manoj: get global variable for talk chat box editor
				
				var editorId=window.value;
				//alert(editorId+'==='+usrtagname);
				//$('#popupLoader-'+editorId).hide();
				$('#popupButton1-'+editorId).css("margin-left", "0px");
	  			$('#popupStopped-'+editorId).css("float", "none");
				$('#popupStopped-'+editorId).hide();
				if(editorId != null && typeof editorId != "undefined" && editorId != '')
				{	
					var myButtonId=('myButton-'+editorId);
					//var clss=$('#'+myButtonId).parent(".fr-toolbar").siblings(".fr-wrapper").attr("class");
					var sel, range;
					if (window.getSelection) {
						// IE9 and non-IE
						sel = window.getSelection();
						if (sel.getRangeAt && sel.rangeCount) {
							range = sel.getRangeAt(0);
							range.deleteContents();
				
							// Range.createContextualFragment() would be useful here but is
							// non-standard and not supported in all browsers (IE9, for one)
							var el = document.createElement("div");
							el.innerHTML = audioNameTxt+''+audioPlyr;
							var frag = document.createDocumentFragment(), node, lastNode;
							while ( (node = el.firstChild) ) {
								lastNode = frag.appendChild(node);
							}
							range.insertNode(frag);
							
							// Preserve the selection
							if (lastNode) {
								range = range.cloneRange();
								range.setStartAfter(lastNode);
								range.collapse(true);
								sel.removeAllRanges();
								sel.addRange(range);
							}
						}
					}
					//alert(clss);
					//$('#'+myButtonId).parent(".fr-toolbar").siblings(".fr-wrapper").children( ".fr-element" ).append(hf);
					//$('#'+myButtonId).parent(".fr-toolbar").siblings(".fr-wrapper").children( ".fr-element" ).append(p);
					//$(".talkform"+leafTreeId).find('.fr-element').append(hf);
					//$(".talkform"+leafTreeId).find('.fr-element').append(p);
				}
				else
				{
					if($('.fr-element').is(':empty')) {					
						$(".fr-element").append(hf);
						$(".fr-element").append(p);
					}
					else
					{
						//child exists
						$(".fr-element").children('p').append(hf);
						$(".fr-element").children('p').append(p);	
					}
				}
				
				/*var leafTreeId=window.value;
				//siblings(".selected")
				//alert(leafTreeId);
				if(leafTreeId != null && typeof leafTreeId != "undefined" && leafTreeId != '')
				{
					$(".talkform"+leafTreeId).find('.fr-element').append(hf);
					$(".talkform"+leafTreeId).find('.fr-element').append(p);
					//alert('added');
				}
				else
				{
					if($('.fr-element').is(':empty')) {					
						$(".fr-element").append(hf);
						$(".fr-element").append(p);
					}
					else
					{
						//child exists
						$(".fr-element").children('p').append(hf);
						$(".fr-element").children('p').append(p);	
					}
					
				}*/
				
				//Manoj: code end
				
				//document.getElementsByClassName("fr-element")[0].appendChild(li);
				//addleaf1.appendChild(li);
				//addleaf1.appendChild(divclear);
				

            }
        };
	  };

	  fileReader.readAsArrayBuffer(blob);

      currCallback(blob);
    }


	function encode64(buffer) {
		var binary = '',
			bytes = new Uint8Array( buffer ),
			len = bytes.byteLength;

		for (var i = 0; i < len; i++) {
			binary += String.fromCharCode( bytes[ i ] );
		}
		return window.btoa( binary );
	}

	function parseWav(wav) {
		function readInt(i, bytes) {
			var ret = 0,
				shft = 0;

			while (bytes) {
				ret += wav[i] << shft;
				shft += 8;
				i++;
				bytes--;
			}
			return ret;
		}
		if (readInt(20, 2) != 1) throw 'Invalid compression code, not PCM';
		if (readInt(22, 2) != 1) throw 'Invalid number of channels, not 1';
		return {
			sampleRate: readInt(24, 4),
			bitsPerSample: readInt(34, 2),
			samples: wav.subarray(44)
		};
	}

	function Uint8ArrayToFloat32Array(u8a){
		var f32Buffer = new Float32Array(u8a.length);
		for (var i = 0; i < u8a.length; i++) {
			var value = u8a[i<<1] + (u8a[(i<<1)+1]<<8);
			if (value >= 0x8000) value |= ~0x7FFF;
			f32Buffer[i] = value / 0x8000;
		}
		return f32Buffer;
	}

	function uploadAudio(mp3Data){
		var reader = new FileReader();
		reader.onload = function(event){
			var usrtagname=window.usrtagname;
			var fd = new FormData();
			var mp3Name = encodeURIComponent('audio_'+usrtagname+'_' + new Date().getTime() + '.mp3');
			console.log("mp3name = " + mp3Name);
			fd.append('usrtagname', usrtagname);
			fd.append('fname', mp3Name);
			fd.append('data', event.target.result);
			$.ajax({
				type: 'POST',
				url: baseUrl+'froala_editor/upload_recording.php',
				data: fd,
				processData: false,
				contentType: false
			}).done(function(data) {
				//console.log(data);
				//log.innerHTML += "\n" + data;
			});
		};
		reader.readAsDataURL(mp3Data);
	}

    source.connect(this.node);
    this.node.connect(this.context.destination);    //this should not be necessary
  };

  /*Recorder.forceDownload = function(blob, filename){
	console.log("Force download");
    var url = (window.URL || window.webkitURL).createObjectURL(blob);
    var link = window.document.createElement('a');
    link.href = url;
    link.download = filename || 'output.wav';
    var click = document.createEvent("Event");
    click.initEvent("click", true, true);
    link.dispatchEvent(click);
  }*/

  window.Recorder = Recorder;

})(window);

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset=UTF-8>
  </head>
  <body>
	<div id="mainc">Powered by <a href="https://quran.purwana.net">quran.purwana.net</a> | <a href="https://sites.google.com/view/quran-web-network">quran-web-network</a></div>
	<!--<script type="module" src="/app.js"></script>-->
	<script type="text/javascript">

	function loadIndexData(){
		//console.log(arrIndex,arrSurahNames);
		let htmlBuilder='<ul>';
		arrSurahNames.forEach(function(dataSurah,index){

			htmlBuilder+='<li><h3>'+dataSurah+'</h3><ul>';
			arrIndex[index].forEach(function(dataIndex){
				htmlBuilder+='<li><a href="'+dataIndex+'">'+dataIndex+'</a></li>';
			});
			htmlBuilder+='</ul></li>';

		});
		htmlBuilder+='</ul>';

		document.getElementById('mainc').innerHTML = htmlBuilder;

		document.getElementById('mainc').innerHTML += '<br/> Powered by <a href="https://quran.purwana.net">quran.purwana.net</a> | <a href="https://sites.google.com/view/quran-web-network">quran-web-network</a>';
	}
	
	if ('serviceWorker' in navigator) {
		navigator.serviceWorker.register('/sw.js').then((registration) => {
		console.log('Service worker registration succeeded:', registration);
		console.log('opening:', window.location.origin+window.location.pathname);
		window.open(window.location.origin+window.location.pathname,'_top');

		// At this point, you can optionally do something
		// with registration. See https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration
	  }).catch((error) => {
		console.error(`Service worker registration failed: ${error}`);
	  });
	  /*
		navigator.serviceWorker.ready
		.then(function(registration) {
			navigator.serviceWorker.controller.postMessage({
			  func: 'setbaseLoc',
			  value: window.location.origin
			});
		});*/
	}else{
		console.log('serviceWorker not supported');


		if(window.location.pathname == '/' ){
			let s = document.createElement("script");
			s.src = "/loadindexdata.js";
			document.body.appendChild(s);
		}else{
			fetch('https://quran.purwana.net'+window.location.pathname).then(function(response) {          
			// When the page is loaded convert it to text          
				return response.text()      
			}).then(function(html) {          
				// Initialize the DOM parser          
				var parser = new DOMParser();            
				// Parse the text          
				var doc = parser.parseFromString(html, "text/html");            
				// You can now even select part of that html as you would in the regular DOM           
				// Example:          
				// var docArticle = doc.querySelector('article').innerHTML;            
				console.log(doc);      

				var ayah_translation = doc.querySelector('.ayah-translation').innerHTML;  
				var ayah_tafsir_wrapper = doc.querySelector('.ayah-tafsir-wrapper').innerHTML;  
				
				document.getElementById('mainc').innerHTML = '<a href="/">Beranda</a><br/>'+'<a href="'+window.location.pathname+'">'+ayah_translation+'</a>'+ayah_tafsir_wrapper;
				document.getElementById('mainc').innerHTML += '<br/> Powered by <a href="https://quran.purwana.net">quran.purwana.net</a> | <a href="https://sites.google.com/view/quran-web-network">quran-web-network</a>';
			}).catch(function(err) {            
				console.log('Failed to fetch page: ', err);        
			});
	    }
	}
	</script>  
  </body>
</html>
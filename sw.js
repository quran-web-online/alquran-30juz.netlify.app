
self.addEventListener("fetch", (event) => {
  // Let the browser do its default thing
  // for non-GET requests.
  if (event.request.method !== "GET") return;

  // Prevent the default, and handle the request ourselves.
  event.respondWith(
    (async () => {
	//console.log(self);
	//console.log(self.location);
	//console.log(self.origin);
      //console.log(event.request);
	  //alert(event.request);
	  event.request.mode = "cors";
	  //console.log('baseloc :'+self.origin);	
	  const urlcheck = new URL(event.request.url);
	  //console.log(urlcheck.origin);
	  if(urlcheck.origin == self.origin){
		  if(event.request.url != (self.origin+'/sw.js') && event.request.url != '/sw.js'){
			let new_request = event.request.url.replace(self.origin, "https://quran.purwana.net");
			  //console.log('new request :'+new_request);	
			  // If we didn't find a match in the cache, use the network.
			  return fetch(new_request).then(res => {
				//console.log(...res.headers);
				//console.log(res.getHeader("location"));
				//console.log(res.headers.get('location'));
				let request_path = event.request.url.replace(self.origin, "");
				let request_resp_path = res.url.replace("https://quran.purwana.net", "");
				//console.log('request_path url:'+request_path+',request_resp_path:'+request_resp_path);
				
				if(request_path != request_resp_path){
					  event.waitUntil(self.clients.claim().then(() => {
						// See https://developer.mozilla.org/en-US/docs/Web/API/Clients/matchAll
						return self.clients.matchAll({type: 'window'});
					  }).then(clients => {
						return clients.map(client => {
						  // Check to make sure WindowClient.navigate() is supported.
						  if ('navigate' in client) {
							return client.navigate(request_resp_path);
						  }
						});
					  }));
				}
				return res;
				
			  });
		  }else{
			return fetch(event.request);
		  }
	  }else{
		event.request.mode = "no-cors";
		return fetch(event.request);
	  }	
    })()
  );
});
/*
self.addEventListener('message',  (event) => {
  // event is an ExtendableMessageEvent object
  //console.log(`The client sent me a message: ${event.data}`);
  if(event.data.func=='setbaseLoc'){
    baseloc = event.data.value;
  }
});*/
(function(undefined){
    var PREPHERO_AUTH_URL="https://dev.prephero.com/PrepHero/v1?method=authorize&return=json";
    var PREPHERO_CLIENT_ID="testjs";
    var accesstoken="";
    var prephero = {
        authenticate: function() {
	       var req = {
	         "authUrl" : PREPHERO_AUTH_URL,
	         "clientId" : PREPHERO_CLIENT_ID,
	         "scopes" : [],
	       };
	       console.log(req);
	       oauth2.login(req, function(token) {
	         console.log("Got an OAuth token:\n" + token + "\n"
	             + "Token expires in " + oauth2.expiresIn(req) + " ms\n");
	             accesstoken = token;
	             
	       }, function(error) {
	         console.log("Error:\n" + error);
	       });
	     },
	     
	   clearTokens: function() {
    	     oauth2.clearAllTokens;
    	     accesstoken='';
    	   },
    
    	   
         getRefreshToken: function() {
             
         },
         getUserInfo: function() {
	            $.ajax({
	                url: 'https://dev.prephero.com/PrepHero/v1?method=accessresources&return=json&access_token=' + accesstoken,
	                data: null,
	                success: function(resp) {
	                    user    =   resp;
	                    console.log(user);
	                },
			error: function(jqXHR, textStatus, errorThrown){
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
					},
	                dataType: "jsonp"
	            });
	        },
	revokeAccess: function() {
		$.ajax({
			url: 'https://dev.prephero.com/PrepHero/v1?method=revokeaccess&return=json&access_token=' + accesstoken,
			data:null,
			success: function(resp) {
				prephero.clearTokens();
				console.log(resp);
			},
			error: function(jqXHR, textStatus, errorThrown){
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
					},
			dataType: "jsonp"
		})
	}
    }; 
    window.prephero = prephero;
})();


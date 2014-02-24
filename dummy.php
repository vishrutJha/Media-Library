<!DOCTYPE HTML>
<head></head>
<body>
<div style="margin-left:120px; float:left" class="navbar" id="fb-root"></div>

<link href="static/css/bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="static/js/jquery.js"></script>
<script type="text/javascript" src="static/js/jquery.dataTables.js"></script>
<script>

var people = new Array();

function hideButton(element){
document.getElementById(element).style.display = "none";
} 

function showButton(element){
document.getElementById(element).style.display = "block";
}

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '524282397585156', // App ID
    channelUrl : 'http://localhost/channel.html', // Channel File
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true,  // parse XFBML
    authResponse:true
  });


FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    // the user is logged in and has authenticated your
    // app, and response.authResponse supplies
    // the user's ID, a valid access token, a signed
    // request, and the time the access token 
    // and signed request each expire
    var uid = response.authResponse.userID;
    var accessToken = response.authResponse.accessToken;
  } else if (response.status === 'not_authorized') {
    // the user is logged in to Facebook, 
    // but has not authenticated your app
  } else {
    // the user isn't logged in to Facebook.
	hideButton('logout');
  }
 });




  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
  // for any authentication related change, such as login, logout or session refresh. This means that
  // whenever someone who was previously logged out tries to log in again, the correct case below 
  // will be handled. 
  FB.Event.subscribe('auth.authResponseChange', function(response) {
    // Here we specify what we do with the response anytime this event occurs. 
    if (response.status === 'connected') {
      // The response object is returned with a status field that lets the app know the current
      // login status of the person. In this case, we're handling the situation where they 
      // have logged in to the app.
   	 testAPI();
    } else if (response.status === 'not_authorized') {
      // In this case, the person is logged into Facebook, but not into the app, so we call
      // FB.login() to prompt them to do so. 
      // In real-life usage, you wouldn't want to immediately prompt someone to login 
      // like this, for two reasons:
      // (1) JavaScript created popup windows are blocked by most browsers unless they 
      // result from direct interaction from people using the app (such as a mouse click)
      // (2) it is a bad experience to be continually prompted to login upon page load.
      FB.login();
// FB.login(function(response) {
   // handle the response
//ii }, {scope: 'email,user_birthday,user_religion_politics'});
    } else {
      // In this case, the person is not logged into Facebook, so we call the login() 
      // function to prompt them to do so. Note that at this stage there is no indication
      // of whether they are logged into the app. If they aren't then they'll see the Login
      // dialog right after they log in to Facebook. 
      // The same caveats as above apply to the FB.login() call here.
      FB.login();
// FB.login(function(response) {
   // handle the response
// }, {scope: 'email,user_birthday,user_religion_politics'});
  
  }
  });
 }


function populateFields(data){

console.log(data);
for(var x in data){
	var holder = document.getElementById("public_data");
	var content = '<div class="row-fluid"><div class="span5"><label>'+x+'</label></div><div class="span7"><input id="name" value="'+data[x]+'"></div></div>';
	//console.log(content);
	holder.innerHTML += content;
}
showButton('logout');
//for(stuff in data){
//	document.getElementById("asscheek").innerHTML+=stuff+"<br>";
//}
}
//function FB.logout(function(response){
//person logged out
//});

//document.getElementById("logout").onclick=" FB.logout";



  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));
  // Here we run a very simple test of the Graph API after login is successful. 
  // This testAPI() function is only called in those cases. 
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
     console.log('Good to see you, ' + response.name + '.');
      console.log(response);
      populateFields(response);
      getTheData(response);
    });

}


function populateMe(userint,uid,uname){

console.log("My Interests are:");
console.log(userint,uid);
var user = new Array();
user.push({"name":uname, "id":uid});
var movies = new Array();
for(i in userint){
	movies.push({"name":userint[i]["name"], "id":userint[i]["id"]});
}
user.push({"movies":movies})
senUser = JSON.stringify(user);
console.log("The user is"+senUser);
post_data(senUser);

}


function getMusic(person,id){


	FB.api('/'+id+'/music', function(response) {
	
		var music = new Array();
		var tbody = document.getElementById("taby");
		console.log(response.data);
		tbody.innerHTML += '<td>'; 
		for(d in response.data){
			console.log(response.data[d]["name"]);
			music.push({"name":response.data[d]["name"], "id": response.data[d]["id"]}) ;
			tbody.innerHTML += "\""+response.data[d]["name"] + "\"  ";
		}
		tbody.innerHTML += '</td>';
		
		person.push({"music":music});
		sendata = JSON.stringify(person);
		console.log("sending "+sendata);
		post_data(sendata);
	});
}			

function getInterests(person,id){


	FB.api('/'+id+'/movies', function(response) {
	
		var movies = new Array();
		var tbody = document.getElementById("taby");
		console.log(response.data);
		tbody.innerHTML += '<td>'; 
		for(d in response.data){
			console.log(response.data[d]["name"]);
			movies.push({"name":response.data[d]["name"], "id": response.data[d]["id"]}) ;
			tbody.innerHTML += "\""+response.data[d]["name"] + "\"  ";
		}
		tbody.innerHTML += '</td>';
		
		person.push({"movies":movies});
		getMusic(person,id);
//		sendata = JSON.stringify(person);
//		console.log("sending "+sendata);
//		post_data(sendata);
	});
}			

function friends(){
 FB.api('/me/friends', function(response) {
	
	if(response.data){
	    var tbody = document.getElementById("tab-bodyy");
	    if(response.data.length < 10){
		console.log("less than 10 friends");   
		for(i in response.data) { 
 
	    		var person = new Array();
			console.log(response.data);
			tbody.innerHTML += '<tr><td>'+response.data[i]["name"]+'</td><td>'+response.data[i]["id"]+'</td>';       
			friendId = response.data[i]["id"];

			person.push({"id":response.data[i]["id"],"name":response.data[i]["name"]});
			getInterests( person ,friendId);
				
			tbody.innerHTML += '</tr>';
	    	}
	    } else {
		console.log("more than 10 friends");
		for(var i=0;i<10;i++){
			
	    		var person = new Array();
			console.log(response.data);
			tbody.innerHTML += '<tr><td>'+response.data[i]["name"]+'</td><td>'+response.data[i]["id"]+'</td>';       
			friendId = response.data[i]["id"];

			person.push({"id":response.data[i]["id"],"name":response.data[i]["name"]});
			getInterests( person ,friendId);
				
			tbody.innerHTML += '</tr>';
		}
	    }
	    
	    //people = JSON.stringify(people);
	    //post_data(people);
	    //console.log("posting"+people);	 
	} else alert("network error");

 });

}

function getTheData(user){
FB.api('/me/movies', function(response) {
        if(response.data){
          var userint = new Array();

                var tbody = document.getElementById("toby");
    //            var userint = new Array();
                for(i in response.data) {             
                        console.log(response.data);
			console.log("my data is here");
                        userint.push({"name":response.data[i]["name"], "id": response.data[i]["id"]}) ;//pushing user movies into array userint
                       tbody.innerHTML += '<tr><td>'+response.data[i]["name"]+'</td><td>'+response.data[i]["id"]+'</td>                                                  <td>'+response.data[i]["category"]+'</td></tr>';
                }
                setDataTable();
        } else {
            alert("Error!");  
        }
  populateMe(userint,user.id,user.name);

  user = {id:user.id, name:user.name};
  setUser(user);

//  friends();
  alert("all operations done");
});
}

function dopost(data,url){

	 $.ajax({
		type: "POST",
		url: url,
		data: {data: data},
		dataType: JSON,
		success: function (data, msg){
			console.log(data);
		}
	}); 
	 
}

function post_data(data){

	url= "http://localhost/monfeed.php";
	dopost(data,url);

}

function setUser(user){

	sendata = {user:user};
	
	console.log("sending user as");

	sendata = JSON.stringify(sendata);
	console.log(sendata);

	url= "http://localhost/session.php";
	dopost(sendata,url);

}

function loggy() {

	FB.logout(function (response) {
		alert("logging out");
		window.location="http://localhost/roo.html";
	});

}

function setDataTable() {
//	alert("attempting datatable");
	$('#example').dataTable();
        $('#exa').dataTable();
        $('#more').dataTable();
}

function viewinterests(){
	window.location.href="http://localhost/interests.php";
}

</script>

<!--
  Below we include the Login Button social plugin. This button uses the JavaScript SDK to
  present a graphical Login button that triggers the FB.login() function when clicked.

  Learn more about options for the login button plugin:
  /docs/reference/plugins/login/ -->

<fb:login-button show-faces="true" width="200" max-rows="1"></fb:login-button>

<div class="container" id="public_data">
<button class="btn btn-primary btn-large" onclick="viewinterests();">Show Interests</button>
</div>

<div class="container mt">
<table class="table table-bordered table-striped mt" id="more">
	<thead>
		<tr>
			<th>Name</th>
			<th>ID</th>
			<th>Category</th>
		</tr>
	</thead>
	<tbody id="toby">
	</tbody>
</table>
</div>

<div class="container mt">
<table class="table table-bordered table-striped mt" id="example">
        <thead>
                <tr>
			<th>name</th>
                        <th>ID</th>
                        <th>Movies</th>
                </tr>
        </thead>
        <tbody id="tab-bodyy">
        </tbody>
</table>
</div>

<div class="container mt">
<table class="table table-bordered table-striped mt" id="exa">
        <thead>
                <tr>
                        <th>Category</th>
                        <th>Name</th>
       	       </tr>
        </thead>
        <tbody id="taby">
        </tbody>
</table>
</div>

<div class="container">
<button class="btn btn-primary btn-large" id="logout"  onclick="loggy()">Logout</button>
</div>

</body>
</html>


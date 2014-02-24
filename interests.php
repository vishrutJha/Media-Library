<html>
<head>
<title>Interests </title>

<link href="static/css/bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="static/js/jquery.js"></script>
<script type="text/javascript" src="static/js/jquery.dataTables.js"></script>
</head>

<script>
document

function populateShit(){

	getData();
}

function getImage(id){

	$.get( "http://graph.facebook.com/"+id+"/picture?redirect=false", function( data ) {
		imgurl = data.data.url;

		var s = $('#'+id);
                s.append("<td><img src="+imgurl+"></img></td>");
	});


}

function populatePeople(people){

	for(i in people){
		if(i!=0){
			person = people[i].person;
			getImage(person.id);
			var s = $('#common-people');
	                s.append("<tr id="+person.id+"><td><h5>"+person.name+"</h5></td></tr>");
		}
                
	}

}

function getData(){
	
	$.get( "monget.php", function( data ) {
		data = JSON.parse(data);
//		console.log(data);
		if(data.length >1 ){
			alert( "Common people found" );
			populatePeople(data);
		} else {
			alert("no people with common intersts");
		}
	});
}

</script>

<body onload="populateShit()">


<div class="container mt" style="margin-top:100px">
	<table id="common-people" class="table table-striped table-hover table-bordered">
	<thead>
	    <th>People with Common Interests</th>
	    <th>pics</th>
	</thead>
	<tbody id="content">
	</tbody>	
	</table>
</div>

</body>



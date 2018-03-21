function printTable(obj){
	var columns = ['id','name','quantity'];
	var myTable='<table><thead><tr class="color"><td colspan="' +columns.length +'">Moja tabelka</td></tr><tr>';
	for(i=0;i<columns.length;i++){
		myTable+='<th>'+columns[i]+'</th>';
	}
	myTable+='</tr></thead><tbody>';
	for (var key in obj){
		myTable+='<tr>';
		for (var new_key in obj[key]){
			myTable+='<td>'+obj[key][new_key]+'</td>';
		}
		myTable+='</tr>';
	}
	myTable+='</tbody></table>';
	return myTable;
}
function printPie(obj){
	var dataPoint = [], array={}, suma=0;
	for (var key in obj){
		suma+=obj[key][2];;
	}
	for (var key in obj){
		var point={};
		point.label = obj[key][1];
		point.y = obj[key][2]*100/suma;
		dataPoint.push(point);
	}
	//array.push({dataPoints : dataPoint});
	array["dataPoints"]=dataPoint;
	//var myJsonString = JSON.stringify(yourArray);
	var chart = new CanvasJS.Chart("my_table", {
		animationEnabled: false,
		data: [{
			type: "pie",
			startAngle: 240,
			yValueFormatString: "##0.00\"%\"",
			indexLabel: "{label} {y}",
			dataPoints: array.dataPoints
		}]
	});
	chart.render();
}
function printTableFromArray(obj){
	var columns = ['name','quantity'];
	var myTable='<table><thead><tr class="color"><td colspan="' +columns.length +'">Moja tabelka</td></tr><tr>';
	for(i=0;i<columns.length;i++){
		myTable+='<th>'+columns[i]+'</th>';
	}
	myTable+='</tr></thead><tbody>';
	for (i=0;i<obj.length;i++){
		myTable+='<tr>';
		
		for (j=0;j<obj[i].length;j++){
			myTable+='<td>'+obj[i][j]+'</td>';
		}
		myTable+='</tr>';
	}
	myTable+='</tbody></table>';
	return myTable;
}
function isInt(value) {
	return !isNaN(value) && parseInt(Number(value)) == value && !isNaN(parseInt(value, 10));
}
function checkName(name){
		return name.replace(/ /g,'')!='' && /^[a-zA-Z]+$/.test(name.replace(/ /g,''));
}
$(document).ready(function(){
	$('#getTable').click(function(){
		var get_table = true;
		$.ajax({
			type:'POST',
			url:'ajax.php',
			dataType: "json",
			data:{get_table:get_table},
			success:function(data){
				if(data.status == true){
					document.getElementById('my_table').innerHTML = printTable(data.result);
					document.getElementById('message').innerHTML = '<span class="label label-success">SUCCESS!</span>';
					$('.user-content').slideDown();
				}else{
					document.getElementById('message').innerHTML = '<span class="label label-danger">'+data.result+'</span>';
					$('.user-content').slideUp();
					//alert("User not found...");
				} 
			}
		});
	});
$(document).ready(function(){
	$('#read').click(function(){
			getNames();
				setTimeout(function(){
				document.getElementById("container").innerHTML=printTableFromArray(myArray);
			}, 20);
		});
	});
	$('#insert').click(function(){
		var name = $('#name').val();
		var quantity = $('#quantity').val();
		var message;
		if(!checkName(name) || !isInt(quantity)){
			$('#message').text('Name or quantity is incorrect!');
		}else {
			$.ajax({
				type:'POST',
				url:'ajax.php',
				dataType: "json",
				data:{name:name, quantity:quantity},
				success:function(data){
					if(data.status == true){
						//message = 'data';
						document.getElementById('message').innerHTML = data.result;
						$('.user-content').slideDown();
					}else{
						document.getElementById('message').innerHTML = '<span class="label label-danger">'+data.result+'</span>';
						alert('Data is save localy.');
						$('.user-content').slideUp();
						add(name, quantity);
					} 
				}
			});
		}
	});
	var howMany=0;
	$('#push').click(function(){
		getNames();
		var a = myArray;
		
		setTimeout(function(){
				
			
		//alert('elo');
		if(myArray.length!=0) {
			for(i =0;i<myArray.length;i++) {
				//alert(myArray[i]);
				var name = myArray[i][0];
				$.ajax({
					type:'POST',
					url:'ajax.php',
					dataType: "json",
					data:{name:myArray[i][0], quantity:myArray[i][1]},
					success:function(data){howMany++;
						if(data.status == true){
							//message = 'data';
							$('#message').text(data.result);
							document.getElementById('message').innerHTML = '<span class="label label-success">Success!</span>';
							$('.user-content').slideDown();
							remove(name);
						}else{
							//add(name, quantity);
							document.getElementById('message').innerHTML = '<span class="label label-danger">'+data.result+'</span>';
							$('.user-content').slideUp();
							
							//break;
						} 
					}
				});
			}
		}else {
			document.getElementById('message').innerHTML = '<span class="label label-warning">Local db is empty</span>';
		}
			}, 2);
	});
});
$(document).ready(function(){
	$('#pie').click(function(){
		var get_table = true;
		$.ajax({
			type:'POST',
			url:'ajax.php',
			dataType: "json",
			data:{get_table:get_table},
			success:function(data){
				if(data.status == true){
					printPie(data.result);
					document.getElementById('message').innerHTML = '<span class="label label-success">SUCCESS!</span>';
					$('.user-content').slideDown();
				}else{
					document.getElementById('message').innerHTML = '<span class="label label-danger">'+data.result+'</span>';
					$('.user-content').slideUp();
					//alert("User not found...");
				} 
			}
		});
	});
});
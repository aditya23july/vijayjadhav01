// JavaScript Document

$(document).ready(function(){
	
		$(document).on('click', "#add-tbl-data1", function () {
			
			
				var x = document.getElementById("myTable1").rows.length;
			
			
				var row = myTable1.insertRow(x--);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				
				
				
				cell1.innerHTML = '';
				cell2.innerHTML = '<select class="form-control"><option>Select</option><option>Tiomos</option><option>Nexis</option><option>Special hinges</option><option>Single-joint hinges</option><option>Connectors</option> <option>Cabinet suspension fittings</option> <option>Nova Pro</option> <option>Nova Pro Scala</option> <option>DWD XP</option> <option>Dynapro</option> <option>Dynamoov</option> <option>Dynamic NT</option> <option>Vionaro</option> <option>Integra Top</option> <option>Roller slides</option> <option>Product Overview</option> <option>Quaturis 75</option> <option>Quaturis S</option> <option>Kinvaro</option> <option>Lift-up flap systems</option> <option>Lift-up flap systems</option> <option>Folding flap system</option> <option>Parallel lift flap system</option> <option>Product overview</option> <option>Kinvaro configurator</option> <option>Up-and-over flap system</option> <option>Hinge Systems</option> <option>Drawer Presses</option> <option>Sensomatic</option> <option>Soft-close</option> <option>Tipmatic</option> <option>Tavinea 91</option> </select>';
				cell3.innerHTML = '<select class="form-control"> <option>Select</option> <option>1-2 Lac</option> <option>2-3 Lac</option> <option>3-4 Lac</option> </select>';
				
				cell4.innerHTML = '<select class="form-control">  <option>Select</option>  <option>10%</option>  <option>20%</option>  <option>30%</option>  </select>';
				cell5.innerHTML = '<span class="delete-span"><i class="fa fa-trash delete-icon" aria-hidden="true" onclick="getId1(this)"></i></span>';
				
											
			
			
		});
		
		
		$(document).on('click', "#add-tbl-data2", function () {
			
			
				var x = document.getElementById("myTable2").rows.length;
			
			
				var row = myTable2.insertRow(x--);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				
				
				
				cell1.innerHTML = '';
				cell2.innerHTML = '<select class="form-control"><option>Select</option><option>Tiomos</option><option>Nexis</option><option>Special hinges</option><option>Single-joint hinges</option><option>Connectors</option> <option>Cabinet suspension fittings</option> <option>Nova Pro</option> <option>Nova Pro Scala</option> <option>DWD XP</option> <option>Dynapro</option> <option>Dynamoov</option> <option>Dynamic NT</option> <option>Vionaro</option> <option>Integra Top</option> <option>Roller slides</option> <option>Product Overview</option> <option>Quaturis 75</option> <option>Quaturis S</option> <option>Kinvaro</option> <option>Lift-up flap systems</option> <option>Lift-up flap systems</option> <option>Folding flap system</option> <option>Parallel lift flap system</option> <option>Product overview</option> <option>Kinvaro configurator</option> <option>Up-and-over flap system</option> <option>Hinge Systems</option> <option>Drawer Presses</option> <option>Sensomatic</option> <option>Soft-close</option> <option>Tipmatic</option> <option>Tavinea 91</option> </select>';
				cell3.innerHTML = '<select class="form-control"> <option>Select</option> <option>1-2 Lac</option> <option>2-3 Lac</option> <option>3-4 Lac</option> </select>';
				
				cell4.innerHTML = '<select class="form-control">  <option>Select</option>  <option>10%</option>  <option>20%</option>  <option>30%</option>  </select>';
				cell5.innerHTML = '<span class="delete-span"><i class="fa fa-trash delete-icon" aria-hidden="true" onclick="getId2(this)"></i></span>';
				
											
			
			
		});
		
		
		$(document).on('click', "#add-tbl-data3", function () {
			
			
				var x = document.getElementById("myTable3").rows.length;
			
			
				var row = myTable3.insertRow(x--);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				
				
				
				
				
				cell1.innerHTML = '<select class="form-control">  <option>Select</option>  <option>Brochure 1</option>  <option>Brochure 2</option>  <option>Brochure 3</option>  </select>';
				cell2.innerHTML = '<a href="" style="display:block;text-align: center;"><i class="fa fa-search-plus" aria-hidden="true"></i></a>';
				cell3.innerHTML = '<span class="delete-span"><i class="fa fa-trash delete-icon" aria-hidden="true" onclick="getId3(this)"></i></span>';
				
				
											
			
			
		});
		
		
		$(document).on('click', "#add-tbl-data4", function () {
			
			
				var x = document.getElementById("myTable4").rows.length;
			
			
				var row = myTable4.insertRow(x--);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				
				
				
				
				
				cell1.innerHTML = '<select class="form-control"><option>Select</option><option>Tiomos</option><option>Nexis</option><option>Special hinges</option><option>Single-joint hinges</option><option>Connectors</option> <option>Cabinet suspension fittings</option> <option>Nova Pro</option> <option>Nova Pro Scala</option> <option>DWD XP</option> <option>Dynapro</option> <option>Dynamoov</option> <option>Dynamic NT</option> <option>Vionaro</option> <option>Integra Top</option> <option>Roller slides</option> <option>Product Overview</option> <option>Quaturis 75</option> <option>Quaturis S</option> <option>Kinvaro</option> <option>Lift-up flap systems</option> <option>Lift-up flap systems</option> <option>Folding flap system</option> <option>Parallel lift flap system</option> <option>Product overview</option> <option>Kinvaro configurator</option> <option>Up-and-over flap system</option> <option>Hinge Systems</option> <option>Drawer Presses</option> <option>Sensomatic</option> <option>Soft-close</option> <option>Tipmatic</option> <option>Tavinea 91</option> </select>';
				cell2.innerHTML = '<select class="form-control"> <option>Select</option> <option>1-2 Lac</option> <option>2-3 Lac</option> <option>3-4 Lac</option> </select>';
				
				cell3.innerHTML = '<select class="form-control">  <option>Select</option>  <option>10%</option>  <option>20%</option>  <option>30%</option>  </select>';
				cell4.innerHTML = '<span class="delete-span"><i class="fa fa-trash delete-icon" aria-hidden="true" onclick="getId4(this)"></i></span>';
				
											
			
			
		});
		
		
		$(document).on('click', "#add-tbl-data5", function () {
				$('#myTable6').fadeIn('slow');
			
				var x = document.getElementById("myTable6").rows.length;
				
			
				var row = myTable6.insertRow(x--);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				
				
				
				
				
				cell1.innerHTML = '<span >' + $("#target  :selected").text() + '</span>';
				cell2.innerHTML = '<span >' + $("#type  :selected").text() + '</span>';
				
				cell3.innerHTML = '<span >' + $("#state  :selected").text() + '</span>';
				
				cell4.innerHTML = '<span >' + $("#city  :selected").text() + '</span>';
				
				cell5.innerHTML = '<span class="delete-span"><i class="fa fa-trash delete-icon" aria-hidden="true" onclick="getId5(this)"></i></span>';
				
											
			
			
		});
		
		
		$(document).on('click', "#add-tbl-data7", function () {
				
				
			
				var x = document.getElementById("myTable7").rows.length;
				
			
				var row = myTable7.insertRow(x--);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
			
				
				
				
				
				
				cell1.innerHTML = '<input type="file">';
				cell2.innerHTML = '<span class="delete-span" style="height:42px;padding-top: 12px;"><i class="fa fa-trash delete-icon" aria-hidden="true" onclick="getId7(this)"></i></span>';
				
				cell3.innerHTML = '';
				
				
											
			
			
		});
		
		

	
	
});

		function  getId1(element) {
			
           var x=element.parentNode.parentNode.parentNode.rowIndex;
		   document.getElementById("myTable1").deleteRow(x);
        }
		
		function  getId2(element) {
			
           var x=element.parentNode.parentNode.parentNode.rowIndex;
		   document.getElementById("myTable2").deleteRow(x);
        }
		
		function  getId3(element) {
			
           var x=element.parentNode.parentNode.parentNode.rowIndex;
		   document.getElementById("myTable3").deleteRow(x);
        }
		
		function  getId4(element) {
			
           var x=element.parentNode.parentNode.parentNode.rowIndex;
		   document.getElementById("myTable4").deleteRow(x);
        }
		
		function  getId5(element) {
			
           var x=element.parentNode.parentNode.parentNode.rowIndex;
		   document.getElementById("myTable6").deleteRow(x);
        }
		
		function  getId7(element) {
			
           var x=element.parentNode.parentNode.parentNode.rowIndex;
		   document.getElementById("myTable7").deleteRow(x);
        }
		
		function  getId8(element) {
			
           document.getElementById('attachment1').value= null;
        }
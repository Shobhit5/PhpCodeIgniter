<html>
<head>
<meta content="width=device-width, initial-scale=1" name="viewport"/>       
        <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/1.12.4jquery.min.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js" ></script>
</head>
<body>	
	
	<div class="container">
		<div class="row">
			<form method="POST" id="import_form" enctype="multipart/form-data">				
			<h3>Select Excel File</h3>
		</div>
		<div class="row">
			<div class="col-sm-3">
					<input type="file" name="file" id="file" required accept=".xls, .xlsx"/>
			</div>
			<div class="col-sm-4">
					<input type="submit" name="import" value="Import" class="btn btn-info btn-sm">
			</div>
		</div>
			</form>
			<br/>
			<br/>
			<div class="row">
			<h3>Excel Sheet Data</h3>
			</div>
	</div>
	<div id="customer_data" class="container">
	</div>
</body>
</html>
<script>

$(document).ready(function(){
	
	load_data();	
	
	function load_data()
	{
		$.ajax({
			url:"readfile/fetch",
			method:"POST",
			success:function(data)
			{
				$('#customer_data').html(data);
			}
		})
	}	
	
	$('#import_form').on('submit',function(event){
		event.preventDefault();
		
		$.ajax({
			url:"readfile/import",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success:function(data)
			{
				$('#file').val('');
				load_data();
				alert(data);
			}
		})
	});
});
</script>

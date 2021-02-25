<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="icon" href="../../favicon.ico">
	    <title>Ajax</title>
	    <link rel="stylesheet" type="text/css" href="css/main.css">
	    <!-- Bootstrap core CSS -->
	    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
	    <link href="css/bootstrap.min.css" rel="stylesheet">
  	</head>
  	<body>
	    <nav class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Menu</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#">Ajax</a>
	        </div>
	        <div id="navbar" class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
	            <li class="active"><a href="#">Home</a></li>
	            <li><a href="#">About</a></li>
	            <li><a href="#">Contact</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>
	    <div class="container box-style">
	    	<div class="add-user">
	    		<button type="button" id="add_user" data-toggle="modal" data-target="#addmodal" class="btn btn-info btn-lg">Add new user</button>
	    	</div>
			<div class="table-responsive">
				<table id="user_tbl" class="table table-bordered table-striped display">
					<thead>
						<tr>
							<th>#</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Email</th>
							<th>Age</th>
							<th>Image</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>		
				</table>
			</div>
		</div><!-- /.container -->
		<div class="container">
			<div id="addmodal" class="modal fade">
				<div class="modal-dialog">
					<form method="POST" id="user_form" enctype="multipart/form-data">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Add New User</h4>
							</div>
							<div class="modal-body">
								<div class="form-group">
								    <label for="firstname">First Name</label>
								    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Please enter your first name!">
								</div>
								<div class="form-group">
								    <label for="lastname">Last Name</label>
								    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Please enter your last name!">
								</div>
								<div class="form-group">
								    <label for="email">Email Address</label>
								    <input type="email" class="form-control" name="email" id="email" placeholder="Please enter your email!">
								</div>
								<div class="form-group">
								    <label for="age">Age</label>
								    <input type="text" class="form-control" name="age" id="age" placeholder="Please enter your age!">
								</div>
								<div class="form-group">
								    <label for="userimage">Image User</label>
								    <input type="file" class="form-control" name="userimage" id="userimage">
								</div>
								<span id="user_upload_image"></span>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="user_id" id="user_id">
								<input type="hidden" name="operation" id="operation">
								<input type="submit" class="btn btn-success" name="action" id="action" value="Add">
								<input type="reset" class="btn btn-danger" value="Reset">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.container -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
		<!-- ================ npm javascript ================ -->
	    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js"></script>
		<!-- ================ Bootstrap core JavaScript ================ -->
	    <script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
	    <script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" language="javascript">
	    	$(document).ready(function(){
			    var dataTable = $('#user_tbl').DataTable({
			        "processing":true,
					"serverSide":true,
     				"order": [],
					"ajax":{
						url:"fetch.php",
						type:"POST"
					}
			    });

			    $('#add_user').click(function(){		
			    	$('#user_form')[0].reset();
			    	$('.modal-title').text('Add New User');
			    	$('#action').val('Add');
			    	$('#operation').val('Add');
			    	$('#user_upload_image').html('');
			    });

			    $(document).on('submit','#user_form',function(event){
			    	event.preventDefault();
			    	var firstname = $('#firstname').val();
			    	var lastname = $('#lastname').val();
			    	var email = $('#email').val();
			    	var age = $('#age').val();
			    	var ext = $('#userimage').val().split('.').pop().toLowerCase();
			    	if(ext != ''){
			    		if(jQuery.inArray(ext,['jpg','png','tif','jpeg']) == -1){
			    			alert('Invalid Image Selected!');
			    			$('#userimage').val('');
			    			return false;
			    		}
			    	}

			    	if(firstname != '' && lastname != '' && email != '' && age != ''){
			    		$.ajax({
			    			url: "insert.php",
			    			method: "POST",
			    			data: new FormData(this),
			    			contentType: false,
			    			processData: false,
			    			success: function(data){
			    				alert(data);
			    				$('#user_form')[0].reset();
			    				$('#addmodal').modal('hide');
			    				dataTable.ajax.reload();
			    			}
			    		})
			    	}else{
			    		alert('Please Enter All Data Form!');
			    	}
			    });

			    //edit or click update
			    $(document).on('click', '.update', function(){
			    	var user_id = $(this).attr('id');
			    	$.ajax({
			    		url:"fetch_update.php",
			    		method:"POST",
			    		data:{user_id:user_id},
			    		dataType:"json",
			    		success:function(data){
			    			$("#addmodal").modal('show');
			    			$("#firstname").val(data.firstname);
			    			$("#lastname").val(data.lastname);
			    			$("#email").val(data.email);
			    			$("#age").val(data.age);
			    			$("#user_upload_image").html(data.user_image);
			    			$(".modal-title").text("Edit User");
			    			$("#user_id").val(user_id);
			    			$('#action').val('Edit');
			    			$('#operation').val('Edit');
			    		}
			    	});
			    });

			    //delete
			    $(document).on('click', '.delete', function(){
			    	var user_id = $(this).attr('id');
			    	if(confirm("Are you sure you want to delete this record?")){
			    		$.ajax({
			    			url:"delete.php",
			    			method:"POST",
			    			data:{user_id:user_id},
			    			success:function(data){
			    				alert(data);
			    				dataTable.ajax.reload();
			    			}
			    		});
			    	}else{
			    		return false;
			    	}
			    });
			} );
	    </script>
  	</body>
</html>
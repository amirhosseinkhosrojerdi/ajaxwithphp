<?php
//structure ajax

//Enable Ajax feature
$.ajax({
	//Ajax link to file or web service or website
	url:'delete.php',

	//Ajax method GET or POST
	method:'POST',

	//The data we want to send
	data:{Person_id:user_id},

	//Success message
	success:function(values){
		alert(values);
	}
})

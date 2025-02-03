<!DOCTYPE html>
<html>
<head>

	<title>Online Supporting System</title>
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body style="background-color: rgb(63, 65, 59);">


<div class="container-fluid">
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <a href="#" class="navbar-brand" style="margin-left: 8px;">SupportSystem</a>
            <button class="navbar-toggler" type="button" data-toggle ="collapse" data-target="#ccl">
				<span class="navbar-toggler-icon"></span>
			</button>

            <div class="collapse navbar-collapse" id="ccl">
                <ul class="navbar-nav" style="font-size: 15px;">
    
                    <li class="nav-item "><a href="" class="nav-link">Home</a></li>
                   
                </ul>
                <p style="color: cornsilk; margin-left: 350px; margin-top: 5px;"><b>Customer Dashboard</b></p>
            </div>
		 </nav>	
	</div>

    <div class="container">

        <div class="card">

            <div class="card-header">

                <div class="row">

                    <div class="col">

                    <h1 class="lead">Dashboard</h1> 
                    </div>

                    <div class="col">
                    <a href="/" type="button" class="btn btn-primary" style="float: right;">Logout</a>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="col-md-12">
                <table class="table table-striped">
                    <tbody>
                        <tr><th>Name</th><td>{{$customers->name}}</td></tr>
                        <tr><th>Email</th><td >{{$customers->email}}</td></tr>
                        <tr><th>Mobile</th><td >{{$customers->phone}}</td></tr>
                        <tr><th>Reference</th><td>{{$customers->ref}}</td></tr>
                        <tr><th>Status</th><td>{{$customers->sts}}</td></tr>
                        <tr><th>Reply</th><td>{{$customers->msg}}</td></tr>
                    </tbody>
                </table>
                </div>
                
            </div>

        </div>

    </div>

	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
        
</body>
</html>
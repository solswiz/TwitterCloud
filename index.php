<html>
 <head>
    <title>Twitter Challenge</title>
    <script type="text/javascript" src="jquery-1.2.6.min.js"></script>
    <script type="text/javascript" src="jquery.tagcloud.min.js"></script>
    <script type="text/javascript" src="jquery.tinysort.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="application.css" />
    <link rel="stylesheet" type="text/css" href="style_index.css" />
    <link rel="stylesheet" type="text/css" href="common.css" />
    <link rel="stylesheet" type="text/css" href="output.css" />

    <script type="text/javascript">
      $(function(){
      console.log("binding tag cloud");
      $('#xpower').tagcloud({type:'sphere',height:500,sizemin:12,sizemax:100,power:.6,colormin:"f81908",colormax:"2f29ff"});
      });
    </script>

  </head>

 <body>
    <div class="container-fluid">
      <div class="row-fluid">
	<div class="span6">
	  <img src="thecloud.png" />
	</div>

	<div class="span6" >
		

	</div>
	<div class="row-fluid twitter-form">
      
      <form id="process-twitter-handle" action="test.php" method="POST">
        Twitter handle: @ <input type="text" name="handle" value="" /><br />
      	<input class="btn btn-large btn-danger" id="submit_button" type="submit"
      	value="Generate Cloud" />
        <input id="user_timeline" name="user_timeline" type="hidden" />
      </form>

</div>
      </div>
     
      <div class="row-fluid">
        <div class="span12">

        </div>
      </div>
</div>

</body>
</html>

<html>
 <head>
    <title>Twitter Challenge</title>
    <script type="text/javascript" src="jquery-1.2.6.min.js"></script>
    <script type="text/javascript" src="jquery.tagcloud.min.js"></script>
    <script type="text/javascript" src="jquery.tinysort.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap.css" />
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
	
      </div>
      
      <div class="row-fluid">
        <div class="span12">
	<div class="cloud">
	  <ul id = "xpower" class="xmpl" >

<?php
error_reporting(0);

//Tweet Count Starts here

$handl=$_POST["handle"];
$tjson = file_get_contents("http://twitter.com/status/user_timeline/".$handl.".json?count=1000", true);
$str = json_decode($tjson, true); 

$fl=array();
$t_count = count($str);

$k_e=0;

 for($k=0;$k<$t_count;$k++)
  {

	
	$words = explode(" ", $str[$k][text]);

	$flo = count($words);
	$flo1=$flo;

	for($ck=0;$ck<$flo1;$ck++)
		{
			if($words[$ck]=="")
			{
				$flo--;
			}

		}
	
	$fl[$k][cnt]=$flo;
	$fl[$k][rpt]=1;

	if(isset($str[$k][in_reply_to_user_id_str])||isset($str[$k][in_reply_to_status_id_str]))
	{

	$fl[$k][cnt]=0;
	$fl[$k][rpt]=0;
	
	}
	
	$k_e=$k;
  }

//Tweet Count Ends Here


//Re-tweet Count Starts here

$tjson1 = file_get_contents("http://api.twitter.com/1/statuses/retweeted_by_user.json?screen_name=".$handl."&count=40", true);
$strh1 = json_decode($tjson1, true);
$t_count1 = count($strh1);
$t_cnt=$t_count+$t_count1;
for($k=0;$k<$t_count1;$k++)
  {

	
	$words = explode(" ", $strh1[$k][retweeted_status][text]);
	
	$flo = count($words);
	$flo1= $flo;
	
	for($ck=0;$ck<$flo1;$ck++)
		{
			if($words[$ck]=="")
			{
				$flo--;
			}

		}
	$kch=$k+$k_e+1;
	$fl[$kch][cnt]=$flo;
	$fl[$kch][rpt]=1;

	if(isset($strh1[$k][retweeted_status][in_reply_to_user_id_str])||isset($strh1[$k][retweeted_status][in_reply_to_screen_name])||isset($strh1[$k][in_reply_to_status_id_str]))
	{

	$fl[$kch][cnt]=0;
	$fl[$kch][rpt]=0;
	
	}

  }

// Re-Tweet Count Ends here

//Array Preparation
 for($k=0;$k<$t_cnt;$k++)
	{

		for($j=$k-1;$j>=0;$j--)
		{
			if($fl[$j][cnt]==$fl[$k][cnt]&&$fl[$k][cnt]!=0)
			{
				$fl[$j][rpt]++;
				$fl[$k][cnt]=0;
				$fl[$k][rpt]=0;
			}		

		}
	}


//List Display Starts here  
 for($rt=70;$rt>0;$rt--) 
	{
	    for($r=0;$r<$t_count;$r++)
	     {
		if($fl[$r][rpt]==$rt)
		{
			echo "<li value=".$fl[$r][rpt].">".$fl[$r][cnt]."</li>\n";	
		}
	     }
	}

?>
 </ul>
	</div>
        </div>
      </div>
</div>

</body>
</html>

<!DOCTYPE html>
<?php


//Tweet & Retweet Count Starts here

$handl=$_POST["handle"];
$opts = array(
  'http'=>array(
		'method'=>"GET",
		'header'=>
			"Accept-language: en\r\n".
			"Content-Type: application/json\r\n"

  	    )
	);

$context = stream_context_create($opts);

$tjson = file_get_contents("http://api.twitter.com/1/statuses/user_timeline/".$handl.".json?count=1000", false, $context);
$str = json_decode($tjson, true); 

$tjson = file_get_contents("http://api.twitter.com/1/statuses/retweeted_by_user.json?screen_name=multunus&count=100", false, $context);

$str1 = json_decode($tjson, true);

$p=0;
$fl=array();

$t_count = count($str);
$t_count1=count($str1);
$t_c=$t_count+$t_count1;


	for($i=$t_count;$i<$t_c;$i++)
	{
		$str[$i]=$str1[$p];
		$p++;
	}


	for($k=0;$k<$t_c;$k++)
	  {

		if($k<$t_count)
		{
			$words = explode(" ", $str[$k]['text']);
		}
		else
		{
			$words = explode(" ", $str[$k]['retweeted_status']['text']);			
		}


		$flo = count($words);
		$flo1=$flo;


		for($ck=0;$ck<$flo1;$ck++)
			{
				if($words[$ck]=="")
				{
					$flo--;
				}
	
			}
	
		$fl[$k]['cnt']=$flo;
		$fl[$k]['rpt']=1;

		if(isset($str[$k]['in_reply_to_user_id_str'])||isset($str[$k]['in_reply_to_status_id_str'])||isset($str[$k]['retweeted_status']['in_reply_to_user_id_str'])||isset($str[$k]['retweeted_status']['in_reply_to_screen_name'])||isset($str[$k]['in_reply_to_status_id_str']))
			{
	
				$fl[$k]['cnt']=0;
				$fl[$k]['rpt']=0;
	
			}

	

	  }

//Tweet & Retweet Count Ends Here




//Array Preparation

$max=0;

 for($k=0;$k<$t_c;$k++)
	{

		for($j=$k-1;$j>=0;$j--)
		{
			if($fl[$j]['cnt']==$fl[$k]['cnt']&&$fl[$k]['cnt']!=0)
			{
				$fl[$j]['rpt']++;
				$fl[$k]['cnt']=0;
				$fl[$k]['rpt']=0;

				if($max < $fl[$j]['rpt'])
					{
					 	$max = $fl[$j]['rpt'];

					}
			
			}		

		}

		
	}

?>
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
//List Display Starts here  

 for($rt=$max;$rt>0;$rt--) 
	{
	    for($r=0;$r<$t_count;$r++)
	     {
		if($fl[$r]['rpt']==$rt)
		{
			echo "<li value=".$fl[$r]['rpt'].">".$fl[$r]['cnt']."</li>\n";	
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

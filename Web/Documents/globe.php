<?php
	require_once("../database_access.php");
	$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
	if(!$connection){
		die("Could not connect to database server" );
	}
	$sql = "SELECT `End` FROM NFDRS_Runs ORDER BY RunID DESC LIMIT 1"; //select the last run in the database
	$result = mysqli_query($connection, $sql);
	if(!$result){
		die("Could not complete database query.  Error: " . mysqli_error($connection));
	}else{
		$data = mysqli_fetch_assoc($result);
	}
	$completeDate = $data['End'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <script src="../Cesium/Cesium.js"></script>
    <style>
      @import url(../Cesium/Widgets/widgets.css);
      #cesiumContainer {
        margin: 0;
        height: 100% !important;
        padding: 0;
        font-family: sans-serif;
      }
      html {
        height: 100%;
        
      }
      #holder{
      	height:100%;
      	padding: 0%;
      	margin: 0%;
      	background-color: black;
      }
      #legend{
      	padding: 0%;
      	margin: 0%;
      	height: 100%;
      	background-color: black;
      	color: white;
      	overflow: auto;
      }

      body{
        padding: 0px;
        margin: 0px;
        height: 100%;
        background-color: black;
      }
      .glyphicon{
      	float: right;
      }
      .legendBox{
      	display: inline-block;
      	height: 25px;
      	width: 25px;
      	margin-left: 20px;
      	outline-width: 1px;
      	outline-color: black;
      	outline:groove;
      	overflow-y:visible;
      }
      #lowBox{
      	background-color: #4caeea;
      }
      #midBox{
      	background-color: #b9ea4c;
      }
      #highBox{
      	background-color: #f5f648;
      }
      #extremeBox{
      	background-color: #f69748;
      }
      #catBox{
      	background-color: red;
      }
      .legendLabel{
      	margin-left: 10px;
      }
      footer{
      	margin-left:10px;
      	text-align: left;
      	float: left;
      }
      #updateDate{
      	margin-bottom: 25px;
      }
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.line {
  fill: none;
  stroke: steelblue;
  stroke-width: 1.5px;
}
      
    </style>
		<title>Current Fire Behavior</title>
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	    <!-- Custom Theme files -->
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56435949-1', 'auto');
  ga('send', 'pageview');

</script>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
  </head>
<body>	
  <div class='row col-sm-12' id='holder'>
  	<div id="cesiumContainer" class='col-sm-10'></div>
  	<div id='legend' class='col-sm-2'>
  		<i id='linkView'><a href='map.php'>Trouble viewing this page?</a></i>
  		<h3 class='page-header' id='legendTitle'>Characteristic Fire Danger</h3>
  		<strong class='text-muted' id='updateDate'>Updated: <?php echo $completeDate?></strong><br />
  	<span id='lowBox' class='legendBox'></span><span id='lowLabel' class='legendLabel'>Low</span><br />
  	<span id='midBox' class='legendBox'></span><span id='midLabel' class='legendLabel'>Medium</span><br />
  	<span id='highBox' class='legendBox'></span><span id='highLabel' class='legendLabel'>High</span><br />
  	<span id='extremeBox' class='legendBox'></span><span id='highLabel' class='legendLabel'>Very High</span><br />
  	<span id='catBox' class='legendBox'></span><span id='highLabel' class='legendLabel'>Extreme</span><br />
  	<div id='paddBox'></div>
  	<h5 class='page-header'>Map Options</h5>
  	<label class='checkbox-inline'>Today's Fire Danger</label><input type='radio' id='showTodayButton' name='showLayer' checked="true" value="today"></br />
  	<label class='checkbox-inline'>Tomorrow's Forecast Danger</label><input type='radio' id='showTomorrowButton' name='showLayer' value="tomorrow"><br />
  	<label class='checkbox-inline'>Opacity</label><input type='range' id='setOpacity' value="0.5" max='1' min='0' step="0.01"></br>
  	<label class="checkbox-inline">Show Streets: </label><input type='checkbox' id='showStreetsButton' name='showStreets'><br />
  	<button id='showHistory' class='btn btn-primary' data-toggle='modal' data-target='#historyModal'>Show Weekly History</button>
  	<button id='showHistory' class='btn btn-primary' data-toggle='modal' data-target='#forecastModal'>Show Forecast Accuracy</button>
    <ul class="nav" id="main-menu">
    	<h5 class='page-header'>Site Navigation</h5>
        <li>
            <a  href="../default.html">Home<span class='glyphicon glyphicon-home'></span></a>
        </li>
         <li>
            <a class="active-menu"  href="globe.php">Fire Behavior<span class='glyphicon glyphicon-fire'></span></a>
        </li>
        <li>
            <a   href="fuels.php">Fuels<span class='glyphicon glyphicon-tree-deciduous'></span> </a>
        </li>
         <li>
            <a  href="teams.php">Leaderboards<span class='glyphicon glyphicon-th-list'></span></a>
        </li>
        <li>
            <a  href="globe.php">Getting Started<span class='glyphicon glyphicon-road'></span></a>
        </li>
			   <li  >
            <a   href="aboutUs.php">About<span class='glyphicon glyphicon-globe'></span></a>
        </li>	
          <li  >
            <a  href="contactForm.php">Contact<span class='glyphicon glyphicon-phone-alt'></span></a>
        </li>
                <li><i>Please Note: is dummy data for demonstration purposes while we redesign the program.  Please use accordingly.<i></li>
    </ul> 
        <footer class='text-muted' style="text-align: left">
        	&copy; Firesphere, LLC 2015. <br />
        	All rights reserved.
        </footer>
  	</div><br />
 
  	    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModal" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="historyModal">Time Series</h3>
	        <strong class='text-muted'>Orinda, CA</strong>
	      </div>
	      <div class="modal-body" id='modal-body'>
	      		<h4>Fuel Moisture</h4>
	      		<strong class='text-muted'>Percent Moisture by Time-lag Category</strong>
	      		<div id='fuelMoistureSummary'></div>
	      		<h4>Fire Behavior</h4>
	      		<strong class='text-muted'>Percent of Area by NFDRS Category</strong>
	      		<div id='chart'></div>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-default nav-left" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
	 <div class="modal fade" id="forecastModal" tabindex="-1" role="dialog" aria-labelledby="forecastModal" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="historyModal">Forecast Accuracy</h3>
	        <strong class='text-muted'>Orinda, CA</strong>
	      </div>
	      <div class="modal-body" id='modal-body'>
	      	<div id="forecastChart"></div>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-default nav-left" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
  </div>
  <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  <script src="../js/c3.js"></script>
  <link href="../styles/c3.css" rel='stylesheet'>
  <script>
  //check broswer support
	  function webglAvailable() {
	    try {
	        var canvas = document.createElement("canvas");
	        return !!
	            window.WebGLRenderingContext && 
	            (canvas.getContext("webgl") || 
	                canvas.getContext("experimental-webgl"));
	    } catch(e) { 
	        return false;
	    } 
	}
	webGL = webglAvailable()
	if (webGL == false){
		window.location.href = "map.php"
	}
  //if browser support, continue
  try{
    //wrap the whole thing in a try and then redirect if it fails
    var viewer = new Cesium.Viewer('cesiumContainer', {
    	timeline: false,
    	baseLayerPicker: false,
    	homeButton: false
    });
    var fire, layers;
    var today, tomorrow = false;
    function addToday(){
    	imagery = new Cesium.ArcGisMapServerImageryProvider({
	        url : "http://keystone.gisc.berkeley.edu/webgis/rest/services/Firesphere/currentBehavior/MapServer"
	    })
	    layers = viewer.scene.imageryLayers;
	    removeFireLayer()
	    fire = layers.addImageryProvider(imagery)
	    fire.alpha = 0.5
	    today = true;
	    tomorrow = false;
    }
    //add today's layer at the beginning
    addToday()
    ///
    function addTomorrow(){
    	imagery = new Cesium.ArcGisMapServerImageryProvider({
	        url : "http://keystone.gisc.berkeley.edu/webgis/rest/services/Firesphere/forecast/MapServer",
	        usePreCachedTilesIfAvailable:false
	    })
	    layers = viewer.scene.imageryLayers;
	    removeFireLayer()
	    fire = layers.addImageryProvider(imagery)
	    fire.alpha = 0.5
	    today = false;
	    tomorrow = true;
    }
    
    function removeFireLayer(){
    	if (today == true || tomorrow == true){
    		layers.remove(fire)
    	}
    }
    $("#setOpacity").change(function(){
    	value = $(this).val()
    	fire.alpha = value;
    })
    
    var cesiumTerrainProviderMeshes = new Cesium.CesiumTerrainProvider({
	    url : '//assets.agi.com/stk-terrain/world',
	    requestWaterMask : true,
	    requestVertexNormals : true
	});
		viewer.terrainProvider = cesiumTerrainProviderMeshes;
		var camera = new Cesium.Camera(viewer.scene);
	   camera.flyTo({
	    destination : Cesium.Cartesian3.fromDegrees(-122.179722, 37.882778, 10000.0)
	   });
	$('#showStreetsButton').change(function(){
		if ($(this).prop('checked')){
			streets = new Cesium.ArcGisMapServerImageryProvider({
        url : "http://keystone.gisc.berkeley.edu/webgis/rest/services/Firesphere/OrindaStreets/MapServer"
    })
    streetsLayer = layers.addImageryProvider(streets)
		}else{
			layers.remove(streetsLayer)
		}
	})
	$("input[name=showLayer]").change(function(){
		if ($(this).val() == 'today'){
			addToday()
		}else{
			addTomorrow()
		}
	})
}catch (e){
	window.location.href = "map.php"
}
	

	$(document).ready(function(){
		$.ajax({
			url: "../Services/getSummaries.php",
			error: function(){
				console.log("Error getting summaries.");
				$("#fuelMoistureSummary").text("Error gathering data from database.")
				$("#fireBehaviorSummary").text("Error gathering data from database")
			},
			success: function(response){
				response = JSON.parse(response);
				fmData = response[1];
				console.log(fmData)
				fbData = response[0];
				forecastData = response[2];
				one = ['One-Hour']
				ten = ['Ten-Hour']
				hund = ['Hundred-Hour']
				thous = ['Thousand-Hour']
				herb = ['LiveHerb']
				wood = ["LiveWood"]
				
				for (var i=0; i<fmData.length; i++){
					console.log(fmData[i])
					one.push(+fmData[i]['One'])
					ten.push( +fmData[i]['Ten'])
					hund.push(+fmData[i]['Hundred'])
					thous.push( +fmData[i]['Thousand'])
					herb.push(+fmData[i]['Herb'])
					wood.push(+fmData[i]['Woody'])
				}
				console.log(one)
				console.log(ten)
				colors = ['#4caeea', '#b9ea4c', '#f5f648', '#f69748', 'red', 'gray']
				var chart = c3.generate({
				bindto: "#fuelMoistureSummary",
			    data: {
			        columns: [
			            one,
			            ten,
			            hund,
			            thous,
			            //herb,
			            wood
			        ],
			        types: {
			        	one:'area-spline',
			        	ten: 'area-spline',
			        	hund: 'area-spline',
			        	thous: 'area-spline',
			        	herb: 'area-spline',
			        	woody: 'area-spline'
			        }
			    },
			    axis: {
			      y: {
			        label: { // ADD
			          text: '% Fuel Moisture',
			          position: 'outer-middle'
			        },  
			      },
			      x: {
			        show: true,
			        label: { // ADD
			          text: 'Days Ago',
			          position: 'outer-middle'
			        }
			      },
			    },
			    size: {
			    	width: 500
			    }
			});

				low = ['Low']
				mid = ['Mid']
				high = ['High']
				veryHigh = ['VeryHigh']
				extreme = ['Extreme']
				nb = ["NonBurnable"]
				
				for (var i=0; i<fbData.length; i++){
					low.push(+fbData[i]['Low'])
					mid.push( +fbData[i]['Mid'])
					high.push(+fbData[i]['High'])
					veryHigh.push( +fbData[i]['VeryHigh'])
					extreme.push(+fbData[i]['Extreme'])
					nb.push(+fbData[i]['NB'])
				}
				colors = ['#4caeea', '#b9ea4c', '#f5f648', '#f69748', 'red', 'gray']
				heights = []
				var chart = c3.generate({
			    data: {
			        columns: [
			            low,
			            mid,
			            high,
			            veryHigh,
			            extreme,
			            nb
			        ],
			        type: 'bar',
			        colors: {
			        	'Low': colors[0],
			        	'Mid': colors[1],
			        	"High": colors[2],
			        	"VeryHigh": colors[3],
			        	"Extreme": colors[4],
			        	"NonBurnable": colors[5]
			        },
			        groups: [['Low', 'Mid', 'High', 'VeryHigh', "Extreme", 'NonBurnable']]
			    },
			    axis: {
			      y: {
			        label: { // ADD
			          text: '% Area',
			          position: 'outer-middle'
			        },  
			      },
			      x: {
			        show: true,
			        label: { // ADD
			          text: 'Day',
			          position: 'outer-middle'
			        }
			      },
			    },
			    size: {
			    	width: 500
			    }
			});
			
			
			console.log(forecastData)
			
				minus = ['-1SD']
				plus = ['+1SD']
				mean = ['Mean']
				for (var i=0; i<forecastData.length; i++){
					minus.push(+forecastData[i]['Std'])
					plus.push(+forecastData[i]['Std'])
					mean.push(+forecastData[i]['DeltaMean'])
				}
				for (var i=1; i<minus.length; i++){
					val = +minus[i]
					m = mean[i]
					minus[i] = m - val
					plus[i] = m + val
				}
				console.log(plus)
				colors = ['blue', 'blue', 'red']
				var forecastChart = c3.generate({
					bindto: "#forecastChart",
				    data: {
				        columns: [
					        mean,
					        plus,
					        minus
				        ],
				        type: "area-spline",
				        types:{
				        	"Mean": "spline",
				        },
				        colors: {
				        	"Mean": colors[2],
				        	"+1SD": colors[1],
				        	"-1SD" : colors[0]
				        },
				    },
				    axis: {
				      y: {
				        label: { // ADD
				          text: 'Forecast Percent Deviation from Actual',
				          position: 'outer-middle'
				        }, 
				        tick: {
				        	format: function(d){
				        		return Math.round(d*100) / 100
				        	}
				        } 
				      },
				      x: {
				        show: true,
				        label: { // ADD
				          text: 'Days Ago',
				          position: 'outer-middle'
				        }
				      },
				    },
				    size: {
				    	width: 500
				    },
				    grid: {
				    	y: {
				    		show: true
				    	}
				    }
			});
			}
		})
	})
</script>
</body>
</html>
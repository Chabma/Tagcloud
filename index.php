<!DOCTYPE html>
<meta charset="UTF-8">
<head>
<style>
body{
	background: white;
	font-family: 'Rubik', sans-serif;
}
form{
	margin-left:30px;
	margin-top: 40px;
}
h1{
	font-family: 'Lato', sans-serif;
}
button{
	border: none;
	height: 30px;
	box-shadow: -1px 1px grey;
	font-family: 'Rubik', sans-serif;
	margin: 4px 4px 4px 4px;
}
select{
	border: none;
	height: 30px;
	background: #eee;
	border: solid 1px #aaa;
	font-family: 'Rubik', sans-serif;
}
input[type=text]{
	background: #eee;
	border: none;
	height: 30px;
	border: solid 1px #aaa;
	font-family: 'Rubik', sans-serif;
}
input[type=datetime-local]{
	background: #eee;
	border: none;
	height: 30px;
	border: solid 1px #aaa;
	font-family: 'Rubik', sans-serif;
}
#left{
	display: inline-block;
	width:350px;
}
#channelList{
		overflow: auto;
		height: 150px; 
		width: 250px;
		background: white;
}
#surrounding_div{
	display: inline-block;
	width: 0px;
	vertical-align:top;
}
#cloud_div{
	display: inline-block;
	width: 1200px;
}
#submit{
	border: none;
	width: 100px;
	height: 30px;
	box-shadow: -1px 1px grey;
	color: white;
	background: #23b9f3;
	font-family: 'Rubik', sans-serif;
	margin: 4px 4px 4px 4px;
}
#loading_gif{
	width: 1200px;
	position:absolute;
	object-fit: none;
	background: #fefefe;
}
.color{
	height: 20px;
	width: 20px;
}
</style>
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
<script src="./jquery-3.1.1.min.js"></script>
<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="./d3/d3.js"></script>
<script src="./d3.layout.cloud.js"></script>
<script type="text/javascript" src="html2canvas.js"></script>
<script type="text/javascript" src="html2canvas.svg.js"></script>
</head>
<body>
<div id="left">
	<h1>Tag Cloud Maker</h1>
	<form onsubmit="startFunc()">
		Channel(s) : <span style="color:red;" >*</span><br>
		<div id="channelList";>
			<input type="checkbox" class="channel" value=1    >CNBC<br>
			<input type="checkbox" class="channel" value=2    >NBC - New York<br>
			<input type="checkbox" class="channel" value=3    >CNN<br>
			<input type="checkbox" class="channel" value=4    >ABC - New York<br>
			<input type="checkbox" class="channel" value=5    >CBS - New York<br>
			<input type="checkbox" class="channel" value=6    >Fox - New York<br>
			<input type="checkbox" class="channel" value=8    >C-SPAN<br>
			<input type="checkbox" class="channel" value=9    >PBS<br>
			<input type="checkbox" class="channel" value=10   >FOXNEWS<br>
			<input type="checkbox" class="channel" value=12   >MSNBC<br>
			<input type="checkbox" class="channel" value=13   >C-SPAN 2<br>
			<input type="checkbox" class="channel" value=15   >Fox - Boston<br>
			<input type="checkbox" class="channel" value=16   >CBS - Boston<br>
			<input type="checkbox" class="channel" value=17   >ABC - Boston<br>
			<input type="checkbox" class="channel" value=18   >NBC - Boston<br>
			<input type="checkbox" class="channel" value=21   >ABC - Philadelphia<br>
			<input type="checkbox" class="channel" value=22   >NBC - Philadelphia<br>
			<input type="checkbox" class="channel" value=23   >CBS - Philadelphia<br>
			<input type="checkbox" class="channel" value=30   >NBC - Washington<br>
			<input type="checkbox" class="channel" value=282  >C-SPAN 3<br>
		</div><br>
			
		Start date (in UTC time): <span style="color:red;" >*</span><br><input id="startDate1" type="datetime-local" name="startDate1" value= <?php echo("\"".$_POST["startDate1"]."\""); ?> required> <button onclick="set_startDate_now1()" type="button">Set to now</button><br><br>

		Duration : <span style="color:red;" >*</span><br>
			<input id="duration" name="duration" type="text" value="" required>			
			<select id="duration_type">
				<option value=3600>Hour(s)</option>
				<option value=60>Minute(s)</option>
				<option value=1>Second(s)</option>
			</select><br><br>	
	
		Title: <br>
			<input id="cloud_title" name="cloud_title" type="text" value=""><br><br>
		 <button type="button" id="advanced_settings_button" onclick="$('#advanced_settings').slideToggle('slow');advanced_settings_clicked();">Advanced settings</button>
		<div id="advanced_settings" style="display:none">	
			Scale cloud words (decimals are okay): <span style="color:red;" >*</span><br>
				<input id="cloud_scale" name="cloud_title" type="text" value="2.15" required><br><br>	

			Minimum frequency cut-off : <span style="color:red;" >*</span><br>
				<input id="cut_off" name="cut_off" type="text" value="2" required><br><br>

			Extra stop words (seperated with spaces) :<br>
				<input id="stop_words" name="stop_words" type="text" value="" ><br><br>				
		
			Colors :<br>
				<input type="radio" name="color_radio" class="color_radio" value=1 checked><img class="color" src="colors_1.png">
				<input type="radio" name="color_radio" class="color_radio" value=2><img class="color" src="colors_2.png">
				<input type="radio" name="color_radio" class="color_radio" value=3><img class="color" src="colors_3.png" >
				<input type="radio" name="color_radio" class="color_radio" value=4><img class="color" src="colors_4.png" >
		</div>
		<br>
		<input type="button" id="submit" value="Submit" onclick="startFunc()">
		<br>
	</form>
	<br><br>
	<div id="export-buttons" style="margin-left:30px;" hidden>
		<button onclick="make_img('png')" type="button">convert current graph to png</button><br>
		<button onclick="make_img('jpeg')" type="button">convert current graph to jpeg</button>
	</div>
</div>
<div id="surrounding_div">
	<div id="cloud_div">
	<img id="loading_gif" src="loading.gif" style="display:none">
	</div>
</div>
<div id="img-out" hidden>
</div>
<?php
		function login(){
			// outputs a token to use with other shadowtv reperio API functions
			// create curl resource
			$ch = curl_init();
			// login
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL, "http://api.shadowtv.net/reperio/login");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = array("username" => "shadowtv", "password" => "630ninth");
			$data_string = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
			);
 
			$output = json_decode(curl_exec($ch));
			// close curl resource to free up system resources
			curl_close($ch);

			//debugging:
			return $output->{'token'};
		}
		
	$token = login();
?>
<script>
/*
	Tag Cloud Maker
	Written By Cameron Abma
	
	Creates Html Webpages of Tag Clouds which can then be converted into images that can be saved
*/

	//Variables for tag cloud url
	var title = $( "#cloud_title" ).val();
	var scale = $( "#cloud_scale" ).val();
	var cut_off = $( "#cut_off" ).val();
	var chosen_color = $( ".color_radio" ).map(function() {
							if (this.checked){return $(this).val();}
						}).get();
	var url;
	var urls = [];
	var token = "<?php echo($token);?>";
	var freq = new Object();
	
	
	var startFunc = function() {
		/*start of the WordCloud creation, logs in and then passes the info to next command (getTextFunc) */
		
		//toggle visibility of loading gif
		if(!$("#loading_gif").is(":visible")){
			$("#loading_gif").toggle();
		}
		
		//check inputs validity:
		var channels = $( ".channel" ).map(function() {if (this.checked){return $(this).val();}}).get();
		if(channels.length < 1||
		$('#startDate1')[0].value.length < 16||
		!$('#duration')[0].checkValidity() ||
		!$('#cloud_scale')[0].checkValidity() ||
		!$('#cut_off')[0].checkValidity()){
			alert("Please fill in all required fields");
			return;
		}
		
		//set up  and renew variables
		var year1 = $( "#startDate1" ).val().substring(0, 4);
		var month1 = $( "#startDate1" ).val().substring(5, 7);
		var day1 = $( "#startDate1" ).val().substring(8, 10);
		var hour1 = $( "#startDate1" ).val().substring(11, 13);
		var minute1 = $( "#startDate1" ).val().substring(14, 16); 
		var duration1 = $( "#duration" ).val() * $("#duration_type").val(); 
		urls = [];
		title = $( "#cloud_title" ).val();
		scale = $( "#cloud_scale" ).val();
		cut_off = $( "#cut_off" ).val();
	
		//create a list of urls from the api for each hour and each channel
		for (channel in channels){
			
			while(duration1 > 0){
				//add url to list
				url = "http://api.shadowtv.net/reperio/v1/captions/"+channels[channel]+"/"+year1+"-"+month1+"-"+(day1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false})+"T"+(hour1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false})+":"+minute1+":00.000Z/"+Math.min(3599, parseInt(duration1))+"?include=captions,body";
				urls.push(url);
				
				//increment hour (increments hours and days, but fails when going between months)(this is a bug) 
				duration1 = duration1 - 3599;
				if(hour1 == 23){
					hour1 = 0;
					day1++;
				}
				else{
					hour1++;
				}
			}
			
			//reset duration, hour, month, and day for next channel
			duration1 = $( "#duration" ).val()  * $("#duration_type").val();
			hour1 = $( "#startDate1" ).val().substring(11, 13);
			day1 = $( "#startDate1" ).val().substring(8, 10);
		}
		//start the next function (getTextFunc)
		getTextFunc(urls, '', urls.length - 1);
	};
	
	var getTextFunc = function(url, passedResult, counter) {
		/*collects text from urls ( can collect from multiple urls in case of multiple hours or channels )
		  and sends data to makeGraph to be drawn
		*/
		
		passedResult = passedResult || '';
		counter = counter || 0;
		$.ajax({
			type: 'GET',
			url: url[counter],
			dataType: "json",
			headers: { 'Authorization': token },
			success: function (result) {
				var finResult = passedResult + result.body;
				if (counter <= 0){
					//move on to next function (makeGraph)
					makeGraph(finResult);
				}
				else{
					//still more urls to add to the text
					counter--;
					getTextFunc(urls, finResult ,counter);
				} 
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert error
				alert(xhr.status + " text error");
				alert(thrownError);
								
				//turn off loading gif because of error
				if($("#loading_gif").is(":visible")){
					$("#loading_gif").toggle();
				}
			}
		});
	};
	
	var makeGraph = function(data){
		/* Calls functions to organize word data, rotates and resizes words, sends the specifications to draw function
		   helper functions used can be found below
		*/
		var words = getWordFrequency(data);

		d3.layout.cloud().size([1000, 600])
			.words(Object.keys(words).map(function(d) {
				return {text: d, size: ((words[d] + 5) / 3)};
			}))
			.padding(1)
			.rotate(function() { return (((Math.random() * 2) * 30) - ((Math.random() * 2) * 45)); })
			.font("Impact")
			.fontSize(function(d) { return scale * (7 - (Object.keys(words).length/100) + (d.size * 1.5)); })
			.on("end", draw)
			.start();
	}
	
	function draw(words) {
		/*Draws the word cloud with the given words and their frequencies */
		
		//Choosing the color of the graph
		var black = false;		
		chosen_color = $( ".color_radio" ).map(function() {
			if (this.checked){return $(this).val();}
		}).get();
		var fill = d3.scale.category10();

		if(chosen_color[0] == 2){
			fill = d3.scale.category20();
		}
		if(chosen_color[0] == 3){
			fill = d3.scale.category20b();
		}
		if(chosen_color[0] == 4){
			black = true;
		}
		
		//remove old graph
		d3.select("#cloud_div").selectAll("svg").remove();
		
		//add title:
		d3.select("#cloud_div").append("svg")
			.attr("width", 1200)
			.attr("height", 70)
			.append("g")
			.attr("transform", "translate(100,10)")
			.selectAll("text")
			.data([title].map(function(d) {
				return {text: d, size: 35};
			}))
			.enter().append("text")
			.style("font-size", function(d) { return 24; })
			.style("font-family", "Impact")
			.style("fill", function(d, i) { if(black){return "black"}; return fill(i); })
			.attr("text-anchor", "middle")
			.attr("transform", function(d) {
				return "translate(500, 50)";
				})
			.text(function(d) { return d.text; });
		//add Shadowtv text:
		d3.select("#cloud_div").append("svg")
			.attr("width", 1200)
			.attr("height", 40)
			.append("g")
			.attr("transform", "translate(100,10)")
			.selectAll("text")
			.data(["Brought to you by ShadowTV: www.shadowtv.com"].map(function(d) {
				return {text: d, size: 20};
			}))
			.enter().append("text")
			.style("font-size", function(d) { return 20; })
			.style("font-family", "Impact")
			.style("fill", function(d, i) { if(black){return "black"}; return fill(i); })
			.attr("text-anchor", "middle")
			.attr("transform", function(d) {
				return "translate(500, 10)";
				})
			.on('click', function(){window.open('http://www.shadowtv.com');})
			.text(function(d) { return d.text; });	
		//add cloud:
		d3.select("#cloud_div").append("svg")
			.attr("width", 1200)
			.attr("height", 600)
			.append("g")
			.attr("transform", "translate(600,300)")
			.selectAll("text")
			.data(words)
			.enter().append("text")
			.style("font-size", function(d) { return d.size + "px"; })
			.style("font-family", "Impact")
			.style("fill", function(d, i) {if(black){return "black"}; return fill(i); })
			.attr("text-anchor", "middle")
			.attr("transform", function(d) {
				return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
			})
			.text(function(d) { return d.text; });

		//make loading gif dissapear and make export buttons vidible
		if($("#loading_gif").is(":visible")){
			$("#loading_gif").toggle();
		}
		if(!$("#export-buttons").is(":visible")){
			$("#export-buttons").toggle();
		}
	}
	
	//helper functions (all used by makeGraph function)
	
	var getWordFrequency = function(text){
		/*returns a dictionary of words and their frequency from the given string 'text' */
		var freq = new Object();
		words = removePunctuation(text);
		freq = countFrequency(words);
		return	freq;
	}
	
	var removePunctuation = function(text){
		/*returns a string equal to the given string 'text', but without punctuation */
		words = text.replace(/[\.,-\/#!$%\^&\>>?*";:{}=\-_`'~()]/g,"");
		words = words.replace(/\n/g," ");
		words = words.replace(/[0-9]/g, '');
		return words;
	}
	
	var countFrequency = function(words){
		/*returns a dictionary whose keys are words and whose values are the frequency */
		
		//defining variables
		
		//combine words was a scrapped fature. Still here because I thought it might be useful later
		//var combineWords = {'TAX': 'TAXES', 'COMMUNITIES': 'COMMUNITY'};
		
		//trash words that aren't worth counting. like "I" and "and", etc. I might have put too many, but many are needed.
		var trashWords = ['[', ']', 'THE', 'ALREADY', '', 'W', 'ASKED', 'ANNOUNCER', 'CALLER', 'SPEAK', 'BECOME', 'THEYVE', 'ALONG', 'TALKED', 'PRETTY', 'EFFECTS', 'DURING', 'COVERED', 'KNOWS', 'ALREADY', 'WORKS', 'REASON', 'POSSIBLE', 'WOULDNT', 'ANYONE', 'ACTIONS', 'SEEMS', 'CLOSE', 'CALLING', 'NEEDS', 'ACCORDING', 'M', 'EITHER', 'ISSUES',  'THREE', 'HANDS', 'NEEDED', 'YOUVE', 'MISSED', 'OTHERS', 'WATCHING', 'PRESS', 'COURSE', 'WANTED', 'OBVIOUSLY', 'LESS', 'COUPLE', 'GETS', 'MIDDLE', 'AHEAD', 'SORT', 'HUNDREDS', 'IDEA', 'CLEAR', 'OPEN', 'MOMENT', 'SERVICE', 'BRIEFING', 'BUYING', 'TERMS', 'TERM', 'EXCHANGE', 'TRADING', 'JOINS', 'MAKES', 'RETURN', 'VALUE', 'MARKETS', 'PAID', 'BANK', 'CIALIS', 'GETS', 'TIM', 'BOX', 'PIECE', 'EARNINGS', 'SPONSORSHIP', 'COUPLE', 'INTEREST', 'KENNY', 'SINCE', 'WOMAN', 'END', 'JIM', 'SMALL', 'SQUAWK', 'COMPLETE', 'POST', 'LEAVE', 'DEAL', 'YESTERDAY', 'BELL', 'STOCK', 'OPENING', 'AREA', 'WIN', 'BLOOD', 'RACE', 'PAY', 'RUNNING', 'SITUATION', 'NOTHING', 'BRING', 'FACE', 'MONTHS', 'SERIOUS', 'HAPPENING', 'CAUGHT', 'REACTION', 'HIT', 'WEEKS', 'BAD', 'PROBABLY', 'ABLE', 'HAPPEN', 'BETWEEN', 'ONCE', 'ACROSS', 'HEARD', 'AMERICANS','WASNT', 'HEART', 'COM', 'FOUND', 'REAL', 'ANYTHING', 'WANTS', 'UNTIL', 'UNDER', 'EXACTLY', 'MIGHT', 'ROOM', 'SEARCH', 'JOINING', 'ISNT', 'INCLUDING', 'ISSUE', 'TAKEN', 'PAST', 'HAND', 'LEAST', 'PLUS', 'IMPORTANT', 'WORKED', 'TOOK', 'EVERYONE', 'HOUR', 'CALLED', 'COMES', 'SAME', 'TOLD', 'CALL', 'D', 'WHETHER', 'CAME' ,'TALKING', 'WITHOUT', 'FREE', 'PROBLEMS', 'AGAINST','WOMEN', 'MEN', 'DOCTOR', 'COVERAGE', 'USED', 'SOMEBODY', 'WONT', 'EVERYTHING', 'ENOUGH', 'MYSELF', 'TOP', 'LAUGHS', 'MAKING', 'MAN', 'DING', 'MMM', 'FACT', 'ROUND', 'PARTY', 'WORTH', 'HELPS', 'BOTH', 'MAYBE', 'LOOKS', 'TV', 'BOY', 'NARRATOR', 'GIRL', 'DA', 'HOURS', 'PLANS', 'THOU', 'BELIEVE', 'NUMBER', 'HEAR', 'OWN', 'YET', 'EACH', 'HOO', 'F', 'DOESNT', 'INSIDE', 'R', 'P', 'FALL', 'OHH', 'WHOLE', 'AINT', 'CAUSE', 'MOVE', 'STARTED', 'HUH', 'BYE', 'BIT', 'SELF', 'EVEN', 'ANOTHER', 'BODY', 'EVER','TRY', 'C', 'FOOD', 'SIDE', 'O', 'LA', 'CASE', 'HAPPENED', 'OK', 'NICE', 'GETTING', 'G', 'AWAY', 'LAST', 'FIND', 'HELP', 'STOP', 'MEAN', 'ASK', 'MOST', 'AGAIN', 'WAIT', 'TEAM', 'STREET', 'KIND', 'NA', 'MR', 'ALSO', 'U', 'GUY', 'A', 'YEARS', 'YOULL', 'TO', 'AND', 'SHES', 'BETTER', 'SAYING', 'DOES', 'WHERE', 'OF', 'IN', 'FOR', 'WAS', 'ON', 'IS', 'THAT', 'IT', 'BE', 'SAYS', 'THEY', 'WITH', 'YOU', 'THIS', 'WERE', 'WE', 'ARE', 'THEIR', 'I', 'AT', 'THEM', 'BUT', 'BY', 'YOUR', 'OUR', 'HAVE', 'MORE', 'FROM', 'ITS', 'ABOUT', 'NOT', 'HE', 'ALL', 'NEWS', 'ONLY', 'AN', 'WILL', 'HAS', 'CAN', 'WHEN', 'THERE', 'AFTER', 'NOW', 'OUT', 'UP', 'WHO', 'NO', 'BEEN', 'SAY', 'HIS', 'GET', 'MY', 'KNOW', 'DO', 'WHAT', 'RIGHT', 'OVER', 'HAD', 'OR', 'SO', 'IF', 'TOO', 'BACK', 'DONT', 'MAY', 'OTHER', 'HOW', 'WHY', 'THERES', 'FEW', 'SOME', 'WAY', 'US', 'THINK', 'STILL', 'NEW', 'ONE', 'AIR', 'THAN', 'MANY', 'LIKE', 'DAYS', 'IM', 'YES', 'GONNA', 'OH', 'ME', 'APPLAUSE', 'JUST', 'WELL', 'REALLY', 'YOURE', 'THATS', 'GOOD', 'SEE', 'GO', 'AM', 'GREAT', 'JUST', 'GOING', 'YEAH', 'LOOK', 'WHATS', 'DID', 'HES', 'WOW', 'BEFORE', 'HI', 'TAKE', 'SOMETHING', 'COME', 'BE', 'DAY', 'B', 'COULD', 'WOULD', 'FEEL', 'TIME', 'IVE', 'TELL', 'SAID', 'MUCH', 'SURE', 'CANT', 'ILL', 'SEEN', 'DONE', 'DOING', 'ID', 'SHOULD', 'WANT', 'BECAUSE', 'VERY', 'GUYS', 'WATCH', 'AS', 'HEY','NEXT', 'TAKES', 'LETS', 'GOT', 'WEEK', 'THING', 'HERE', 'NEED', 'THOSE', 'INTO', 'SHOW', 'MAKE', 'HER', 'ER', 'THEN', 'THEYRE', 'WHILE', 'S', 'SHE', 'EVERY', 'PUT', 'OKAY', 'HAVING', 'HOLD', 'AROUND', 'SUCH', 'E', 'T', 'ALWAYS', 'LOT', 'SAW', 'WHICH', 'HIM', 'WENT', 'COMING', 'OFF', 'THROUGH', 'THINGS', 'BEING', 'ND', 'THESE', 'N', 'ELSE', 'TH', 'AGO', 'TALK', 'DIDNT', 'ANY', 'USE', 'ANY', 'MUST', 'WEVE','LET'];
		
		var freq = {};
		var word;
		
		//add user defined extra stop words to trashwords list
		var extra_stopwords = $( "#stop_words" ).val().toUpperCase().split(" ");
		for (var stopword in extra_stopwords){
			trashWords.push(extra_stopwords[stopword]);
		}
		
		//count the frequency of each word and add it to the array freq
		data = words.split(" "); 
		for (var index in data){
			word = data[index].toUpperCase(); //catch "the" vs "The" error
			if (trashWords.indexOf(word) == -1){
				/*if (word in combineWords){
					word  = combineWords[word];
				}*/
				if (word in freq){
					freq[word]++;
				}	
				else {
					freq[word] = 1;
				}
			}
		}
		
		//remove words with too low a frequency and remove that number from the remaining words so that the cloud looks nicer
		for( var item in freq){
			if(freq[item] < cut_off){
				delete freq[item];
			}
			else{
				freq[item] = freq[item] - cut_off;
			}
		}
		return freq;
	}

	//button functions
	
	var make_img = function( type) {
		/*converts the cloud to a img that can be saved to the user's computer
		  uses the "html2canvas" library
		*/
		html2canvas($("#cloud_div"), {
			onrendered: function(canvas) {
				//add canvas
				document.body.appendChild(canvas);
				
				// Convert and download as image  
				var img = canvas.toDataURL("image/"+type+";base64;");
				window.open(img,"","width=700,height=700");
			
				// Clean up 
				document.body.removeChild(canvas);
			},
			background: "white"
		});
	}
	
	var set_startDate_now1 = function() {
		/*sets the datetime input to the current date and time */
		document.getElementById('startDate1').value = new Date().toISOString().slice(0,-8);
	}
	
	var advanced_settings_clicked = function(){
		/*expands or retracts the advanced settings div */
		//expand
		if($( "#advanced_settings_button" ).css("background-color") == "rgb(221, 221, 221)"){
			$( "#advanced_settings_button" ).css("background-color", "#666");
			$( "#advanced_settings_button" ).css("color", "white");
			$( "#advanced_settings_button" ).css("box-shadow", "-1px 1px lightgrey");
		}
		//retract
		else{
			$( "#advanced_settings_button" ).css("background-color", "rgb(221, 221, 221)");
			$( "#advanced_settings_button" ).css("color", "black");
			$( "#advanced_settings_button" ).css("box-shadow", "-1px 1px grey");
		}
	}
</script>
</body>
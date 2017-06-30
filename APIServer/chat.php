<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
		$i = 0;
        $q = $_REQUEST['q'];
		if (strstr($q,"weather") != false) {
			$location = strstr($q,"in");
			$inarray = explode(' ',$location,2);
			$url = file_get_contents('http://api.wunderground.com/api/a144a1d06e94dac6/forecast/q/India/'.$inarray[1].'.json');
            $resarray = json_decode($url);
            $forecast = $resarray->forecast;
            $txt_forecast = $forecast->txt_forecast;
            $forecastday = $txt_forecast->forecastday[0];
            $answer = $forecastday->fcttext_metric;
            exit($answer);
		}
		else if (strstr($q,"news") != false) {
			$url = file_get_contents('https://extraction.import.io/query/extractor/f8e70ccc-4151-4736-b509-8c650b426ef6?_apikey=0151b88bceb346a4958555431af821aaf03ca040dbe04d721df171af066d8bac23406683aa5f344739c2909281cb4ca71fca60ae50146a910782527c0e1732501356b5da9366a3fc8d07de4b2a086a06&url=https%3A%2F%2Fwww.inshorts.com%2Fen%2Fread');
            $resarray = json_decode($url);
			for ($i=0;$i<3;$i++) {
				$extractorData = $resarray->extractorData;
				$data = $extractorData->data[0];
				$group = $data->group;
				$title = $group[$i]->Title[0];
				$titleText = $title->text;
				$author = $group[$i]->Author[0];
				$authorText = $author->text;
				$time = $group[$i]->PublishedOn[0];
				$timeText = $time->text;
				$description = $group[$i]->Description[0];
				$descriptionText = $description->text;
				$source = $group[$i]->Source[0];
				$sourceText = $source->text;
				$sourceLink = $source->href;
				$answer = '<br>'.$titleText.'.<br>By '.$authorText.'.<br>Description: '.$descriptionText.'.<br>Time: '.$timeText.'.<br>Source: <a href="'.$sourceLink.'" target="_blank">' .$sourceText.'</a><br>';
				echo($answer);	
			}
			exit("&nbsp;");
		}
		else if (strstr($q,"movies") != false || strstr($q,"now playing") != false || strstr($q,"currently showing") != false) {
			if (strstr($q,"now playing") != false || strstr($q,"currently showing") != false) {
			$subin = strstr($q,"in");
			$inarray = explode(' ',$subin,3);
			$location = strtolower($inarray[2]);
			}
			else {
			$subin = strstr($q,"in");
			$inarray = explode(' ',$subin,2);
			$location = strtolower($inarray[1]);
			}
			$url = file_get_contents('https://extraction.import.io/query/extractor/8c61c7b2-9e65-4cd5-9f24-96a50883f7a2?_apikey=0151b88bceb346a4958555431af821aaf03ca040dbe04d721df171af066d8bac23406683aa5f344739c2909281cb4ca71fca60ae50146a910782527c0e1732501356b5da9366a3fc8d07de4b2a086a06&url=https%3A%2F%2Fwww.justickets.in%2F'.$location.'');
            $resarray = json_decode($url);
			echo ("Movies now playing in ".ucfirst($location)."<br>");
			for ($i=1;$i<=3;$i++) {
				$extractorData = $resarray->extractorData;
				$data = $extractorData->data[0];
				$group = $data->group;
				$title = $group[$i-1]->Title[0];
				$titleText = $title->text;
				$language = $group[$i-1]->Language[0];
				$languageText = $language->text;
				$answer = '<br>#'.$i.'<br>Movie Title: '.$titleText.'<br>Language: '.$languageText.'<br>';
				echo ($answer);
			}
			exit("&nbsp;");
		}
		else if (strstr($q,"stock") != false) {
			$inarray = explode(' ',$q);
			$company = strtolower($inarray[sizeof($inarray)-1]);
			$url = file_get_contents('https://extraction.import.io/query/extractor/8c903c26-5e13-4b66-ae97-1fd62ce91411?_apikey=0151b88bceb346a4958555431af821aaf03ca040dbe04d721df171af066d8bac23406683aa5f344739c2909281cb4ca71fca60ae50146a910782527c0e1732501356b5da9366a3fc8d07de4b2a086a06&url=https%3A%2F%2Fwww.google.com%2Ffinance%3Fq%3D'.$company.'');
            $resarray = json_decode($url);
			$extractorData = $resarray->extractorData;
			$data = $extractorData->data[0];
			$group = $data->group;
			$company = $group[0]->Company[0];
			$companyText = $company->text;
			$code = $group[0]->Code[0];
			$codeText = $code->text;
			$price = $group[0]->Price[0];
			$ptext = $price->text;
			$pricearray = explode(' ',$ptext,2);
			$priceText = $pricearray[0];
			$changeText = $pricearray[1];
			$answer = "".$companyText." ".$codeText."<br>Price: ".$priceText."<br>Change: ".$changeText."";
			exit($answer);
		}
		else if (strstr($q,"pnr") != false) {
			$inarray = explode(' ',$q);
			$pnr = $inarray[sizeof($inarray)-1];
			$url = file_get_contents('https://extraction.import.io/query/extractor/5579ea5c-c365-40e5-8662-79b236e1f90c?_apikey=0151b88bceb346a4958555431af821aaf03ca040dbe04d721df171af066d8bac23406683aa5f344739c2909281cb4ca71fca60ae50146a910782527c0e1732501356b5da9366a3fc8d07de4b2a086a06&url=https%3A%2F%2Fwww.railyatri.in%2Fpnr-status%2F'.$pnr.'');
            $resarray = json_decode($url);
			$resarray = json_decode($url);
			$extractorData = $resarray->extractorData;
			$data = $extractorData->data[0];
			$group = $data->group;
			$source = $group[0]->Source[0];
			$sourceText = $source->text;
			$destination = $group[0]->Destination[0];
			$destinationText = $destination->text;
			$boarding = $group[0]->Boarding[0];
			$boardingText = $boarding->text;
			$class = $group[0]->Class[0];
			$classText = $class->text;
			$chart = $group[0]->Chart[0];
			$chartText = $chart->text;
			$train = $group[0]->Train[0];
			$trainText = $train->text;
			$current = $group[0]->Current[0];
			$currentText = $current->text;
			$booking = $group[0]->Booking[0];
			$bookingText = $booking->text;
			$answer = "Train: ".$trainText.",<br>From: ".$sourceText.",<br>To: ".$destinationText.",<br>Boarding On: ".$boardingText.",<br>Class: ".$classText.",<br>Chart status: ".$chartText.",<br>Current status: ".$currentText.",<br>Booking status: ".$bookingText."";
			exit($answer);
		}
		else if (strstr($q,"flights") != false) {
			exit("I'm sorry. But I can't process your request yet.");
		}
		else if (strstr($q,"trains") != false) {
			exit("I'm sorry. But I can't process your request yet.");
		}
		else if (strstr($q,"who") != false) {
			$url = file_get_contents('http://api.wolframalpha.com/v2/query?&appid=KHU9T4-QKKGKKK5PK&input='.urlencode($q).'');
			$resarray = simplexml_load_string($url);
			if ($resarray['success'] == false) {
				exit("I'm sorry. But I can't process your request.");
			}
			else {
			
			$pod = $resarray->pod[1];
			$subpod = $pod->subpod;
			$plaintext = $subpod->plaintext;
			$dtpos = strpos($plaintext,"date");
			$fullname = substr($plaintext,0,$dtpos-1);
			$dob = substr($plaintext,$dtpos);
			$answer = $fullname."<br>".$dob."<br>";
			exit($answer);
			}
		}
		else if (strstr($q,"meaning") != false || strstr($q,"define") != false || strstr($q,"definition") != false) {
			$url = file_get_contents('http://api.wolframalpha.com/v2/query?&appid=KHU9T4-QKKGKKK5PK&input='.urlencode($q).'');
			$resarray = simplexml_load_string($url);
			if ($resarray['success'] == false) {
				exit("I'm sorry. But I can't process your request.");
			}
			else {
			
			$pod = $resarray->pod[1];
			$subpod = $pod->subpod;
			$plaintext = $subpod->plaintext;
			exit($plaintext);
			}
		}
		else if (strstr($q,"+") != false || strstr($q,"-") != false || strstr($q,"*") != false || strstr($q,"/") != false || strstr($q,"times") != false || strstr($q,"to the power") != false || strstr($q,"plus") != false || strstr($q,"minus") != false || strstr($q,"divided by") != false || strstr($q,"square") != false || strstr($q,"cube") != false || strstr($q,"^") != false) {
			$url = file_get_contents('http://api.wolframalpha.com/v2/query?&appid=KHU9T4-QKKGKKK5PK&input='.urlencode($q).'');
			$resarray = simplexml_load_string($url);
			if ($resarray['success'] == false) {
				exit("I'm sorry. But I can't process your request.");
			}
			else {
			
			$pod = $resarray->pod[1];
			$subpod = $pod->subpod;
			$plaintext = $subpod->plaintext;
			exit($plaintext);
			}
		}
		else if (strstr($q,"convert") != false) {
			$url = file_get_contents('http://api.wolframalpha.com/v2/query?&appid=KHU9T4-QKKGKKK5PK&input='.urlencode($q).'');
			$resarray = simplexml_load_string($url);
			if ($resarray['success'] == false) {
				exit("I'm sorry. But I can't process your request.");
			}
			else {
			
			$pod = $resarray->pod[1];
			$subpod = $pod->subpod;
			$plaintext = $subpod->plaintext;
			exit($plaintext);
			}
		}
        else {
			$url = file_get_contents('http://api.wolframalpha.com/v2/query?&appid=KHU9T4-QKKGKKK5PK&input='.urlencode($q).'');
			$resarray = simplexml_load_string($url);
			if ($resarray['success'] == false) {
				exit("I'm sorry. But I can't process your request.");
			}
			else {
			
			$pod = $resarray->pod[1];
			$subpod = $pod->subpod;
			$plaintext = $subpod->plaintext;
			if (strstr($plaintext,"Wolfram|Alpha") != false) {
				$answer = substr_replace($plaintext," SALSA",strpos($plaintext,"Wolfram|Alpha")-1);
				echo $answer;
			}
			else echo $plaintext;
			exit(" ");
			}
		}
        ?>
    </body>
</html>

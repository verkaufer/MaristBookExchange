<?php
	


		$isbn = '0538482125';



		$url = "https://www.googleapis.com/books/v1/volumes?q=".$isbn;
	    	
	    //var_dump($url);

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    $book = curl_exec($ch);
	    curl_close($ch);

		//$jsondata = file_get_contents($fullurl);
		$data = json_decode($book, true);

		//echo "<pre>".print_r($data)."</pre>";


		echo $data['items'][0]['volumeInfo']['title'];
		echo "\n";
		echo $data['items'][0]['volumeInfo']['subtitle'];
		echo "\n";
		echo $data['items'][0]['volumeInfo']['publishedDate'];
		echo "\n";
		echo $data['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier']." ISBN-10";


?>
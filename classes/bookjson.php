<?php

class BookJSON{
	
	private $isbn;

	public __construct(){


	}

	public function getBook($isbn){
		$this->isbn = $isbn;

		$fullurl = "https://www.googleapis.com/books/v1/volumes?q=".$isbn;
		
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    $book = curl_exec($ch);
	    curl_close($ch);

		$data = json_decode($book, true);

		echo $data['items'][0]['volumeInfo']['title'];
		echo "\n";
		echo $data['items'][0]['volumeInfo']['subtitle'];
		echo "\n";
		echo $data['items'][0]['volumeInfo']['publishedDate'];
		echo "\n";
		echo $data['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier']." ISBN-10";
		return $data;

	}

}

?>
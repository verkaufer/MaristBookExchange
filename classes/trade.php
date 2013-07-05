<?php

class Trade
{
	
	private $pdo;
	private $isbn;

	//use this like so:
	// $user = new User($db);
	function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	public function getBook($isbn){


		$url = "https://www.googleapis.com/books/v1/volumes?q=".$isbn;

		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    $book = curl_exec($ch);
	    curl_close($ch);

		$data = json_decode($book, true);


		$results['title']         = $data['items'][0]['volumeInfo']['title'];
		$results['author']        = $data['items'][0]['volumeInfo']['authors'][0];
		$results['desc']          = $data['items'][0]['volumeInfo']['description'];
		$results['publishedDate'] = $data['items'][0]['volumeInfo']['publishedDate'];
		$results['isbn10']        = $data['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];
		$results['isbn13']        = $data['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'];
		$results['thumbnail']     = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];

		return $results;

	}

	public function fetchAllTrades(){
		$getTrades = $this->pdo->prepare("SELECT * FROM trades");
		$getTrades->execute();

		$result = $getTrades->fetch(PDO::FETCH_ASSOC);

		return $result;

	}

	public function getNumAllTrades(){
		$getTrades = $this->pdo->prepare("SELECT COUNT(*) FROM trades");
		$getTrades->execute();

		$result = $getTrades->fetchColumn();

		return $result;
	}

	public function getNumClosedTrades(){
		$getTrades = $this->pdo->prepare("SELECT COUNT(*) FROM trades WHERE status = 2");
		$getTrades->execute();

		$result = $getTrades->fetchColumn();

		return $result;
	}

	public function getTradeByID($tradeID){
		$getTrade = $this->pdo->prepare("SELECT * FROM trades WHERE id = :id");
		$getTrade->bindValue(":id", $tradeID, PDO::PARAM_STR);
		$getTrade->execute();

		$result = $getTrade->fetch(PDO::FETCH_ASSOC);

		return $result;
	}


	public function fetchTradesForISBN($isbn){
		if(strlen($isbn) <= 10){
			$getTrades = $this->pdo->prepare("SELECT * FROM trades WHERE isbn10 = :isbn AND status = 1");
			$getTrades->bindValue(':isbn', $isbn, PDO::PARAM_STR);
			$getTrades->execute();

		} elseif(strlen($isbn) >= 13) {
			$getTrades = $this->pdo->prepare("SELECT * FROM trades WHERE isbn13 = :isbn AND status = 1");
			$getTrades->bindValue(':isbn', $isbn, PDO::PARAM_STR);
			$getTrades->execute();
		}


		return $getTrades;

	}

	public function fetchTradesForUser($uid){
		$getTrades = $this->pdo->prepare("SELECT * FROM trades WHERE creatorID = :uid AND status = 1 ORDER BY created_at DESC");
		$getTrades->bindValue(':uid', $uid, PDO::PARAM_STR);
		$getTrades->execute();

		return $getTrades;

	}

	public function closeTrade($tradeID){

		$close = $this->pdo->prepare("UPDATE trades SET status = 2 WHERE id = :tradeID");
		$close->bindValue(':tradeID', $tradeID, PDO::PARAM_STR);
		
		if($close->execute()){
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function deleteTrade($tradeID){
		$delete = $this->pdo->prepare("DELETE FROM trades WHERE id = :id");
		$delete->bindValue(':id', $tradeID, PDO::PARAM_STR);
		$delete->execute();
		return TRUE;
	}

	public function insertTrade($isbn10, $isbn13, $uid, $edition, $price, $condition){

		$newTrade = $this->pdo->prepare("INSERT INTO trades (`isbn10`, `isbn13`, `creatorID`, `condition`, `price`, `edition`, `created_at`, `status`) VALUES (:isbn10, :isbn13, :creatorID, :condition, :price, :edition, null, 1)");
		$newTrade->bindValue(':isbn10', $isbn10, PDO::PARAM_STR);
		$newTrade->bindValue(':isbn13', $isbn13, PDO::PARAM_STR);
		$newTrade->bindValue(':creatorID', $uid, PDO::PARAM_STR);
		$newTrade->bindValue(':condition', $condition, PDO::PARAM_STR);
		$newTrade->bindValue(':price', strval($price), PDO::PARAM_STR);
		$newTrade->bindValue(':edition', $edition, PDO::PARAM_STR);

			if($newTrade->execute()){
				return TRUE;
			} else {
				return FALSE;
			}

	}

	public function getRecent(){
		$getRecentTrades = $this->pdo->prepare("SELECT * FROM trades ORDER BY created_at DESC LIMIT 0 , 30");
		$getRecentTrades->execute();

		return $getRecentTrades;

	}

	public function generateConditions(){
		$getConditions = $this->pdo->prepare("SELECT * FROM `condition`");
		$getConditions->execute();

		$dropdown = "";
		$dropdown .= "<select name='condition'>\n";
		$dropdown .= "<option value='#' disabled>Book Condition</option>\n";

		while ($result = $getConditions->fetch(PDO::FETCH_ASSOC)) {
			$dropdown .= "<option value='".$result['conditionDesc']."'>".$result['conditionDesc']."</option>\n";
		}

		$dropdown .= "</select>";

		return $dropdown;

	}
	
}

?>
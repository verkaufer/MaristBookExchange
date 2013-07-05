<?php

  require_once("phpStart.php");

  if($_POST['isbnNum'] == "" || !isset($_POST['isbnNum'])){
    $_SESSION['FLASH.DATA'] = "Please enter an ISBN number.";
    header('Location: index.php');
    exit;
  }

	if($_POST['action'] == 'find'){
		$isbn = trim($_POST['isbnNum']);
        $isbn = str_replace("-", "", $isbn);

        $bookData = $trades->getBook($isbn);
        $results = $trades->fetchTradesForISBN($isbn); 
	} 

  require_once("header.php");
?>

    <div class="row">

         <section class="twelve columns push_two">
                <article class="valign row">
                <div>
                    <img src=<?php echo "'".$bookData['thumbnail']."'"; ?> border=0 alt='coverimg' />
                </div>
                <div>
                    <h4 style="padding-left:10px;"><i class="icon-book"></i> <?php echo $bookData['title'] ?></h4>
                    <p style="padding-left:10px;"><i class="icon-user"></i> <?php echo $bookData['author']; ?></p>
                    <p style="padding-left:10px;"><strong>ISBN-10:</strong> <?php echo $bookData['isbn10']; ?></p>
                    <p style="padding-left:10px;"><strong>ISBN-13:</strong> <?php echo $bookData['isbn13']; ?></p>

                </div>
            </article>
        </section>

    </div>
    
    <div class="row">
        &nbsp;
    </div>
    
    <div class="row" style="border-bottom:2px solid #000;">
        <div class="three columns" style="text-align:center;">
            <i class="icon-book"></i> Listed By
        </div>
        <div class="two columns" style="text-align:center;">
             Edition
        </div>
        <div class="three columns" style="text-align:center;">
           <i class="icon-info"></i> Condition
        </div>
        <div class="two columns" style="text-align:center;">
           <i class="icon-tag"></i> Price
        </div>
        <div class="two columns" style="text-align:center;">
           <i class="icon-mail"></i> Buy
        </div>
    </div>
    <?php 


        while($result = $results->fetch(PDO::FETCH_ASSOC)){

            $userinfo = $user->getUser($result['creatorID']);

            $output .= "<div class='row'>\n";
            $output .= "<div class='three columns' style='text-align:center;'>\n";
            $output .= $userinfo['username']."\n";
            $output .= "</div>\n";

            $output .= "<div class='two columns' style='text-align:center;'>\n";
            $output .= $result['edition']."\n";
            $output .= "</div>\n";

            $output .= "<div class='three columns' style='text-align:center;'>\n";
            $output .= $result['condition']."\n";
            $output .= "</div>\n";

            $output .= "<div class='two columns' style='text-align:center;'>\n";
            $output .= "$".$result['price']."\n";
            $output .= "</div>\n";

            if($user->loggedIn()){
                $output .= "<div class='two columns' style='text-align:center;'>\n";
                $output .= "<div class='small secondary btn icon-left entypo icon-mail'><a href='mailto:".$userinfo['email']."?Subject=I%20Would%20Like%20to%20Purchase%20Your%20Book - ".htmlentities($bookData['title'])."'>Contact</a></div>";
            } else {
                $output .= "<div class='two columns' style='text-align:center;'>\n";
                $output .= "<div class='small secondary btn icon-left entypo icon-user'><a href='login.php'>Log In</a></div>";
  
            }
            // $output .= "<form action='bookbuy.php' method='POST'>";
            // $output .= "<input type='hidden' name='tradeID' value='".$result['id']."' />";
            // $output .= "<input type='submit' class='linkButton' value='Buy' />";
            // $output .= "</form>";
            $output .= "</div>\n";


            $output .= "</div>";
            echo $output;
        }
    ?>




 

 
<!-- end of container and footer in footer.php -->

<?php require_once("footer.php");
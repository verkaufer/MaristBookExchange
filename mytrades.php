<?php

  require_once("phpStart.php");

  if(!$user->loggedIn()){
      $_SESSION['LOGIN.ERROR'] = "Please login before making a trade";
      header('Location: login.php');
      exit;
  }

        $myTrades = $trades->fetchTradesForUser($_SESSION['uid']); 
    

  require_once("header.php");
?>

    <div class="row">

        <h3>My Open Trades</h3>

    </div>
    
    <div class="row">
        &nbsp;
    </div>
    
    <div class="row" style="border-bottom:2px solid #000;">
        <div class="three columns" style="text-align:center;">
            <i class="icon-book"></i> ISBN13
        </div>
        <div class="one columns" style="text-align:center;">
             Delete?
        </div>
        <div class="three columns" style="text-align:center;">
           <i class="icon-info"></i> Condition
        </div>
        <div class="two columns" style="text-align:center;">
           <i class="icon-tag"></i> Price
        </div>
        <div class="two columns" style="text-align:center;">
           <i class="icon-tag"></i> Created At
        </div>
    </div>
    <?php 

        $results = $myTrades->fetchAll(PDO::FETCH_ASSOC);

        foreach($results as $result){

            $username = $user->getUser($result['creatorID']);

            //link to a page listing all books w/ this isbn
            $output .= "<div class='row'>\n";
            $output .= "<div class='three columns' style='text-align:center;'>\n";
            $output .= "<form action='books.php' method='POST'>";
            $output .= "<input type='hidden' name='isbnNum' value='".$result['isbn13']."' />";
            $output .= "<input type='hidden' name='action' value='find' />";
            $output .= "<input type='submit' class='linkButton' value='".$result['isbn13']."' />";
            $output .= "</form>";
           //$output .= $result['isbn13']."\n";
            $output .= "</div>\n";

            //delete button
            $output .= "<div class='one columns' style='text-align:center;'>\n";
            $output .= "<form action='delete.php' method='POST'>";
            $output .= "<input type='hidden' name='tradeID' value='".$result['id']."' />";
            $output .= "<input type='hidden' name='action' value='delete' />";
            $output .= "<button class='icoButton'><i class='icon-trash'></i></button>";
            $output .= "</form>";

            // $output .= $result['edition']."\n";
            $output .= "</div>\n";

            $output .= "<div class='three columns' style='text-align:center;'>\n";
            $output .= $result['condition']."\n";
            $output .= "</div>\n";

            $output .= "<div class='two columns' style='text-align:center;'>\n";
            $output .= "$".$result['price']."\n";
            $output .= "</div>\n";

            $output .= "<div class='two columns' style='text-align:center;'>\n";
            $output .= date("F j, Y, g:i a", strtotime($result['created_at']));
            $output .= "</div>\n";


            $output .= "</div>";
            echo $output;
        }
    ?>




 

 
<!-- end of container and footer in footer.php -->

<?php require_once("footer.php");
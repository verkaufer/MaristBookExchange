<?php

  require_once("phpStart.php");

        $recent = $trades->getRecent();

        $results = $recent->fetchAll(PDO::FETCH_ASSOC);




  require_once("header.php");
?>

    <div class="row">

        <h2>Recently Created Trades</h2>

    </div>
    
    <div class="row">
        &nbsp;
    </div>
    
    <div class="row" style="border-bottom:2px solid #000;">
        <div class="three columns" style="text-align:center;">
            <i class="icon-book"></i> ISBN
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
           <i class="icon-info"></i> Listed By
        </div>
    </div>
    <?php 


            foreach($results as $result){

            $username = $user->getUser($result['creatorID']);

            $output .= "<div class='row'>\n";
            $output .= "<div class='three columns' style='text-align:center;'>\n";
            $output .= "<form action='books.php' method='POST'>";
            $output .= "<input type='hidden' name='isbnNum' value='".$result['isbn13']."' />";
            $output .= "<input type='hidden' name='action' value='find' />";
            $output .= "<input type='submit' class='linkButton' value='".$result['isbn13']."' />";
            $output .= "</form>";

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

            $output .= "<div class='two columns' style='text-align:center;'>\n";
            $output .= $username['username']."\n";
            $output .= "</div>\n";


            $output .= "</div>";
            echo $output;
        }
    ?>




 

 
<!-- end of container and footer in footer.php -->

<?php require_once("footer.php");
<?php 
  require_once("phpStart.php");

  if(!$user->loggedIn()){
      $_SESSION['LOGIN.ERROR'] = "Please login before making a trade";
      header('Location: login.php');
      exit;
  }

  if($_POST['action'] == 'sell'){

        $isbn = trim($_POST['isbnNum']);
        $isbn = str_replace("-", "", $isbn);

        //$result = $books->fetchTradesForISBN($isbn);

        $bookData = $trades->getBook($isbn);

        if($bookData['title'] == "" || empty($bookData['title'])){
          $_SESSION['FLASH.DATA'] = "No book was found with that ISBN.";
          header('Location: index.php');
          exit;
        }
    
  }
  elseif($_POST['action'] == 'newTrade'){

    if($_POST['bookEdition'] == "" || $_POST['price'] == "" || $_POST['condition'] == ""){
          $_SESSION['FLASH.DATA'] = "Please enter all fields before submitting.";
          header('Location: index.php');
          exit;
    } 
    else {

        $isbn10    = $_POST['isbn10'];
        $isbn13    = $_POST['isbn13'];
        $uid       = $_SESSION['uid'];
        $edition   = $_POST['bookEdition'];
        $price     = $_POST['price'];
        $condition = $_POST['condition'];

        if($trades->insertTrade($isbn10, $isbn13, $uid, $edition, $price, $condition)){
            $_SESSION['FLASH.DATA'] = "Trade submitted successfully!";
            header('Location: index.php');
            exit;        
        } else {
            $_SESSION['FLASH.DATA'] = "An error occured when submitting your trade. Please try again.";
            header('Location: index.php');
            exit;        
        }

    }

  } 
  require_once("header.php");

?>

    <div class="row">
                 <div class="row">
                              <?php 
                    if(isset($_SESSION['FLASH.DATA']) && $_SESSION['FLASH.DATA'] != "")
                    { 
                        echo "<div class='four columns push_four'>
                            <li class='danger alert'>";
                        echo $_SESSION['FLASH.DATA']; $_SESSION['FLASH.DATA'] = FALSE;
                        echo "</li></div><br>";
                    } 
                ?>
              </div>

        <div class="twelve columns directions">
            <h3 class="directions">Sell Your Book</h3>
              <?php 
                if(isset($_SESSION['ERROR']) && $_SESSION['ERROR'] != "")
                { 
                  echo "<div class='four columns push_four'>
                    <li class='danger alert'>";
                  echo $_SESSION['ERROR']; $_SESSION['ERROR'] = FALSE;
                  echo "</li></div>";
                } 
              ?>
            <form action="newtrade.php" method="POST">
                <div class="row center">
                   <ul class="six columns push_three">

                        <li class="field center">Title<input class="numeric input" name="bookTitle" type="text" placeholder="Book Title" value="<?php echo $bookData['title']; ?>" readonly /></li>
                        <li class="field center">Edition<input class="numeric input" name="bookEdition" type="text" placeholder="Edition Number Only" /></li>
                        <li class="field center">ISBN10<input class="numeric input" name="isbn10_in" type="text" placeholder="ISBN-10" value="<?php echo $bookData['isbn10']; ?>" readonly /></li>
                        <li class="field center">ISBN13<input class="numeric input" name="isbn13_in" type="text" placeholder="ISBN-13" value="<?php echo $bookData['isbn13']; ?>" readonly /></li>
                        <li class="prepend field">
                          Selling Price 
                          <span class="adjoined">$</span>
                          <input class="normal numeric input" name="price" type="text" placeholder="Set Price" />
                        </li>
                          <li class="field">
                            Condition<br />
                            <div class="picker">
                              <?php 
                                echo $trades->generateConditions();
                              ?>
                            </div>
                          </li>
                    <input type="hidden" value="<?php echo $bookData['isbn10']; ?>" name="isbn10" />
                    <input type="hidden" value="<?php echo $bookData['isbn13']; ?>" name="isbn13" />
                   <input type="hidden" value="newTrade" name="action" />
                          <br>
                          <div class="medium primary btn"><input type="submit" value="Submit" /></div>
                   </ul>

            </form>
        </div>

    </div>


<?php
  require_once("footer.php");
?>
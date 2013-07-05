<?php 
  require_once("phpStart.php");
  require_once("header.php");

?>

    <div class="row">
                 <div class="row">
                              <?php 
                    if(isset($_SESSION['FLASH.DATA']) && $_SESSION['FLASH.DATA'] != "")
                    { 
                        echo "<div class='four columns push_four'>
                            <li class='primary alert'>";
                        echo $_SESSION['FLASH.DATA']; $_SESSION['FLASH.DATA'] = FALSE;
                        echo "</li></div><br>";
                    } 
                ?>
              </div>
        <div class="twelve columns directions">

            <h3 class="directions">Find Your Books</h3>
            <form action="books.php" method="POST">
                <div class="row center">
                   <ul class="six columns push_three">
                        <li class="field center"><input name="isbnNum" class="numeric input" type="numeric" placeholder="Type Book ISBN" /></li>
                        <input type="hidden" value="find" name="action" />
                          <div class="medium primary btn"><input type="submit" value="Submit" /></div>
                    </ul>
                
            </form>
            
        </div>
    </div>

        <div class="twelve columns directions">

            <h3 class="directions">Sell Your Books</h3>
                        <form action="newtrade.php" method="POST">
                <div class="row center">
                   <ul class="six columns push_three">
                        <li class="field center"><input name="isbnNum" class="numeric input" type="numeric" placeholder="Type Book ISBN" /></li>
                          <input type="hidden" value="sell" name="action" />
                          <div class="medium secondary btn"><input type="submit" value="Submit" /></div>
                    </ul>
              
            </form>
            </div>

        </div>
    </div>



</section>
<?php
  require_once("footer.php");
?>
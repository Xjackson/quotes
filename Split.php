<?php $page_title = ' Quote Split'; ?>
<?php 
  $nav_selected = "LIST";
  $left_buttons = "NO";
  $left_selected = "";
  require 'db_credentials.php'; 
    include("./nav.php");
	//error_reporting(0);
	include ("puzzlemaker.php");
?>
<script type="text/javascript" src="js/html2canvas.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<?php
include_once 'db_credentials.php'; 


  $sql = "SELECT * FROM quote_table
			WHERE id = '-1'";
			
			$db->set_charset("utf8");

$touched=isset($_POST['ident']);
if (!$touched) {
	echo 'You need to select an entry. Go back and try again. <br>';
	
	?>
		  <button><a class="btn btn-sm" href="admin.php">Go back</a></button>
	<?php
} else {     $id = $_POST['ident'];
    $sql = "SELECT * FROM quote_table
            WHERE id = '$id'";
}

if (!$resultQuote = $db->query($sql)) {
    die ('There was an error running query[' . $connection->error . ']');
}

$punctuation=TRUE;
echo '<h2 id="title">Split Quote</h2><br>';
  $sqx = "SELECT * FROM preferences WHERE name = 'KEEP_PUNCTUATION_MARKS'";
  $resultPunct = mysqli_query($db,$sqx);
  
  while ($rowPunct =mysqli_fetch_array($resultPunct))
  { 
  	$punctuation=$rowPunct["value"];	
  }


$nochars=3;
	$sqx = "SELECT * FROM preferences WHERE name = 'DEFAULT_CHUNK_SIZE'";
	$result2 = mysqli_query($db,$sqx);
	
	while ($row2 =mysqli_fetch_array($result2))
	{ 
		$nochars=$row2["value"];
	}

	if ($resultQuote->num_rows > 0) {
	while($row = $resultQuote->fetch_assoc()){
	
		$quoteline = $row["quote"];
	
	} 
	if (isset($quoteline) == false){
		exit(0);
	}
	else {
		if ($punctuation == "FALSE"){
			$quoteline = str_replace(['?', '!', "'", '.', '-', ';', ':', '[', ']',
			 ',', '/','{', '}', ')', '('], '', $quoteline);
		}
		SplitMaker($quoteline, $nochars);
	}
}
?>




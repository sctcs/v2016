<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(!isset($_SESSION['family_id']) || $_SESSION['family_id']=="")
{
 echo "Need to <a href=\"../MemberAccount/MemberLoginForm.php\">login</a>";
 //header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
include("balance_lib.php");

?>
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>

<body>



							<a href="JavaScript:window.print();">Print</a>
							<a href="JavaScript:window.history.back();">Back</a>
							<a href="../MemberAccount/MemberAccountMain.php">My Account</a>
							<a href="../MemberAccount/FamilyChildList.php">Child List</a><BR>

                            <?php ViewFamilyAccount($_SESSION['family_id'], $conn); ?>


<?php
function ViewFamilyAccount($ViewFamilyID,$conn)
{
	include("../common/CommonParam/params.php");

	if ( isset($_GET[date]) && $_GET[date] !="")
	{
	   $date = $_GET[date]." 24:00:00";
	} else {
	   $date = date("Y-m-d")." 24:00:00";
	}
	//echo $date;
	//if (! FamilyAccessCheck())
	//{
	//	echo "<h1>Invalid Account info Access</h1>\n";
	//	return 0;
?>
		<h2>Family Account Summary for <?php  echo "$ViewFamilyID as of $date"; ?></h2>
		<table border=1>
		<tr>
		    <th align="left" >No</th>
			<th align="center" ><a href="familyAccountSummary.php?date=<?php echo $_GET[date]; ?>&orderby=datetime">Date</a></th>

			<th align="left" >Member ID</th>
			<th align="center" ><a href="familyAccountSummary.php?date=<?php echo $_GET[date]; ?>&orderby=name">Name</a></th>
			<th align="left" >Charge/<br>Credit</th>
			<th align="left" >Payment/<br>Refund</th>

			<th align="left" >Description</th>
			<th align="left" >Balance</th>
			</tr>
<?php
	$TotalAmount=0;


//payments
        $query=  "SELECT p.`PaymentID` ID, p.`Date` DateTime,p.`FamilyID` FamilyID,PayerInfo ,p.`Amount`, `PaymentNote` Description "
                ."  FROM `tblPayment` p "
                ." WHERE p.familyid=".$ViewFamilyID. " AND p.Date < '". $date ."' "."      order by ID ";

	    $result=mysqli_query($conn,$query)  or Die ("Failed to query  $query ");
	    $i = 0;
		while($row = mysqli_fetch_array($result))
		{
			//$TotalAmount -=$row['Amount'];
			$i++;
            $payments[$i]['ID']=$row['ID'];
            $payments[$i]['DateTime']=$row['DateTime'];
            $payments[$i]['Timestamp']=strtotime($payments[$i]['DateTime']);
            //echo $payments[$i]['DateTime'];
            //echo "<br>";
            //echo $payments[$i]['Timestamp'];
            $payments[$i]['PayerInfo']=$row['PayerInfo'];
            $payments[$i]['Amount']=$row['Amount'];
            $payments[$i]['Description']=$row['Description'];
	     }



// receiveables

        $sql= "SELECT r.ID, r.DateTime, r.MemberID, t.FamilyID, t.FirstName, t.LastName, r.Amount, r.Description,r.ClassID "
               ."  FROM tblReceivable r, tblMember t"
               ." WHERE t.MemberID=r.MemberID AND t.FamilyID=".$ViewFamilyID. " AND r.DateTime <= '". $date ."' ";
         if ( isset($_GET[orderby]) && $_GET[orderby] == "name" ){
            $sql  .="    order by t.LastName, t.FirstName, r.DateTime ";
         } else {
            $sql   .="    order by r.DateTime ";
         }
   //echo $sql;
	$rs = mysqli_query($conn,$sql)  or Die ("Failed to query  $sql ");
		while($row = mysqli_fetch_array($rs))
		{
			//$TotalAmount +=$row['Amount'];

           $time0=strtotime($row['DateTime']);
           for ($i = 1; $i <= count($payments); ++$i) {
		     $time=$payments[$i][Timestamp];
		     if ( $time < $time0 && $payments[$i][printed]!=1 ) {
		       //echo $time0;
		      // echo "<BR>";
		      // echo $time;
		       $payments[$i][printed]=1;
		       $TotalAmount -=$payments[$i]['Amount'];
            ?>
			<tr>
		    <td align="right" > <?php echo  $payments[$i]['ID']; ?></td>
			<td align="left" ><?php  echo $payments[$i][DateTime]; ?>
			<td align="right" >&nbsp;</td>
			<td align="center" ><?php echo $payments[$i]['PayerInfo'];?>&nbsp;</td>
			<td align="right" >&nbsp;</td>
			<td align="right" ><?php  echo $payments[$i]['Amount'];?></td>

			<td align="left" ><?php  echo $payments[$i]['Description'];?>&nbsp;</td>
			<td align="right" ><?php  echo $TotalAmount;?></td>
			</tr>
        <?php
             } //end-if
           } //end-for

           $TotalAmount +=$row['Amount'];
		?>
			<tr>
		    <td align="right" ><?php echo $row['ID'];?></td>
			<td align="left" nowrap><?php  echo $row[DateTime]; //echo date( 'Y-m-d',strtotime($row['DateTime']));?></td>

			<td align="center" ><?php echo $row['MemberID'];?></td>
			<td align="center" ><?php echo $row['FirstName']." ".$row['LastName'];?></td>
			<td align="right" ><?php  echo $row['Amount'];?></td>
			<td align="right" >&nbsp;</td>

			<td align="left" ><?php  if ($row[ClassID] !="" && $row[ClassID] !="0" ){echo "[$row[ClassID]] ".$row['Description'];} else {echo $row['Description'];}?></td>
			<td align="right" ><?php  echo $TotalAmount;?></td>
			</tr>


		<?php
	       } //end-while

           for ($i = 1; $i <= count($payments); ++$i) {
		    // $time=$payments[$i][Timestamp];
		     if ( $payments[$i][printed]!=1 ) {
		       //echo $time0;
		      // echo "<BR>";
		      // echo $time;
		       $payments[$i][printed]=1;
		       $TotalAmount -=$payments[$i]['Amount'];
            ?>
			<tr>
		    <td align="right" > <?php echo  $payments[$i]['ID']; ?></td>
			<td align="left" ><?php  echo $payments[$i][DateTime]; ?>
			<td align="right" >&nbsp;</td>
			<td align="center" ><?php echo $payments[$i]['PayerInfo'];?>&nbsp;</td>
			<td align="right" >&nbsp;</td>
			<td align="right" ><?php  echo $payments[$i]['Amount'];?></td>

			<td align="left" ><?php  echo $payments[$i]['Description'];?>&nbsp;</td>
			<td align="right" ><?php  echo $TotalAmount;?></td>
			</tr>
        <?php
             } //end-if
           } //end-for

         ?>

	<TR><td colspan=2 align="right" valign=top>Balance as of <?php echo $date; ?>: </td>
            <td colspan=2 align="center" valign=top>
      <?php  if ( $TotalAmount < 0 ) { 
        $fid = $_SESSION['family_id'];
        $SQLstring = " SELECT CreditChoice FROM `tblFamily` WHERE `FamilyID`=".$fid;
        $RS1=mysqli_query($conn,$SQLstring);
        $RSA1=mysqli_fetch_array($RS1);
        $current_sel=  $RSA1[CreditChoice];
               if ( isset($current_sel) && ($current_sel == "RP" || $current_sel == "RM" ) ) {
                   echo "$".($TotalAmount + 0.00) ." - refund ($" .$TotalAmount . ") = $0"; 
               } else if ( isset($current_sel) && $current_sel == "D" ) {
                   echo "$".($TotalAmount + 0.00) ." - donation ($" .$TotalAmount . ") = $0"; 
               } else {
                   echo "$".($TotalAmount + 0.00); 
               }
            } else {
               echo "$".($TotalAmount + 0.00); 
            } ?>
            </td>
            <td colspan=4 align="left" >
<?php 
 if ( $TotalAmount > 0 ) { 
//echo $_SESSION['family_id'];
     $springdue = spring_due($conn,$_SESSION['family_id']);
     if ( $TotalAmount > $springdue && $springdue > 0  ) {
        echo "Please pay your total balance $". $TotalAmount . " now, <br> OR  <br>";        

        $falldue = $TotalAmount - $springdue;
       if ( $falldue > 50 ) {
        echo "<font color=red>pay your remaining fall due $".($TotalAmount - $springdue). " as soon as possible,</font> <br>"; 
       } else {
         $pchoice = pay_selection($conn, $_SESSION['family_id'] );
         //echo $pchoice;
         if ( isset($pchoice) && $pchoice == "S" ) {
            echo "You have chosen to pay this fall due $" . $falldue . " along with your future spring payment,<br> ";
            echo "if you want to pay unpaid fall due $". $falldue . " in fall, please change your 
              <a href=\"paymentChoice.php?choose=fall\">payment choice</a> here, and<br> ";
         } else if ( isset($pchoice) && $pchoice == "F" ) {
            echo "You have chosen to pay this fall due $" . $falldue . " in fall, <br>";
            echo "if you want to pay unpaid fall due $". $falldue . " along with spring payment, please change your 
              <a href=\"paymentChoice.php?choose=spring\">payment choice</a> here, and<br> ";
         } else {
            echo "if you want to pay unpaid fall due $". $falldue . " along with spring due later, please state your 
              <a href=\"paymentChoice.php?choose=spring\">payment choice</a> here, and<br> ";
         }
       }
        echo "<font color=orange>pay your spring tuition $" . $springdue . " on or before the first school day in spring.</font>";
     } else if ( $TotalAmount > $springdue && $springdue == 0  ) {
       $psel = pay_selection( $conn, $_SESSION['family_id']);
       if ( $psel =="D" ) {
        echo "You are disputing the unpaid balance, you can view or update it <a href=\"disputeBalance.php\">here</a>";
       } else {
        echo "Please pay your total balance $". $TotalAmount . " , or <a href=\"disputeBalance.php\">Dispute</a> the balance.<br>";        
      }
     } else {
        echo "<font color=orange>Please pay your remaining spring tuition $" . $TotalAmount . " on or before the first school day in spring.</font>";
     }
 } else if ( $TotalAmount < 0 ) {

        echo "You had a credit, ";
      if ( isset($current_sel) && $current_sel == "RP" ) {
        echo "<b>you chose to request a refund and pick up</b> from school office. <br>While your request is being processed, NO action is needed from you.<br> However, if you want to change your selection, please ";
      } else if ( isset($current_sel) && $current_sel == "RM" ) {
        echo "<b>you chose to request a refund and have it mailed</b> to you.<br>While your request is being processed,  NO action is needed from you.<br> However, if you want to change your selection, please ";
      } else if ( isset($current_sel) && $current_sel == "D" ) {
        echo "<b>you chose to donate it to school</b>.<br>While your request is being processed, NO action is needed from you.<br> However, if you want to change your selection, please ";
      } else if ( isset($current_sel) && $current_sel == "K" ) {
        echo "<b>you chose to leave it in your account</b>.<br> No action is needed from you.<br> However, if you want to change your selection, please ";
      } else {
        echo "you can leave the credit in your account for future use.<br> No action is needed from you.<br> Or you can ";
       }
        echo "do one of the following:<br>";
        echo "<ul><li><a href=\"creditSelection.php?FamilyID=".$_SESSION['family_id']."&selection=K\" target=_blank>keep it in my account</a>,";
        echo "    <li><a href=\"creditSelection.php?FamilyID=".$_SESSION['family_id']."&selection=RP\" target=_blank>request a refund to be picked up</a>,";
        echo "    <li><a href=\"creditSelection.php?FamilyID=".$_SESSION['family_id']."&selection=RM\" target=_blank>request a refund to be mailed </a>,";
        echo "    <li><a href=\"creditSelection.php?FamilyID=".$_SESSION['family_id']."&selection=D\" target=_blank>donate to our school</a>, Thank you!";
        echo "</ul>";
      } else {
        echo "&nbsp;Your balance is zero.";
      } ?>
     </td>
	</tr></table>
<a name="balance"></a>
	<?php if ($date != date("Y-m-d")." 24:00:00" ){
	    //  echo date('Y-m-d');
	      echo "<a href=\"familyAccountSummary.php?date=". date("Y-m-d") ."\">View balance as of today</a>";
	     } else {
	      echo "<a href=\"familyAccountSummary.php?date=".$CurrentYear."-06-01\">View balance as of ".$CurrentYear."-06-01</a>";
	     }
     //echo "<br><a href=\"index.php?view=UpdateReceivable&FamilyID=".$_SESSION['family_id']."\">Update My Receivables</a>";
    ?>
    <p>Note: Billing records of your recent changes to class registration will be added shortly when treasurer reconciles the billing system.</p>
 <?php
	mysqli_close($conn);
}

?>

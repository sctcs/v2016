<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

if ( isset($_GET[FamilyID]) && $_GET[FamilyID] !="" ) {
   $fid= $_GET[FamilyID];
} else {
   $fid     =$_SESSION['family_id'];
}

	$SQLstring = " SELECT Balance FROM `viewFamiliesBalance` WHERE `FamilyID`=".$fid;

	$RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);
        $balance=( 0 - $RSA1[Balance]);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SCCS Donation Receipt</title>
</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr >
             <td>
                 <img src="./sccs.png">
             </td>
        </tr>
					<?php


						$SQLstring = "select DISTINCT MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  "
						            ."where   MB.FamilyID=".$fid;
						//echo "see: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						//$RSA1=mysqli_fetch_array($RS1);

						$SQLpc = "select *   from tblMember  where tblMember.FamilyID=".$fid." and PrimaryContact='Yes'";
						$RS2=mysqli_query($conn,$SQLpc);
						$RSA2=mysqli_fetch_array($RS2);

					?>
	<tr><td></td> </tr>
	<tr>
		<td align="right">EIN: 20-4180579</td>
	</tr>
	<tr>
		<td align="center"><h2>Donation Receipt</h2></td>
	</tr>
	<tr><td></td> </tr>

	<tr>
	<td align="left"> Date: <span style="text-decoration: underline;"><?php echo date("m/d/Y");?>__________</span>
        </td></tr>

	<tr><td><br></td> </tr>
	<tr>
	<td align="left"> Name: <span style="text-decoration: underline;">
	<?php 
             $name = $RSA2[FirstName]." ".$RSA2[LastName];
             $nlen = strlen($name);
             $uline = $name;
             for ($i=1;$i<(20 - $nlen);$i++ ){
              $uline .= "_";
             }

        echo $uline . "</span><br>";
        echo "</td></tr>";
        ?> 
	<tr><td><br></td> </tr>
	<tr><td align="left">Address: <span style="text-decoration: underline;">
        <?php 
	$address =  $RSA2[HomeAddress].", " . 
		$RSA2[HomeCity].",  ".$RSA2[HomeState]." ".$RSA2[HomeZip]."";
             $nlen = strlen($address);
             $uline = $address;
             for ($i=1;$i<(50 - $nlen);$i++ ){
              $uline .= "_";
             }

        echo $uline . "</span><br>";
         ?>

	</td> </tr>
	<tr><td><br></td> </tr>
	<tr> <td>
Thank you for your recent donation of $ <span style="text-decoration: underline;">__<?php echo $balance; ?>__</span> to the Southern Connecticut Chinese School. Your donation will help us build a stronger Chinese community and culture center.<BR><BR>
Southern Connecticut Chinese school is a nonprofit educational organization with EID #20-4180579, and was determined by the IRS of US Treasurer Department on May 6, 2008 to be an income tax exempt 501 (c) (3) organization. Therefore, your contribution is tax deductible according to the IRS regulations. This letter can be used as the receipt of your donation.<BR><BR>

Your continuous support is highly appreciated. <BR><BR>

Southern Connecticut Chinese School<BR>
	</td> </tr>

	<tr><td><br></td> </tr>

        <tr> 
             <td align=left>________________________(Signature)*  </td></tr>
	<tr><td><br></td> </tr>
        <tr>
             <td align=left>________________________(Title)       <br>
	</td> </tr>
	<tr><td><br></td> </tr>

	<tr> <td>*<i>without a school officer&#39;s signature, this receipt is invalid</i><br>
	</td> </tr>
	<tr><td><br></td> </tr>

	<tr> <td align=center>
          Southern Connecticut Chinese School, Inc. an IRS registered nonprofit organization under 501(c)3, is committed to fulfilling their mission without discrimination on the basis of race, color, religion, sex, national origin, sexual orientation, age, marital status, ancestry or disabilities.
	</td> </tr>
        
</table>
</body>
</html>

<?php
    mysqli_close($conn);
 ?>

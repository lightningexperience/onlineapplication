<?php include("config.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Monthly Mortgage Calculator</title>
<?php 
/*================================================================================
| payments.php
|
| Created by: 
| Date: 2012-04-12
|
| Displays the Mortgage Payments Calculator
================================================================================*/

error_reporting(0);
?>
<!-------------------------------------------------------------------------------
	Include css for validation
--------------------------------------------------------------------------------->
<link rel="stylesheet" type="text/css" media="screen" href="css/jquery-ui.css" />
<!-------------------------------------------------------------------------------
	Include css for calculator css
--------------------------------------------------------------------------------->
<link rel="stylesheet" type="text/css" media="screen" href="css/calculatorstyle.css" />
<!-------------------------------------------------------------------------------
	Include js for validation
--------------------------------------------------------------------------------->
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<!-------------------------------------------------------------------------------
	Include js for number validation
--------------------------------------------------------------------------------->
<script type="text/javascript" src="js/masks.js"></script>

<!-------------------------------------------------------------------------------

	Include js for number FusionCharts

--------------------------------------------------------------------------------->

<script LANGUAGE="Javascript" SRC="FusionCharts/FusionCharts.js"></script>

<script LANGUAGE="Javascript" SRC="js/FusionChartsDOM.js"></script>

<!-------------------------------------------------------------------------------
	Start validation script
--------------------------------------------------------------------------------->
<script type="text/javascript">
// change class when error found
$.validator.setDefaults({
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});

$().ready(function() {

	// number validation 
	oNumberMask = new Mask(".####", "number");
	oNumberMask.attach(document.getElementById('loanamount'));
	oNumberMask.attach(document.getElementById('interestrate'));
	oNumberMask.attach(document.getElementById('months'));
	oNumberMask.attach(document.getElementById('property'));
	oNumberMask.attach(document.getElementById('estimateproperty'));
	oNumberMask.attach(document.getElementById('propertytaxes'));
	oNumberMask.attach(document.getElementById('hazardinsurance'));
	oNumberMask.attach(document.getElementById('mortgageinsurance'));
	// validate paymentsform form on keyup and submit

	$("#paymentsform").validate({

		rules: {

			loanamount: "required",

			interestrate: "required",			

			months: "required",			

			amortization: "required",			

			property: "required",			

			estimateproperty: "required",			

			propertytaxes: "required",			

			hazardinsurance: "required",			

			mortgageinsurance: "required",			

		},

		messages: {

			loanamount: "",

			interestrate: "",			

			months: "",			

			amortization: "",			

			property:"",

			estimateproperty:"",

			propertytaxes:"",

			hazardinsurance:"",

			mortgageinsurance:"",		

		}

	});

	$("#paymentsform input:not(:submit)").addClass("ui-widget-content");	

	$(":submit").button();

});



</script>

<!-------------------------------------------------------------------------------

	End validation script

--------------------------------------------------------------------------------->

<!-------------------------------------------------------------------------------

	Form start

--------------------------------------------------------------------------------->
</head>
<body>
<div id="calc_wrapper">
<h1 class="calc_head">MORTGAGE PAYMENTS CALCULATOR</h1>
<form method="POST" action="" id="paymentsform" name="paymentsform" class="cmxform" >

	<h3 class="formsubheading">MORTGAGE LOAN INFORMATION</h3>		

	<div class="calc-panel">
		<table>		
		<tr>
		<td class="seventy">Mortgage loan amount ($)</td>		
		<td><input type="text" id="loanamount" name="loanamount" value="200000"></td>
		</tr>
		<tr>
			<td>Annual interest rate</td> 			
			<td><input type="text" id="interestrate" name="interestrate" value="5%"></td>
		</tr>
		<tr>
		<td>Number of months: (30yrs=360)</td>
		<td><input type="text" id="months" name="months" value="360"></td>
		</tr>
		<tr>
		<td>Desired amortization schedule</td>
		<td><select id="amortization" name="amortization" >
		<option value="monthly">monthly</option>
		<option value="yearly">yearly</option>
		</select></td>		</tr>	
		</table>

		<div style="clear: both;"></div>

	</div>

	<h3 class="formsubheading">PROPERTY INFORMATION</h3>	

	<div class="calc-panel">

		<div class="calc-text">
		<table>		<tr>		<td class="seventy">Sale price of property ($)</td>		<td><input type="text" id="property" name="property" value="0"></td>		</tr>				<tr>		<td class="seventy">Let system estimate property taxes, insurance, and private mortgage insurance? If No then detail</td>		<td><select name="selectestimate" id="selectestimate" >					<option value="yes" >Yes</option>					<option value="no" >No</option>					</select></td>		</tr>				<tr>
		<td>Annual property taxes ($)</td>		<td><input type="text" id="propertytaxes" name="propertytaxes"  value="0"></td>		</tr>
		<tr>		<td>Annual hazard insurance ($)</td>		<td><input type="text" id="hazardinsurance" name="hazardinsurance" value="0"></td>		</tr>				<tr>		<td>Monthly private mortgage insurance ($)</td>		<td><input type="text" id="mortgageinsurance" name="mortgageinsurance" value="0"></td>		</tr>		</table>

		</div>
		</div>
	<h3 class="formsubheading">PERSONAL INFORMATION</h3>	

	<div class="calc-panel">

		<div class="calc-text">
		<table>		
		<tr>		
		<td class="seventy">Your Name</td>		
		<td><input type="text" id="name" name="name" value=""></td>
		</tr>
		<tr>
		<td class="seventy">Your Email *</td>
		<td><input type="email" id="email" name="email" value=""></td>
		</tr>
		</table>

		</div>

		<div style="clear: both;"></div>

	</div>

	<br>
<div style="text-align:center;">

	<input type="submit" value="Submit" id="submit" name="submit" class="calc-submit submit">
</div>
</form>
</div>

<!-------------------------------------------------------------------------------

	Form End

--------------------------------------------------------------------------------->

<br>

<?php

/*================================================================================

	Php script for form result

================================================================================*/

		if(isset($_POST['submit'])){

		if($_POST['email']=='')
		{
		echo "<script type='text/javascript'> alert('Please enter your Email Id'); </script>";
		}
		else
		{
		$Current_loan_balance=$_POST["loanamount"];

		$Annual_interest_rate=$_POST["interestrate"];

		$Number_of_months_remaining=$_POST["months"];
		
		$loan_holder_name=$_POST["name"];
		
		$loan_holder_email=$_POST["email"];

		
		$result = pg_query($conn, “insert into paymentcalculator(loanamount,interestrate,months,ortizationschedule,name,email) values('$Current_loan_balance','$Annual_interest_rate','$Number_of_months_remaining','$_POST[amortization]','$loan_holder_name','$loan_holder_email')");
var_dump($result);

// Closing connection
pg_close($dbconn);


		/*=========================================================================

		===========================================================================

					               LOAN PAYMENT FORMULA

								   --------------------

		===========================================================================

		==========================================================================*/

			$annual_rate_become= $Annual_interest_rate / 1200 ;

			$middlecalculation1 = 1 + $annual_rate_become; 

			$month = round($Number_of_months_remaining);

			for($i=1;$i<=$month;$i++){

				if($caratstring == "")

					$caratstring = $middlecalculation1;

				else 

					$caratstring = $caratstring * $middlecalculation1;

			}

			$middlecalculation2 = ($annual_rate_become) / (($caratstring)-1); 

			$middlecalculation3 = $annual_rate_become + $middlecalculation2 ; 

			$payment = $middlecalculation3 * $Current_loan_balance;

			$roundpayment = round($payment,2);

			$Total_loan_cost = $roundpayment * $Number_of_months_remaining;			

			$Total_loan_int = $Total_loan_cost - $Current_loan_balance;	

			

			if($_POST["selectestimate"] == "no"){

				$property_taxes =round($_POST["propertytaxes"] / 12 , 2);

				$PMI=$_POST["mortgageinsurance"];

				$hazerd_ins=round($_POST["hazardinsurance"]/12,2);

			}

			else{

				$property_taxes = round(($_POST["property"] / 12) * 0.01 , 2);

				$PMI=round(($Current_loan_balance / 12)* 0.0052, 2);

				$hazerd_ins=round($_POST["property"] * 0.00025 , 2);

			}

			$Total_monthly_payment	= $roundpayment	+ $property_taxes + $PMI + $hazerd_ins;

			?>

				<!----------------------------------------------------------------------------------------------------------------------------------

				Calculated Result

				------------------------------------------------------------------------------------------------------------------------------------>

				<div id="resultsoutput" >
					<h2 class="results">Results</h2>
					<table cellspacing="0" cellpadding="0" class="calcoutputtable">
						<tr>
							<td style="margin:0 0 0 10px">Your estimated monthly payments are $<?php echo $roundpayment; ?> (including taxes, insurance, and PMI if applicable), and you will pay $<?php echo $Total_loan_int; ?> in interest over the life of the loan.
							</td>

						</tr>

						<tr>

							<td>&nbsp;</td>

						</tr>

							<tr>

								<td>

									<table class="simpletable" summary="Summary Table">

										<tr>

											<th>Loan Information</th>

											<th></th>

										</tr>

										<tr>

											<td>Loan amount</td>

											<td><?php echo $Current_loan_balance; ?></td>

										</tr>

										<tr>

											<td>Annual interest rate</td>

											<td><?php echo $Annual_interest_rate; ?></td>

										</tr>

										<tr>

											<td>Number of months</td>

											<td><?php echo $Number_of_months_remaining; ?></td>

										</tr>

										<tr>

											<td>Monthly principal and interest payment</td>

											<td>$<?php echo $roundpayment; ?></td>

										</tr>

										<tr>

											<td>Monthly property taxes</td>

											<td>$<?php echo $property_taxes; ?></td>

										</tr>

										<tr>

											<td>Monthly hazard insurance</td>

											<td>$<?php echo $hazerd_ins; ?></td>

										</tr>

										<tr>

											<td>Monthly PMI (if applicable)</td>

											<td>$<?php echo $PMI; ?></td>

										</tr>

										<tr>

											<td>Total monthly payment (including taxes, insurance, and PMI)</td>

											<td>$<?php echo $Total_monthly_payment; ?></td>

										</tr>

									</table>

								</td>

							</tr>

						<tr>

							<td>&nbsp;</td>

						</tr>

						<tr>

							<td>&nbsp;</td>

						</tr>

						<tr>

							<td>

								<table class="simpletable" summary="Detail Table">

									<tr>

										<th>Year</th>

										<th>Beginning Balance</th>

										<th>Interest</th>

										<th>Payment</th>

										<th>Ending Balance</th>

									</tr>

									<?php 

									

										if($_POST["amortization"] == 'monthly'){

											$annual_payment = $payment * 12;											

											$monthly_payment = $payment;

											$Current_balance =$Current_loan_balance;

											$i=$Number_of_months_remaining / 12;											

											$count = 0;	

											$year=0;

											while($i > 0){	

											$year++;

											for($j=1;$j<=12;$j++){										

													$count++;

													if($j== 1){

														$Interest_total = 0;

													}

													$monthlyint=$Annual_interest_rate/1200;

													$Interest = $Current_loan_balance * $monthlyint;													

													$Ending_Balance1=($Current_loan_balance + $Interest) - $monthly_payment;

													$Current_loan_balance1= round($Current_loan_balance);

													$Ending_Balance= round($Ending_Balance1);

													$monthly_payment1 = round ($monthly_payment);

													$Interest1 = round ($Interest);

													$Ending_Balance=abs($Ending_Balance);

													$Current_loan_balance = $Ending_Balance1;											

													$Interest_total = $Interest_total + $Interest;	

													?>

														<tr>

															<td><?php echo $count; ?></td>

															<td>$<?php echo $Current_loan_balance1; ?></td>

															<td>$<?php echo $Interest1 ?></td>

															<td>$<?php echo $monthly_payment1; ?></td>

															<td>$<?php echo $Ending_Balance; ?></td>

														</tr>

													<?php 

												

												}											

											$Ending_Balance1_total = ($Current_balance + $Interest_total) - $annual_payment; 

											$Interest_totalround = round($Interest_total);											

											$annual_paymentround = round($annual_payment);

											$Ending_Balance1_totalround = round($Ending_Balance1_total);

											$Current_balanceround = round($Current_balance);

											$Interest_totalround1 = round($Interest_totalround1+$Interest_total);											

											$annual_paymentround1 = round($annual_paymentround1+$annual_payment);				

										

											//interest string

											if($stringinterest == "")

												$stringinterest = $Interest_totalround1; 

											else

												$stringinterest.= ",".$Interest_totalround1; 

											//payment string

											if($stringpayment == "")

												$stringpayment = $annual_paymentround1;

											else

												$stringpayment.= ",".$annual_paymentround1; 

											//balance string

											if($stringbalance == "")

												$stringbalance = $Ending_Balance1_totalround; 

											else

												$stringbalance.= ",".$Ending_Balance1_totalround; 

											

												$Current_balance = $Ending_Balance1_total;

												$i--;								

											

											}										

										}

										else{

											$annual_payment = $payment * 12;											

											$monthly_payment = $payment;

											$Current_balance =$Current_loan_balance;

											$i=$Number_of_months_remaining / 12;											

											$count = 0;	

											$year=0;

											while($i > 0){	

											$year++;

											for($j=1;$j<=12;$j++){										

													$count++;

													if($j== 1){

														$Interest_total = 0;

													}

													$monthlyint=$Annual_interest_rate/1200;

													$Interest = $Current_loan_balance * $monthlyint;													

													$Ending_Balance1=($Current_loan_balance + $Interest) - $monthly_payment;

													$Current_loan_balance1= round($Current_loan_balance);

													$Ending_Balance= round($Ending_Balance1);

													$monthly_payment1 = round ($monthly_payment);

													$Interest1 = round ($Interest);

													$Ending_Balance=abs($Ending_Balance);

													$Current_loan_balance = $Ending_Balance1;											

													$Interest_total = $Interest_total + $Interest;								

												

												}											

											$Ending_Balance1_total = ($Current_balance + $Interest_total) - $annual_payment; 

											$Interest_totalround = round($Interest_total);											

											$annual_paymentround = round($annual_payment);

											$Ending_Balance1_totalround = round($Ending_Balance1_total);

											$Current_balanceround = round($Current_balance);

											$Interest_totalround1 = round($Interest_totalround1+$Interest_total);											

											$annual_paymentround1 = round($annual_paymentround1+$annual_payment);

												

											//interest string

											if($stringinterest == "")

												$stringinterest = $Interest_totalround1; 

											else

												$stringinterest.= ",".$Interest_totalround1; 

											//payment string

											if($stringpayment == "")

												$stringpayment = $annual_paymentround1;

											else

												$stringpayment.= ",".$annual_paymentround1; 

											//balance string

											if($stringbalance == "")

												$stringbalance = $Ending_Balance1_totalround; 

											else

												$stringbalance.= ",".$Ending_Balance1_totalround; 

											?>

											<tr>

												<td><?php echo $count; ?></td>

												<td>$<?php echo $Current_balanceround; ?></td>

												<td>$<?php echo $Interest_totalround ?></td>

												<td>$<?php echo $annual_paymentround; ?></td>

												<td>$<?php echo $Ending_Balance1_totalround; ?></td>

											</tr>

									<?php 

												$Current_balance = $Ending_Balance1_total;

												$i--;								

											

											}										

										}

										

											

									?>

								</table>

							</td>

						</tr>

					<tr>

						<td>&nbsp;</td>

					</tr>

					<tr>

					</tr>

					<tr>

						<td>&nbsp;</td>

					</tr>

				</table>

				</div>

				<input type="hidden" name="noofmonth" id="noofmonth" value="<?php echo $year; ?>" >

				<input type="hidden" name="interest" id="interest" value="<?php echo $stringinterest; ?>" >

				<input type="hidden" name="payment" id="payment" value="<?php echo $stringpayment; ?>" >

				<input type="hidden" name="balance" id="balance" value="<?php echo $stringbalance; ?>" >
				
		

<script>

// chart script

		var data = new Array();

		var interest=document.getElementById('interest').value;

		var intereststr=interest.split(",");

		var strintcnt=interest.split(",").length;

		data[0] = new Array();

		data[0][0]="Interest";

		for(var i = 0;i<strintcnt;i++){						

				data[0][i+1] = intereststr[i];			

		}

		var payment=document.getElementById('payment').value;

		var paymentstr=payment.split(",");

		var strpaycnt=payment.split(",").length;

		data[1] = new Array();

		data[1][0]="Payment";

		for(var i = 0;i<strpaycnt;i++){		

				data[1][i+1] = paymentstr[i];					

		}

		var balance=document.getElementById('balance').value;

		var balancestr=balance.split(",");

		var strbalcnt=balance.split(",").length;

		data[2] = new Array();

		data[2][0]="Balance";

		for(var i = 0;i<strbalcnt;i++){			

				data[2][i+1] = balancestr[i];			

		}

		//the array of colors contains 4 unique Hex coded colours (without #) for the 4 products

		var colors=new Array("AFD8F8", "F6BD0F", "8BBA00", "FF8E46");

		

		/**

		 * updateChart method is called, when user changes any of the checkboxes.

		 * Here, we generate the XML data again and build the chart.		  

		 *	@param	domId	domId of the Chart

		*/

		function updateChart(domId){			

				//Update it's XML - set animate Flag from AnimateChart checkbox in form

				//using updateChartXML method defined in FusionCharts.js

				updateChartXML(domId,generateXML(this.document.productSelector.AnimateChart.checked));

		}



		/**

		 * generateXML method returns the XML data for the chart based on the

		 * checkboxes which the user has checked.

		 *	@param	animate		Boolean value indicating to  animate the chart.

		 *	@return				XML Data for the entire chart.

		*/		

		function generateXML(animate){			

			//Variable to store XML

			var strXML="";

			

			//<graph> element

			//Added animation parameter based on animate parameter			

			//Added value related attributes if show value is selected by the user

			strXML = "<graph numberPrefix='$' decimalPrecision='0' animation='" + ((animate==true)?"1":"0") + "' " + ((this.document.productSelector.ShowValues.checked==true)?("showValues='1' rotateValues='1'"):(" showValues='0' ")) + "yaxismaxvalue='800000'>";



			//Store <categories> and child <category> elements

			var noofmonth=document.getElementById("noofmonth").value;

			strXML = strXML +"<categories>";

			for(var i=1;i<=noofmonth;i++){

			strXML = strXML +"<category name='"+i+"' />";

			}

			strXML = strXML +"</categories>";



			//Based on the products for which we've to generate data, generate XML			

			strXML = (this.document.productSelector.ProductA.checked==true)?(strXML + getProductXML(0)):(strXML);

			strXML = (this.document.productSelector.ProductB.checked==true)?(strXML + getProductXML(1)):(strXML);

			strXML = (this.document.productSelector.ProductC.checked==true)?(strXML + getProductXML(2)):(strXML);

			



			//Close <graph> element;

			strXML = strXML + "</graph>";



			//Return data

			return strXML;

		}

		

		/**

		 * getProductXML method returns the <dataset> and <set> elements XML for

		 * a particular product index (in data array). 

		 *	@param	productIndex	Product index (in data array)

		 *	@return					XML Data for the product.

		*/

		function getProductXML(productIndex){	

			

			var productXML;

			var noofmonth=document.getElementById("noofmonth").value;

			//Create <dataset> element taking data from 'data' array and color vaules from 'colors' array defined above

			productXML = "<dataset seriesName='" + data[productIndex][0] + "' color='"+ colors[productIndex]  +"' >";			

			//Create set elements

			for (var i=1; i<=noofmonth; i++){			

				productXML = productXML + "<set value='" + data[productIndex][i] + "' />";

			}

			//Close <dataset> element

			productXML = productXML + "</dataset>";

			//Return dataset data

			return productXML;			

		}

		





</script>


				<div id="resultsoutput" >
							<table width="100%" class="charttable">

								<tr>

									<td style="border:none;">

										<FORM NAME='productSelector' Id='productSelector' action='Chart.html' method='POST' >

											<h3 style="width:601px;" class="formsubheading">Please select the products for which you want to plot the chart:</h3>

											<INPUT TYPE='Checkbox' name='ProductA' onClick="JavaScript:updateChart('chart1Id');" checked />&nbsp;Interest &nbsp;&nbsp;

											<INPUT TYPE='Checkbox' name='ProductB' onClick="JavaScript:updateChart('chart1Id');" checked />&nbsp;Payment &nbsp;&nbsp;

											<INPUT TYPE='Checkbox' name='ProductC' onClick="JavaScript:updateChart('chart1Id');" checked />&nbsp;Balance &nbsp;&nbsp;

											

											

											<BR /><BR />

											<h3 style="width:601px;" class="formsubheading">Chart Configuration:</h3><br>

											<INPUT TYPE='Checkbox' name='AnimateChart' />Animate chart while changing data?&nbsp;&nbsp;

											<INPUT TYPE='Checkbox' name='ShowValues' onClick="JavaScript:updateChart('chart1Id');" />Show Data Values?&nbsp;&nbsp;

										</FORM>

										<br/>

									<div id="chartContainer" align="center">Charts XT will load here!</div> 

										

										<script language="JavaScript">					

											var chart1 = new FusionCharts("FusionCharts/FCF_MSColumn3D.swf", "chart1Id", "600", "400");		   

											//Initialize graph with chart data returned by generateXML() function. [ note: the parameter 'this.document.productSelector.AnimateChart.checked' is passed to set animation property of the chart]

											//loading XML data into variable strXML 

											var strXML=generateXML(this.document.productSelector.AnimateChart.checked);

											chart1.setDataXML(strXML);

											chart1.render("chartContainer");

										</script>

									</td>

								</tr>

							</table>

						</div>
						
						<?php
					$to = $loan_holder_email;
                    $subject = "Mortgage Payments  Calculator Result";
					$txt="Hello $loan_holder_name,<br />";
                    $txt .= "Your estimated monthly payments are $$roundpayment (including taxes, insurance, and PMI if applicable), and you will pay  $$Total_loan_int in interest over the life of the loan.";
					$txt .= "<br /> Best Regards, <br />".$Webmaster_Name."<br />".$Website_Name;
                    $headers = "From: ".$Webmaster_Email . "\r\n" .
					$headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    mail($to,$subject,$txt,$headers);
        ?> 
<?php

		}
}

?>

</body>
</html>
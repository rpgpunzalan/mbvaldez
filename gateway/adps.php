<?php
	session_start();
	include '../utils/functions.php';

	$db = new adps_functions();
	// $db->sec_session_start(); // Our custom secure way of starting a PHP session.
  if(isset($_GET['op'])){
    $op = $_GET['op'];

    switch($op){
      case "addItem":{
        if(isset($_SESSION['user_id'])&&isset($_POST['supplier_id'])&&isset($_POST['item_description'])&&isset($_POST['cost'])){
					$record_id = $db->addRecord($_SESSION['user_id']);
          $item_id = $db->addItem($_POST['item_description'],$_POST['cost'],$_POST['srp'],$_POST['srp'],$_POST['supplier_id'],$record_id);
          echo json_encode(array("status"=>"success", "user_id"=>$item_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "addSupplier":{
        if(isset($_SESSION['user_id'])&&isset($_POST['supplier_name'])&&isset($_POST['address'])&&isset($_POST['contact_no'])){
          $record_id = $db->addRecord($_SESSION['user_id']);
          $supplier_id = $db->addSupplier($_POST['supplier_name'],$_POST['address'],$_POST['contact_no'],$record_id);
          if(is_numeric($supplier_id)) echo json_encode(array("status"=>"success", "user_id"=>$supplier_id));
          else echo json_encode(array("status"=>"failed", "message"=>$supplier_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "addCustomer":{
        if(isset($_SESSION['user_id'])&&isset($_POST['customer_name'])&&isset($_POST['address'])&&isset($_POST['contact_no'])&&isset($_POST['area'])){
          $record_id = $db->addRecord($_SESSION['user_id']);
          $customer_id = $db->addCustomer($_POST['customer_name'],$_POST['address'],$_POST['contact_no'],$_POST['area'],$record_id,$_POST['preseller']);
          if(is_numeric($customer_id)) echo json_encode(array("status"=>"success", "user_id"=>$customer_id));
          else echo json_encode(array("status"=>"failed", "message"=>$customer_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "getSupplierList": {
        $res = $db->getSupplierList();
        echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
      }
      case "getCustomerList": {
        $res = $db->getCustomerList();
        echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
      }
      case "getSupplierByID": {
				if(isset($_POST['supplier_id'])){
          $res = $db->getSupplierById($_POST['supplier_id']);
          echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "getCustomerByID": {
				if(isset($_POST['customer_id'])){
          $res = $db->getCustomerById($_POST['customer_id']);
          echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "getInventory": {
				if(isset($_POST['d1'])&&isset($_POST['d2'])){
					if($_POST['d1']==""&&$_POST['d2']==""){
						$res = $db->getInventoryRange($_POST['d1'],$_POST['d2']);
					}else {
						$res = $db->getInventory();
					}

        }else $res = $db->getInventory();
				echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
      }
      case "getItemById": {
				if(isset($_POST['item_id'])){
					$res = $db->getItemById($_POST['item_id']);
					echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "getItemBySupplier": {
				if(isset($_POST['supplier_id'])){
					$res = $db->getItemBySupplier($_POST['supplier_id']);
					$supplierDetails = $db->getSupplierById($_POST['supplier_id']);
					echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res,"supplierDetails"=>$supplierDetails));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "getItems": {
		$res = $db->getItemList();
		$supplierDetails = $db->getItemList();
		echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
      }
			case "addExpense": {
				if(isset($_POST['expense_id'])&&isset($_POST['expense_date'])&&isset($_POST['payee'])&&isset($_POST['total_amount'])){
					$record_id = $db->addRecord($_SESSION['user_id']);
					// $due_date = date_add($date,date_interval_create_from_date_string("2 days"));
					$expense_id = $db->addExpense(date_create($_POST['expense_date']),$_POST['payee'],$_POST['address'],$_POST['account_title'],$_POST['total_amount'],1,0,date_create($_POST['expense_date']),-1,$record_id);
					if(is_numeric($expense_id)){
						$itemList = $_POST['itemList'];
						for($i=0;$i<count($itemList);$i++){
							$db->addExpenseItem($_POST['expense_id'],$itemList[$i][0],$itemList[$i][1]);
						}
						echo json_encode(array("status"=>"success","expense_id"=>$expense_id));
					}else echo json_encode(array("status"=>"failed", "message"=>$expense_id));

				}else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
				break;
			}
			case "addCashVoucher":{

        if(isset($_POST['voucher_id'])&&isset($_POST['voucher_date'])&&isset($_POST['payee'])&&isset($_POST['itemList'])&&isset($_POST['total_amount'])){
          $record_id = $db->addRecord($_SESSION['user_id']);
					$date = date_create($_POST['voucher_date']);
					// $due_date = date_add($date,date_interval_create_from_date_string("2 days"));
          $sale_id = $db->addCashVoucher($_POST['voucher_id'],date_create($_POST['voucher_date']),$_POST['payee'],$_POST['total_amount']);
          if(is_numeric($sale_id)){
						$itemList = $_POST['itemList'];
						for($i=0;$i<count($itemList);$i++){
							$item_id = $db->addCashVoucherItem($_POST['voucher_id'],$itemList[$i][0],$itemList[$i][1]);
						}
						echo json_encode(array("status"=>"success","voucher_id"=>$sale_id));
					}
          else echo json_encode(array("status"=>"failed", "message"=>$sale_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
			case "addCheckVoucher":{

        if(isset($_POST['voucher_id'])&&isset($_POST['voucher_date'])&&isset($_POST['payee'])&&isset($_POST['itemList'])&&isset($_POST['total_amount'])){
          $record_id = $db->addRecord($_SESSION['user_id']);
					$date = date_create($_POST['voucher_date']);
					// $due_date = date_add($date,date_interval_create_from_date_string("2 days"));
          $sale_id = $db->addCheckVoucher($_POST['voucher_id'],date_create($_POST['voucher_date']),$_POST['payee'],$_POST['check_no'],$_POST['total_amount']);
          if(is_numeric($sale_id)){
						$itemList = $_POST['itemList'];
						for($i=0;$i<count($itemList);$i++){
							$item_id = $db->addCheckVoucherItem($_POST['voucher_id'],$itemList[$i][0],$itemList[$i][1]);
						}
						echo json_encode(array("status"=>"success","voucher_id"=>$sale_id));
					}
          else echo json_encode(array("status"=>"failed", "message"=>$sale_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
			case "addSale":{

        if(isset($_POST['sale_id'])&&isset($_POST['sale_date'])&&isset($_POST['total_amount'])&&isset($_POST['itemList'])&&isset($_POST['discount'])){
          $record_id = $db->addRecord($_SESSION['user_id']);
					$date = date_create($_POST['sale_date']);
					$customer = $db->getCustomerById($_POST['customer_id'])[0];
					// $due_date = date_add($date,date_interval_create_from_date_string("2 days"));
					if($_POST['discount']>0)
						{
							$expense_id = $db->addExpense(date_create($_POST['sale_date']),$customer['customer_name'],$customer['address'],1,$_POST['discount'],1,$_POST['discount'],date_create($_POST['sale_date']),-1,$record_id);
							$db->addExpenseItem($expense_id,"Discount for Sale Number ".$_POST['sale_id'],$_POST['discount']);

						}
          $sale_id = $db->addSale($_POST['customer_id'],date_create($_POST['sale_date']),$_POST['total_amount'],$record_id,$_POST['discount']);
          if(is_numeric($sale_id)){
						$itemList = $_POST['itemList'];
						for($i=0;$i<count($itemList);$i++){
							$item_id = $db->addSaleItem($sale_id,$itemList[$i][0],$itemList[$i][1],$itemList[$i][2]);
							$db->addInventory($itemList[$i][0],($itemList[$i][1]*-1),$itemList[$i][2],date_create($_POST['sale_date']),$record_id);
							$db->addReturnEmpty($item_id,$_POST['customer_id'],0,$itemList[$i][1]*1,date_create($_POST['sale_date']));
						}
						echo json_encode(array("status"=>"success","sale_id"=>$sale_id));
					}
          else echo json_encode(array("status"=>"failed", "message"=>$sale_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
			case "addReturn":{

        if(isset($_POST['return_id'])&&isset($_POST['return_date'])&&isset($_POST['total_amount'])&&isset($_POST['itemList'])){
          $record_id = $db->addRecord($_SESSION['user_id']);
					// $due_date = date_add($date,date_interval_create_from_date_string("2 days"));
          $return_id = $db->addReturn($_POST['customer_id'],date_create($_POST['return_date']),$_POST['total_amount']);
					if(is_numeric($return_id)){
						$itemList = $_POST['itemList'];
						for($i=0;$i<count($itemList);$i++){
							$item_id = $db->addReturnItem($_POST['return_id'],$itemList[$i][0],$itemList[$i][1],$itemList[$i][2]);
							$db->addInventory($itemList[$i][0],($itemList[$i][1]),$itemList[$i][2],date_create($_POST['return_date']),$record_id);
							$db->updateSaleItem($_POST['sale_id'],$itemList[$i][0],$itemList[$i][1],$itemList[$i][2]);
						}
						echo json_encode(array("status"=>"success","return_id"=>$return_id));
					}
          else echo json_encode(array("status"=>"failed", "message"=>$return_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }

      	case "addReturnEmpty":{

        if(isset($_POST['return_date'])&&isset($_POST['itemList'])){

			$itemList = $_POST['itemList'];
			for($i=0;$i<count($itemList);$i++){
				$return_id = $db->addReturnEmpty($_POST['return_id'],$itemList[$i][0],$_POST['customer_id'],$itemList[$i][1],$itemList[$i][2],date_create($_POST['return_date']));
				$empty_id = $db->addInventoryEmpty($_POST['return_id'],$itemList[$i][0],$itemList[$i][1],$itemList[$i][2]);
			}
			echo json_encode(array("status"=>"success"));

          //else echo json_encode(array("status"=>"failed", "message"=>$return_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
      case "addCustomerDeposit":{ /**SEPT4**/

        if(isset($_POST['return_date'])&&isset($_POST['itemList'])){

			$itemList = $_POST['itemList'];
			$deposit_amount = 0;
			for($i=0;$i<count($itemList);$i++){
				$deposit_amount += ($itemList[$i][3]*$itemList[$i][1])+($itemList[$i][4]*$itemList[$i][2]);
				$empty_id = $db->addReturnEmpty($itemList[$i][0],$_POST['customer_id'],($itemList[$i][1]*-1),($itemList[$i][2]*-1),date_create($_POST['return_date']));
			}
			$return_id = $db->addCustomerDeposit($_POST['customer_id'],$_POST['return_date'],$deposit_amount);
			echo json_encode(array("status"=>"success"));

          //else echo json_encode(array("status"=>"failed", "message"=>$return_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }

      case "addMBDeposit":{ /**SEPT4**/

        if(isset($_POST['return_date'])&&isset($_POST['itemList'])){

			$itemList = $_POST['itemList'];
			$deposit_amount = 0;
			for($i=0;$i<count($itemList);$i++){
				$deposit_amount += ($itemList[$i][3]*$itemList[$i][1])+($itemList[$i][4]*$itemList[$i][2]);
				$empty_id = $db->addReturnEmpty($itemList[$i][0],$_POST['customer_id'],($itemList[$i][1]),($itemList[$i][2]),date_create($_POST['return_date']));
			}
			$return_id = $db->addMBDeposit($_POST['customer_id'],$_POST['return_date'],$deposit_amount);
			echo json_encode(array("status"=>"success"));

          //else echo json_encode(array("status"=>"failed", "message"=>$return_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }

      case "searchShipment":{

        if(isset($_POST['shipment_no'])){
        	$data = $db->searchShipment($_POST['shipment_no']);
    		echo json_encode(array("status"=>"success", "data"=>$data));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }

      case "updateZeroBalance":{

        if(isset($_POST['shipment_no'])){
        	$data = $db->updateZeroBalance($_POST['shipment_no']);
    		echo json_encode(array("status"=>"success", "data"=>$data));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }

      case "updateBalance":{

        if(isset($_POST['shipment_no'])){

        	$po_id = $_POST['po_id'];
        	$new_paid = $_POST['new_paid'];

        	for($i=0;$i<count($po_id);$i++){
				$db->updateBalance($_POST['shipment_no'],$new_paid[$i],$po_id[$i]);
			}
    		echo json_encode(array("status"=>"success"));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }


      case "addPurchaseOrder":{

        if(isset($_POST['po_id'])&&isset($_POST['po_date'])&&isset($_POST['total_amount'])&&isset($_POST['itemList'])&&isset($_POST['discount'])){
          $record_id = $db->addRecord($_SESSION['user_id']);
					$date = date_create($_POST['po_date']);
					$due_date = date_add($date,date_interval_create_from_date_string("2 days"));
          $po_id = $db->addPurchaseOrder($_POST['po_id'],$_POST['supplier_id'],date_create($_POST['po_date']),$_POST['total_amount'],$due_date,1,$record_id,$_POST['discount'],$_POST['shipment_no']);
          if(is_numeric($po_id)){



						$itemList = $_POST['itemList'];
						for($i=0;$i<count($itemList);$i++){
							$item_id = $db->addPOItem($po_id,$itemList[$i][0],$itemList[$i][1],$itemList[$i][2]);
							$db->addInventory($itemList[$i][0],$itemList[$i][1],$itemList[$i][2],date_create($_POST['po_date']),$record_id);
							$db->addReturnEmpty($itemList[$i][0],$_POST['supplier_id'],0,($itemList[$i][1]*-1),date_create($_POST['po_date']));
						}
						echo json_encode(array("status"=>"success","po_id"=>$po_id));
					}
          else echo json_encode(array("status"=>"failed", "message"=>$po_id));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
      }
			case "getCashVoucherById": {
				if(isset($_GET['voucher_id'])){
						$items = $db->getCashVoucherItems($_GET['voucher_id']);
						$res = $db->getCashVoucherById($_GET['voucher_id']);
						echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res,"items"=>$items));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
			}
		case "prepareDelivery": {
			if(isset($_GET['d1'])){
					$res = $db->prepareDelivery($_GET['d1'],$_GET['preseller']);
					echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        	}else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        	break;
		}
			case "getCheckVoucherById": {
				if(isset($_GET['voucher_id'])){
						$items = $db->getCheckVoucherItems($_GET['voucher_id']);
						$res = $db->getCheckVoucherById($_GET['voucher_id']);
						echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res,"items"=>$items));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
			}
			case "getPurchaseOrderById": {
				if(isset($_GET['po_id'])){
						$items = $db->getPOItems($_GET['po_id']);
						$res = $db->getPurchaseOrderById($_GET['po_id']);
						echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res,"items"=>$items));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
			}
			case "getReturnById": {
				if(isset($_GET['return_id'])){
						$items = $db->getReturnItems($_GET['return_id']);
						$res = $db->getReturnById($_GET['return_id']);
						echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res,"items"=>$items));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
			}
			case "getSaleById": {
				if(isset($_GET['sale_id'])){
						$items = $db->getSaleItems($_GET['sale_id']);
						$res = $db->getSaleById($_GET['sale_id']);
						echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res,"items"=>$items));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
			}
			case "getExpenseById": {
				if(isset($_GET['expense_id'])){
						$items = $db->getExpenseItems($_GET['expense_id']);
						$res = $db->getExpenseById($_GET['expense_id']);
						echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res,"items"=>$items));
        }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
        break;
			}
			case "getPurchaseOrderList": {
				if(isset($_POST['d1'])&&isset($_POST['d2'])){
					if($_POST['d1']==""&&$_POST['d2']==""){
						$res = $db->getPurchaseOrderListRange($_POST['d1'],$_POST['d2']);
					}else {
						$res = $db->getPurchaseOrderList();
					}

        }else $res = $db->getPurchaseOrderList();
				echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
			}
			case "getCashVoucherList": {
				if(isset($_POST['d1'])&&isset($_POST['d2'])){
					if($_POST['d1']==""&&$_POST['d2']==""){
						$res = $db->getCashVoucherListRange($_POST['d1'],$_POST['d2']);
					}else {
						$res = $db->getCashVoucherList();
					}

        }else $res = $db->getCashVoucherList();
				echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
			}
			case "getCheckVoucherList": {
				if(isset($_POST['d1'])&&isset($_POST['d2'])){
					if($_POST['d1']==""&&$_POST['d2']==""){
						$res = $db->getCheckVoucherListRange($_POST['d1'],$_POST['d2']);
					}else {
						$res = $db->getCheckVoucherList();
					}

        }else $res = $db->getCheckVoucherList();
				echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
			}
			case "getSaleOrderList": {
				if(isset($_GET['d1'])&&isset($_GET['d2'])){
					if($_GET['d1']!=""&&$_GET['d2']!=""){
						$res = $db->getSaleListRange($_GET['d1'],$_GET['d2']);
					}else {
						$res = $db->getSaleList();
					}

        }else $res = $db->getSaleList();
				echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
			}
			case "getExpenseList": {
				if(isset($_POST['d1'])&&isset($_POST['d2'])){
					if($_POST['d1']==""&&$_POST['d2']==""){
						$res = $db->getExpenseListRange($_POST['d1'],$_POST['d2']);
					}else {
						$res = $db->getExpenseList();
					}

        }else $res = $db->getExpenseList();
				echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
			}
			case "getReturnList": {
				if(isset($_POST['d1'])&&isset($_POST['d2'])){
					if($_POST['d1']==""&&$_POST['d2']==""){
						$res = $db->getPurchaseOrderListRange($_POST['d1'],$_POST['d2']);
					}else {
						$res = $db->getReturnList();
					}

        }else $res = $db->getReturnList();
				echo json_encode(array("status"=>"success","length"=>sizeOf($res),"result"=>$res));
        break;
			}

	      case "addPayment":{
	      if(isset($_SESSION['user_id'])&&isset($_POST['po_id'])&&isset($_POST['payment_method'])&&isset($_POST['amount'])&&isset($_POST['trans_date'])&&isset($_POST['cc_id'])){
	        $record_id = $db->addRecord($_SESSION['user_id']);
					$db->addCashFlow($_POST['amount'],"OCS Number ".$_POST['po_id'],date_create($_POST['trans_date']),1,$record_id);
					if($_POST['cc_id']!=-1){
						$db->addCompanyCheck($_POST['cc_id'],1,date_create($_POST['trans_date']),$_POST['amount']);

					}
					$db->addPayment($_POST['payment_method'],$_POST['amount'],date_create($_POST['trans_date']),$_POST['cc_id']);
	        $db->recordPOPayment($_POST['po_id'],$_POST['amount'],$_POST['payment_method'],$_POST['cc_id']);
					echo json_encode(array("status"=>"success"));
	      }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
	      break;
	    }

	    	case "addPaymentShipment":{
	      if(isset($_SESSION['user_id'])&&isset($_POST['payment_method'])&&isset($_POST['amount'])&&isset($_POST['trans_date'])&&isset($_POST['cc_id'])){
					if($_POST['cc_id']!=-1){
						$db->addCompanyCheck($_POST['cc_id'],1,date_create($_POST['trans_date']),$_POST['amount']);

					}
					$db->addPayment($_POST['payment_method'],$_POST['amount'],date_create($_POST['trans_date']),$_POST['cc_id']);
					echo json_encode(array("status"=>"success","ccid"=>$_POST['cc_id']));
	      }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
	      break;
	    }

			case "addPaymentSales":{
		    if(isset($_SESSION['user_id'])&&isset($_POST['sale_id'])&&isset($_POST['payment_method'])&&isset($_POST['amount'])&&isset($_POST['trans_date'])&&isset($_POST['cc_id'])){
		      $record_id = $db->addRecord($_SESSION['user_id']);
					$db->addCashFlow($_POST['amount'],"Sale Number ".$_POST['sale_id'],date_create($_POST['trans_date']),2,$record_id);
					if($_POST['cc_id']!=-1){
						$db->addCustomerCheck($_POST['cc_id'],$_POST['bank_id'],date_create($_POST['check_date']),$_POST['amount'],5);
					}
					$db->addCollection($_POST['payment_method'],$_POST['amount'],date_create($_POST['trans_date']),$_POST['cc_id']);
		      $ret = $db->recordSaleCollection($_POST['sale_id'],$_POST['amount'],$_POST['payment_method'],$_POST['cc_id']);
					echo json_encode(array("status"=>"success"));
		    }else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
		    break;
		  }
			case "getIncomeStatement":{
				if(isset($_GET['d1'])&&isset($_GET['d2'])){
		      		$res = $db->getIncomeStatementSales($_GET['d1'],$_GET['d2']);
		    	}
		    	if($res){

		    		$total_sales = 0;
		    		$total_discount = 0;
		    		$total_cost = 0;
		    		$netsales = 0;

		    		foreach($res as $sales){
							$total_sales = $total_sales + $sales['total_amount'];
							$total_discount = $total_discount + $sales['discount'];
							$item_id = $db->getIncomeStatementSaleItem($sales['sale_id']);
							$cost = $db->getIncomeStatementItems($item_id);
							$total_cost = $total_cost + $cost;
						}
					$expenses = $db->getIncomeStatementExpenses();
					$netsales = $total_sales - $total_discount;
					//$total_cost = 0;
					echo json_encode(array("status"=>"success","netsales"=>$netsales,"total_cost"=>$total_cost,"expenses"=>$expenses));
				}else{
					echo json_encode(array("status"=>"success","result"=>"empty"));
				}
				break;
			}
			case "recordWithdraw":{
				if(isset($_GET['d1'])&&isset($_GET['d2'])&&isset($_GET['d3'])){
		      		$res = $db->recordWithdraw($_GET['d1'],$_GET['d2'],$_GET['d3']);
		    	}
		    	if($res){
					echo json_encode(array("status"=>"success"));
				}else{
					echo json_encode(array("status"=>"success","result"=>"empty"));
				}
				break;
			}
			case "recordDeposit":{
				if(isset($_GET['dateDeposit'])&&isset($_GET['bankacctDeposit'])&&isset($_GET['amountDeposit'])&&isset($_GET['checknumber'])&&isset($_GET['checkdate'])){
		      		$res = $db->recordDeposit($_GET['dateDeposit'],$_GET['bankacctDeposit'],$_GET['amountDeposit']);
		      		$res2 = $db->addCompanyCheck($_GET['checknumber'],$_GET['bankacctDeposit'],$_GET['checkdate'],$_GET['amountDeposit']);
		    	}
		    	if($res2){
					echo json_encode(array("status"=>"success", "res2"=>$res2));
				}else{
					echo json_encode(array("status"=>"success","res2"=>$res2));
				}
				break;
			}
			case "getInventoryReport":{
				if(isset($_GET['d1'])&&isset($_GET['d2'])){
		      		$res = $db->getInventoryReportQuantity($_GET['d1'],$_GET['d2']);
		    	}
		    	if($res){
		    		$items = $db->getInventoryReportItems();
					echo json_encode(array("status"=>"success","res"=>$res,"items"=>$items));
				}else{
					echo json_encode(array("status"=>"success","result"=>"empty"));
				}
				break;
			}
			case "getPayableCollectibleReport":{
				if(isset($_GET['d1'])&&isset($_GET['d2'])){
		      		$payables = $db->getPayableReport($_GET['d1'],$_GET['d2']);
		      		$collectibles = $db->getCollectibleReport($_GET['d1'],$_GET['d2']);
		      		if($payables && $collectibles){

			    		$total_payable = 0;
			    		$total_collectible = 0;

			    		foreach($payables as $payable){
							$total = $payable['total_amount'] - $payable['amount_paid'];
							$total_payable = $total_payable + $total;
						}

						foreach($collectibles as $collectible){
							$total = $collectible['total_amount'] - $collectible['amount_paid'];
							$total_collectible = $total_collectible + $total;
						}

						echo json_encode(array("status"=>"success","payables"=>$total_payable,"collectibles"=>$total_collectible));
					}else{
						echo json_encode(array("status"=>"success","result"=>"empty"));
					}

		    	}else{
					echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
				}
				break;
			}
			case "getWeeklyPayableCollectibleReport":{
				$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
				$sunday = date( 'Y-m-d', strtotime( 'sunday this week' ) );
	      		$payables = $db->getPayableReport($monday,$sunday);
	      		$collectibles = $db->getCollectibleReport($monday,$sunday);
	      if($payables && $collectibles){

		    		$total_payable = 0;
		    		$total_collectible = 0;

		    		foreach($payables as $payable){
							$total_payable = $total_payable + ($payable['total_amount'] - $payable['amount_paid']);
						}
					foreach($collectibles as $collectible){
						$total_collectible = $total_collectible + ( $collectible['total_amount'] - $collectible['amount_paid']);
					}

					echo json_encode(array("status"=>"success","payables"=>$total_payable,"collectibles"=>$total_collectible,"startDate"=>$monday,"endDate"=>$sunday));
				}else{
					echo json_encode(array("status"=>"success","result"=>$payables,"startDate"=>$monday,"endDate"=>$sunday));
				}
				break;
			}
			case "getCashflowListByDate":{
				if(isset($_GET['cf_date'])){;
		      $res = $db->getCashflowListByDate($_GET['cf_date']);
					echo json_encode(array("status"=>"success","result"=>$res));
				}else echo json_encode(array("status"=>"failed", "message"=>"check parameters"));
				break;
			}
			case "getCashflow":{
		    if(isset($_GET['d1'])&&isset($_GET['d2'])){
		      $res = $db->getCashflowListWithRange($_GET['d1'],$_GET['d2']);
		    }else $res = $db->getCashflowList();

				if($res){
					$inflow = [];
					$outflow = [];
					$prevDate = $res[0]['cf_date'];
					$dateList = [];
					$totalInflow = 0;
					$totalOutflow = 0;

					foreach($res as $cf){

						if($prevDate!=$cf['cf_date']){
							array_push($inflow,$totalInflow);
							array_push($outflow,$totalOutflow);
							array_push($dateList,$prevDate);
							$prevDate = $cf['cf_date'];
							$totalInflow = 0;
							$totalOutflow = 0;
						}
						if($cf['category']==2)
							$totalInflow += $cf['amount'];
						else $totalOutflow += $cf['amount'];
					}

					array_push($inflow,$totalInflow);
					array_push($outflow,$totalOutflow);
					array_push($dateList,$prevDate);

					echo json_encode(array("status"=>"success","result"=>$res,"inflow"=>$inflow,"outflow"=>$outflow,"dateList"=>$dateList));
				}else{
					echo json_encode(array("status"=>"success","result"=>"empty"));
				}

		    break;
		  }
      default: {
				echo json_encode(array("status"=>"failed", "message"=>"Invalid Operation"));
        break;
      }
    }
  }

	if(isset($_GET['updatepatient'])){
		$patientId = $_POST['patientId'];
		$firstName = $_POST['firstName'];
		$middleName = $_POST['middleName'];
		$lastName = $_POST['lastName'];
		$birthday = $_POST['birthday'];
		$barangay = $_POST['barangay'];
		$city = $_POST['city'];
		$province = $_POST['province'];
		$zipcode = $_POST['zipcode'];
		$religion = $_POST['religion'];
		$nationality = $_POST['nationality'];
		$civilStatus = $_POST['civilStatus'];
		$sex = $_POST['sex'];
		$email = $_POST['email'];
		$occupation = $_POST['occupation'];
		$contactNumber = $_POST['contactNumber'];
		$data = array();
		if($db->updatePatient($patientId,$firstName,$middleName,$lastName,$birthday,$barangay,$city,$province,$zipcode,$religion,$nationality,$civilStatus,$sex,$email,$occupation,$contactNumber)){
			$data['success'] = 1;
		}else{
			$data['success'] = 0;
		}
		echo json_encode($data);
	}

	if(isset($_GET['retrievepatient'])){
		$patientId = $_GET['patientId'];
		echo json_encode($db->retrievePatient($patientId));
	}

	if(isset($_GET['retrievepatientlist'])){
		echo json_encode($db->retrievePatientList());
	}

?>

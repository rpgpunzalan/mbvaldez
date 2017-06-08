<?php
require_once('../inc/dbinfo.inc');

class adps_functions{

	private function connect() {
		$link = new mysqli( HOSTNAME, USERNAME, PASSWORD, DATABASE ) or die ( 'Could not connect: ' . mysqli_error () );
		mysqli_select_db ( $link, DATABASE ) or die ( 'Could not select database' . mysql_error () );
		return $link;
	}

	public function sec_session_start() {
	    $session_name = 'sec_session_id';   // Set a custom session name
	    /*Sets the session name.
	     *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP.
	     */
	    session_name($session_name);

	    $secure = true;
	    // This stops JavaScript being able to access the session id.
	    $httponly = true;
	    // Forces sessions to only use cookies.
	    if (ini_set('session.use_only_cookies', 1) === FALSE) {
	        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
	        exit();
	    }
	    // Gets current cookies params.
	    $cookieParams = session_get_cookie_params();
	    session_set_cookie_params($cookieParams["lifetime"],
	        $cookieParams["path"],
	        $cookieParams["domain"],
	        $secure,
	        $httponly);

	    session_start();            // Start the PHP session
	    session_regenerate_id(true);    // regenerated the session, delete the old one.
	}

	public function setIncrement($tableName,$val){
    $link = $this->connect();
    $query=sprintf("ALTER TABLE `".$tableName."` AUTO_INCREMENT = ".$val.";");

    mysqli_query($link, $query);
  }
  public function addUser($username,$password,$access_level){
    $link = $this->connect();
    $query=sprintf("INSERT INTO users(username,password,access_level)
                      VALUES('".mysqli_real_escape_string($link,$username)."','".mysqli_real_escape_string($link,$password)."','".mysqli_real_escape_string($link,$access_level)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }
  public function editUserDetails($userId,$username,$password,$access_level){
    $link = $this->connect();
    $query=sprintf("UPDATE users
                    SET username = '".mysqli_real_escape_string($link,$username)."',
                    password = '".mysqli_real_escape_string($link,$password)."',
                    access_level = '".mysqli_real_escape_string($link,$access_level)."'
                    WHERE user_id = '".mysqli_real_escape_string($link,$userId)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }
  public function deactivateUser($userId){
    $link = $this->connect();
    $query=sprintf("UPDATE users
                    SET access_level = '-99'
                    WHERE user_id = '".mysqli_real_escape_string($link,$userId)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addRecord($user_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO recording(user_id,device)
                      VALUES('".mysqli_real_escape_string($link,$user_id)."','".mysqli_real_escape_string($link,$_SERVER['HTTP_USER_AGENT'])."')");

    if (mysqli_query($link, $query)) {
        return mysqli_insert_id($link);
    }
  }

  public function addSupplier($supplier_name,$address,$contact_number,$record_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO suppliers(supplier_name,address,contact_number,record_id)
                      VALUES('".mysqli_real_escape_string($link,$supplier_name)."',
                            '".mysqli_real_escape_string($link,$address)."',
                            '".mysqli_real_escape_string($link,$contact_number)."',
                            '".mysqli_real_escape_string($link,$record_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editSupplierDetails($supplier_id,$supplier_name,$address,$contact_number,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE suppliers
                    SET supplier_name = '".mysqli_real_escape_string($link,$supplier_name)."',
                    address = '".mysqli_real_escape_string($link,$address)."',
                    contact_number = '".mysqli_real_escape_string($link,$contact_number)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE supplier_id = '".mysqli_real_escape_string($link,$supplier_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }


  public function addCustomer($customer_name,$address,$contact_number,$area_id,$record_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO customers(customer_name,address,contact_no,area_id,record_id)
                      VALUES('".mysqli_real_escape_string($link,$customer_name)."',
                            '".mysqli_real_escape_string($link,$address)."',
                            '".mysqli_real_escape_string($link,$contact_number)."',
                            '".mysqli_real_escape_string($link,$area_id)."',
                            '".mysqli_real_escape_string($link,$record_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editCustomerDetails($customer_id,$customer_name,$address,$contact_number,$area_id,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE customers
                    SET customer_name = '".mysqli_real_escape_string($link,$username)."',
                    address = '".mysqli_real_escape_string($link,$password)."',
                    contact_number = '".mysqli_real_escape_string($link,$access_level)."',
                    area_id = '".mysqli_real_escape_string($link,$area_id)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE customer_id = '".mysqli_real_escape_string($link,$customer_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }


  public function addAccountTitle($account_name,$segment){
    $link = $this->connect();
    $query=sprintf("INSERT INTO account_titles(account_name,segment)
                      VALUES('".mysqli_real_escape_string($link,$account_name)."',
                            '".mysqli_real_escape_string($link,$segment)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editAccountTitle($account_title_id,$account_name,$segment){
    $link = $this->connect();
    $query=sprintf("UPDATE account_titles
                    SET account_name = '".mysqli_real_escape_string($link,$account_name)."',
                    segment = '".mysqli_real_escape_string($link,$segment)."'
                    WHERE account_title_id = '".mysqli_real_escape_string($link,$account_title_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addArea($area_name){
    $link = $this->connect();
    $query=sprintf("INSERT INTO areas(area_name)
                      VALUES('".mysqli_real_escape_string($link,$area_name)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editArea($area_id,$area_name){
    $link = $this->connect();
    $query=sprintf("UPDATE areas
                    SET area_name = '".mysqli_real_escape_string($link,$area_id)."'
                    WHERE area_id = '".mysqli_real_escape_string($link,$area_name)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addCashFlow($amount,$particulars,$cf_date,$category,$record_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO cashflow(amount,particulars,cf_date,category,record_id)
                    VALUES('".mysqli_real_escape_string($link,$amount)."',
                          '".mysqli_real_escape_string($link,$particulars)."',
                          '".mysqli_real_escape_string($link,date_format($cf_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$category)."',
                          '".mysqli_real_escape_string($link,$record_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editCashFlow($cf_id,$amount,$particulars,$cf_date,$category,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE cashflow
                    SET amount = '".mysqli_real_escape_string($link,$amount)."',
                    particulars = '".mysqli_real_escape_string($link,$particulars)."',
                    cf_date = '".mysqli_real_escape_string($link,$cf_date)."',
                    category = '".mysqli_real_escape_string($link,$category)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE cf_id = '".mysqli_real_escape_string($link,$cf_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addBankAccount($account_number,$bank_id,$branch,$initial_balance,$current_balance){
    $link = $this->connect();
    $query=sprintf("INSERT INTO bank_accounts(account_number,bank_id,branch,initial_balance,current_balance)
                    VALUES('".mysqli_real_escape_string($link,$account_number)."',
                          '".mysqli_real_escape_string($link,$bank_id)."',
                          '".mysqli_real_escape_string($link,$branch)."',
                          '".mysqli_real_escape_string($link,$initial_balance)."',
                          '".mysqli_real_escape_string($link,$current_balance)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editBankAccount($account_number,$bank_id,$branch,$initial_balance,$current_balance){
    $link = $this->connect();
    $query=sprintf("UPDATE bank_accounts
                    SET bank_id = '".mysqli_real_escape_string($link,$bank_id)."',
                    branch = '".mysqli_real_escape_string($link,$branch)."',
                    initial_balance = '".mysqli_real_escape_string($link,$initial_balance)."',
                    current_balance = '".mysqli_real_escape_string($link,$current_balance)."'
                    WHERE account_number = '".mysqli_real_escape_string($link,$account_number)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function recordWithdraw($d1,$d2,$d3){
    $link = $this->connect();
    $query=sprintf("UPDATE bank_accounts
                    SET current_balance = current_balance - '".mysqli_real_escape_string($link,$d3)."'
                    WHERE account_number = '".mysqli_real_escape_string($link,$d2)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function recordDeposit($d1,$d2,$d3){
    $link = $this->connect();
    $query=sprintf("UPDATE bank_accounts
                    SET current_balance = current_balance + '".mysqli_real_escape_string($link,$d3)."'
                    WHERE account_number = '".mysqli_real_escape_string($link,$d2)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  /*public function recordDepositCheck($checknumber,$bankacct,$checkdate, $amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO company_checks(check_no,bank_account_id,check_date,amount)
                    VALUES('".mysqli_real_escape_string($link,$checknumber)."',
                          '".mysqli_real_escape_string($link,$bankacct)."',
                          '".mysqli_real_escape_string($link,date_format($checkdate,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$amount)."')");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }*/

  public function addCompanyCheck($check_no,$bank_account_id,$check_date,$amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO company_checks(check_no,bank_account_id,check_date,amount)
                    VALUES('".mysqli_real_escape_string($link,$check_no)."',
                          '".mysqli_real_escape_string($link,$bank_account_id)."',
                          '".mysqli_real_escape_string($link,$check_date)."',
                          '".mysqli_real_escape_string($link,$amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editCompanyCheck($cc_id,$check_no,$bank_account_id,$check_date,$amount){
    $link = $this->connect();
    $query=sprintf("UPDATE company_checks
                    SET check_no = '".mysqli_real_escape_string($link,$check_no)."',
                    bank_account_id = '".mysqli_real_escape_string($link,$bank_account_id)."',
                    check_date = '".mysqli_real_escape_string($link,$check_date)."',
                    amount = '".mysqli_real_escape_string($link,$amount)."'
                    WHERE cc_id = '".mysqli_real_escape_string($link,$cc_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addCustomerCheck($check_no,$bank_id,$check_date,$amount,$status){
    $link = $this->connect();
    $query=sprintf("INSERT INTO customer_checks(check_no,bank_id,check_date,amount,status)
                    VALUES('".mysqli_real_escape_string($link,$check_no)."',
                          '".mysqli_real_escape_string($link,$bank_id)."',
                          '".mysqli_real_escape_string($link,date_format($check_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$amount)."',
                          '".mysqli_real_escape_string($link,$status)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editCustomerCheck($cc_id,$check_no,$bank_account_id,$check_date,$amount,$status){
    $link = $this->connect();
    $query=sprintf("UPDATE customer_checks
                    SET check_no = '".mysqli_real_escape_string($link,$check_no)."',
                    bank_id = '".mysqli_real_escape_string($link,$bank_id)."',
                    check_date = '".mysqli_real_escape_string($link,$check_date)."',
                    amount = '".mysqli_real_escape_string($link,$amount)."',
                    status = '".mysqli_real_escape_string($link,$status)."'
                    WHERE cc_id = '".mysqli_real_escape_string($link,$cc_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addEmployee($first_name,$last_name,$salary,$type,$position,$date_hired,$status,$remarks,$record_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO employees(first_name,last_name,salary,type,position,date_hired,status,remarks,record_id)
                    VALUES('".mysqli_real_escape_string($link,$first_name)."',
                          '".mysqli_real_escape_string($link,$last_name)."',
                          '".mysqli_real_escape_string($link,$salary)."',
                          '".mysqli_real_escape_string($link,$type)."',
                          '".mysqli_real_escape_string($link,$position)."',
                          '".mysqli_real_escape_string($link,$date_hired)."',
                          '".mysqli_real_escape_string($link,$status)."',
                          '".mysqli_real_escape_string($link,$remarks)."',
                          '".mysqli_real_escape_string($link,$record_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editEmployee($employee_id,$first_name,$last_name,$salary,$type,$position,$date_hired,$status,$remarks,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE employees
                    SET first_name = '".mysqli_real_escape_string($link,$first_name)."',
                    last_name = '".mysqli_real_escape_string($link,$last_name)."',
                    salary = '".mysqli_real_escape_string($link,$salary)."',
                    type = '".mysqli_real_escape_string($link,$type)."',
                    position = '".mysqli_real_escape_string($link,$position)."',
                    date_hired = '".mysqli_real_escape_string($link,$date_hired)."',
                    status = '".mysqli_real_escape_string($link,$status)."',
                    remarks = '".mysqli_real_escape_string($link,$remarks)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE employee_id = '".mysqli_real_escape_string($link,$employee_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addExpense($expense_date,$payee,$payee_address,$account_title_id,$amount,$payment_method,$amount_paid,$due_date,$cc_id,$record_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO expenses(expense_date,payee,payee_address,account_title_id,amount,payment_method,amount_paid,due_date,cc_id,record_id)
                    VALUES('".mysqli_real_escape_string($link,date_format($expense_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$payee)."',
                          '".mysqli_real_escape_string($link,$payee_address)."',
                          '".mysqli_real_escape_string($link,$account_title_id)."',
                          '".mysqli_real_escape_string($link,$amount)."',
                          '".mysqli_real_escape_string($link,$payment_method)."',
                          '".mysqli_real_escape_string($link,$amount_paid)."',
                          '".mysqli_real_escape_string($link,date_format($due_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$cc_id)."',
                          '".mysqli_real_escape_string($link,$record_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editExpense($expense_id,$expense_date,$payee,$payee_address,$account_title_id,$amount,$payment_method,$amount_paid,$due_date,$cc_id,$status,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE expenses
                    SET expense_date = '".mysqli_real_escape_string($link,$expense_date)."',
                    payee = '".mysqli_real_escape_string($link,$payee)."',
                    payee_address = '".mysqli_real_escape_string($link,$payee_address)."',
                    account_title_id = '".mysqli_real_escape_string($link,$account_title_id)."',
                    amount = '".mysqli_real_escape_string($link,$amount)."',
                    payment_method = '".mysqli_real_escape_string($link,$payment_method)."',
                    amount_paid = '".mysqli_real_escape_string($link,$amount_paid)."',
                    due_date = '".mysqli_real_escape_string($link,$due_date)."',
                    status = '".mysqli_real_escape_string($link,$status)."',
                    cc_id = '".mysqli_real_escape_string($link,$cc_id)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE expense_id = '".mysqli_real_escape_string($link,$expense_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addInventory($item_id,$quantity,$cost,$trans_date,$record_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO inventory(item_id,quantity,cost,trans_date,record_id)
                    VALUES('".mysqli_real_escape_string($link,$item_id)."',
                          '".mysqli_real_escape_string($link,$quantity)."',
                          '".mysqli_real_escape_string($link,$cost)."',
                          '".mysqli_real_escape_string($link,date_format($trans_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$record_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editInventory($inv_id,$item_id,$quantity,$cost,$trans_date,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE inventory
                    SET item_id = '".mysqli_real_escape_string($link,$item_id)."',
                    quantity = '".mysqli_real_escape_string($link,$quantity)."',
                    cost = '".mysqli_real_escape_string($link,$cost)."',
                    trans_date = '".mysqli_real_escape_string($link,$trans_date)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE inv_id = '".mysqli_real_escape_string($link,$inv_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addItem($item_description,$cost,$record_srp,$display_srp,$supplier_id,$record_id){
    $link = $this->connect();
    $query=sprintf("INSERT INTO items(item_description,cost,record_srp,display_srp,supplier_id,record_id)
                    VALUES('".mysqli_real_escape_string($link,$item_description)."',
                          '".mysqli_real_escape_string($link,$cost)."',
                          '".mysqli_real_escape_string($link,$record_srp)."',
                          '".mysqli_real_escape_string($link,$display_srp)."',
                          '".mysqli_real_escape_string($link,$supplier_id)."',
                          '".mysqli_real_escape_string($link,$record_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editItem($inv_id,$item_id,$cost,$trans_date,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE items
                    SET item_description = '".mysqli_real_escape_string($link,$item_description)."',
                    cost = '".mysqli_real_escape_string($link,$cost)."',
                    record_srp = '".mysqli_real_escape_string($link,$record_srp)."',
                    display_srp = '".mysqli_real_escape_string($link,$display_srp)."',
                    supplier_id = '".mysqli_real_escape_string($link,$supplier_id)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE item_id = '".mysqli_real_escape_string($link,$item_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addPosition($position_name){
    $link = $this->connect();
    $query=sprintf("INSERT INTO positions(position_name)
                    VALUES('".mysqli_real_escape_string($link,$position_name)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editPosition($position_id,$position_name){
    $link = $this->connect();
    $query=sprintf("UPDATE positions
                    SET position_name = '".mysqli_real_escape_string($link,$position_name)."'
                    WHERE position_id = '".mysqli_real_escape_string($link,$position_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addPurchaseOrder($po_id,$po_date,$total_amount,$due_date,$status,$record_id,$discount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO purchase_orders(po_id,supplier_id,po_date,total_amount,amount_paid,due_date,status,record_id,discount)
                    VALUES('".mysqli_real_escape_string($link,$po_id)."',
													'".mysqli_real_escape_string($link,"1")."',
                          '".mysqli_real_escape_string($link,date_format($po_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$total_amount)."',
                          '".mysqli_real_escape_string($link,"0")."',
                          '".mysqli_real_escape_string($link,date_format($due_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$status)."',
                          '".mysqli_real_escape_string($link,$record_id)."',
                          '".mysqli_real_escape_string($link,$discount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return $po_id;

  }

  public function editPurchaseOrder($po_id,$supplier_id,$po_date,$total_amount,$amount_paid,$terms,$due_date,$payment_method,$status,$cc_id,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE purchase_orders
                    SET supplier_id = '".mysqli_real_escape_string($link,$supplier_id)."',
                    po_date = '".mysqli_real_escape_string($link,$po_date)."',
                    total_amount = '".mysqli_real_escape_string($link,$total_amount)."',
                    amount_paid = '".mysqli_real_escape_string($link,$amount_paid)."',
                    terms = '".mysqli_real_escape_string($link,$terms)."',
                    due_date = '".mysqli_real_escape_string($link,$due_date)."',
                    payment_method = '".mysqli_real_escape_string($link,$payment_method)."',
                    status = '".mysqli_real_escape_string($link,$status)."',
                    cc_id = '".mysqli_real_escape_string($link,$cc_id)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE po_id = '".mysqli_real_escape_string($link,$po_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

	public function addPayment($payment_method,$amount,$payment_date,$cc_id){
		$link = $this->connect();
    $query=sprintf("INSERT INTO payments(payment_method,amount,payment_date,cc_id)
                    VALUES('".mysqli_real_escape_string($link,$payment_method)."',
													'".mysqli_real_escape_string($link,$amount)."',
                          '".mysqli_real_escape_string($link,date_format($payment_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$cc_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }
	}

	public function addCollection($payment_method,$amount,$payment_date,$cc_id){
		$link = $this->connect();
    $query=sprintf("INSERT INTO payments(payment_method,amount,payment_date,cc_id)
                    VALUES('".mysqli_real_escape_string($link,$payment_method)."',
													'".mysqli_real_escape_string($link,$amount)."',
                          '".mysqli_real_escape_string($link,date_format($payment_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$cc_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }
	}

	public function recordPOPayment($po_id,$amount_paid,$payment_method,$cc_id){
		$link = $this->connect();
		$po = $this->getPurchaseOrderById($po_id);
		if($po[0]['total_amount']*1 == ($po[0]['amount_paid']+$amount_paid)){
			$status = 3;
		}else if($po[0]['total_amount']*1 > ($po[0]['amount_paid']+$amount_paid)){
			$status = 2;
		}else{
			$status = 1;
		}
		if($cc_id==-1){
			$query=sprintf("UPDATE purchase_orders
	                    SET amount_paid = '".mysqli_real_escape_string($link,$po[0]['amount_paid']+$amount_paid)."',
	                    payment_method = '".mysqli_real_escape_string($link,$payment_method)."',
	                    status = '".mysqli_real_escape_string($link,$status)."'
	                    WHERE po_id = '".mysqli_real_escape_string($link,$po_id)."'");
		}else{

			$query=sprintf("UPDATE purchase_orders
	                    SET amount_paid = '".mysqli_real_escape_string($link,$po[0]['amount_paid']+$amount_paid)."',
	                    payment_method = '".mysqli_real_escape_string($link,$payment_method)."',
	                    status = '".mysqli_real_escape_string($link,$status)."',
	                    cc_id = '".mysqli_real_escape_string($link,$cc_id)."'
	                    WHERE po_id = '".mysqli_real_escape_string($link,$po_id)."'");
		}

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
	}


	public function recordSaleCollection($sale_id,$amount_paid,$payment_method,$cc_id){
		$link = $this->connect();
		$po = $this->getSaleById($sale_id);
		if($po[0]['total_amount']*1 == ($po[0]['amount_paid']+$amount_paid)){
			$status = 8;
		}else if($po[0]['total_amount']*1 > ($po[0]['amount_paid']+$amount_paid)){
			$status = 9;
		}else{
			$status = 7;
		}
		if($cc_id==-1){
			$query=sprintf("UPDATE sales
	                    SET amount_paid = '".mysqli_real_escape_string($link,$po[0]['amount_paid']+$amount_paid)."',
	                    payment_method = '".mysqli_real_escape_string($link,$payment_method)."',
	                    status = '".mysqli_real_escape_string($link,$status)."'
	                    WHERE sale_id = '".mysqli_real_escape_string($link,$sale_id)."'");
		}else{

			$query=sprintf("UPDATE sales
	                    SET amount_paid = '".mysqli_real_escape_string($link,$po[0]['amount_paid']+$amount_paid)."',
	                    payment_method = '".mysqli_real_escape_string($link,$payment_method)."',
	                    status = '".mysqli_real_escape_string($link,$status)."',
	                    cc_id = '".mysqli_real_escape_string($link,$cc_id)."'
	                    WHERE sale_id = '".mysqli_real_escape_string($link,$sale_id)."'");
		}

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
	}

  public function addExpenseItem($expense_id,$particulars,$amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO expense_items(expense_id,particulars,amount)
                    VALUES('".mysqli_real_escape_string($link,$expense_id)."',
                          '".mysqli_real_escape_string($link,$particulars)."',
                          '".mysqli_real_escape_string($link,$amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function addPOItem($po_id,$item_id,$quantity,$cost){
    $link = $this->connect();
    $query=sprintf("INSERT INTO purchase_order_items(po_id,item_id,quantity,cost)
                    VALUES('".mysqli_real_escape_string($link,$po_id)."',
                          '".mysqli_real_escape_string($link,$item_id)."',
                          '".mysqli_real_escape_string($link,$quantity)."',
                          '".mysqli_real_escape_string($link,$cost)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editPOItem($po_item_id,$po_id,$item_id,$quantity,$cost){
    $link = $this->connect();
    $query=sprintf("UPDATE po_items
                    SET po_id = '".mysqli_real_escape_string($link,$po_id)."',
                    item_id = '".mysqli_real_escape_string($link,$item_id)."',
                    quantity = '".mysqli_real_escape_string($link,$quantity)."',
                    cost = '".mysqli_real_escape_string($link,$cost)."'
                    WHERE po_item_id = '".mysqli_real_escape_string($link,$po_item_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addReturn($customer_id,$return_date,$total_amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO returns(return_date,customer_id,total_amount)
                    VALUES('".mysqli_real_escape_string($link,date_format($return_date,"Y-m-d"))."',
													'".mysqli_real_escape_string($link,$customer_id)."',
                          '".mysqli_real_escape_string($link,$total_amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }
	public function addReturnItem($return_id,$item_id,$quantity,$amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO return_items(return_id,item_id,quantity,cost)
                    VALUES('".mysqli_real_escape_string($link,$return_id)."',
                          '".mysqli_real_escape_string($link,$item_id)."',
                          '".mysqli_real_escape_string($link,$quantity)."',
                          '".mysqli_real_escape_string($link,$amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function updateInventory($return_id,$item_id,$quantity,$amount){
    $link = $this->connect();

    $query=sprintf("UPDATE inventory
                    SET quantity = quantity - '".mysqli_real_escape_string($link,$quantity)."'
                    WHERE item_id = '".mysqli_real_escape_string($link,$item_id)."'
                    and quantity > 0");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function addSale($customer_id,$sale_date,$total_amount,$record_id,$discount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO sales(customer_id,sale_date,total_amount,due_date,record_id,discount)
                    VALUES('".mysqli_real_escape_string($link,$customer_id)."',
                          '".mysqli_real_escape_string($link,date_format($sale_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$total_amount)."',
                          '".mysqli_real_escape_string($link,date_format($sale_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$record_id)."',
                          '".mysqli_real_escape_string($link,$discount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editSale($sales_id,$customer_id,$sale_date,$total_amount,$amount_paid,$terms,$status,$payment_method,$due_date,$cc_id,$record_id){
    $link = $this->connect();
    $query=sprintf("UPDATE sales
                    SET customer_id = '".mysqli_real_escape_string($link,$customer_id)."',
                    sale_date = '".mysqli_real_escape_string($link,$sale_date)."',
                    total_amount = '".mysqli_real_escape_string($link,$total_amount)."',
                    amount_paid = '".mysqli_real_escape_string($link,$amount_paid)."',
                    terms = '".mysqli_real_escape_string($link,$terms)."',
                    status = '".mysqli_real_escape_string($link,$status)."',
                    payment_method = '".mysqli_real_escape_string($link,$payment_method)."',
                    due_date = '".mysqli_real_escape_string($link,$due_date)."',
                    cc_id = '".mysqli_real_escape_string($link,$cc_id)."',
                    record_id = '".mysqli_real_escape_string($link,$record_id)."'
                    WHERE sale_id = '".mysqli_real_escape_string($link,$sale_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addSaleItem($sale_id,$item_id,$quantity,$amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO sale_items(sale_id,item_id,quantity,amount)
                    VALUES('".mysqli_real_escape_string($link,$sale_id)."',
                          '".mysqli_real_escape_string($link,$item_id)."',
                          '".mysqli_real_escape_string($link,$quantity)."',
                          '".mysqli_real_escape_string($link,$amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editSaleItem($si_id,$sale_id,$item_id,$quantity,$amount){
    $link = $this->connect();
    $query=sprintf("UPDATE sale_items
                    SET sale_id = '".mysqli_real_escape_string($link,$sale_id)."',
                    item_id = '".mysqli_real_escape_string($link,$item_id)."',
                    quantity = '".mysqli_real_escape_string($link,$quantity)."',
                    amount = '".mysqli_real_escape_string($link,$amount)."'
                    WHERE si_id = '".mysqli_real_escape_string($link,$si_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function addStatus($status_name){
    $link = $this->connect();
    $query=sprintf("INSERT INTO status(status_name)
                    VALUES('".mysqli_real_escape_string($link,$status_name)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function editStatus($status_code,$status_name){
    $link = $this->connect();
    $query=sprintf("UPDATE status
                    SET status_name = '".mysqli_real_escape_string($link,$status_name)."'
                    WHERE status_code = '".mysqli_real_escape_string($link,$status_code)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;
  }

  public function getBankList(){
    $link = $this->connect();
    $query = "SELECT bank_id,
                      bank_name
              FROM banklist
              ORDER BY bank_name";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getBankById($bank_id){
    $link = $this->connect();
    $query = "SELECT bank_id,
                      bank_name
              FROM banklist
              WHERE bank_id = '".mysqli_real_escape_string($link,$bank_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getAccountTitleList(){
    $link = $this->connect();
    $query = "SELECT account_title_id,
                      account_name,
                      segment
              FROM account_titles
              ORDER BY account_name";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getPayables($supplier_id){
		$link = $this->connect();
    $query = "SELECT sum(total_amount-amount_paid) as 'payables'
              FROM purchase_orders
              WHERE supplier_id='".$supplier_id."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
	}

	public function getReceivables($customer_id){
		$link = $this->connect();
    $query = "SELECT sum(total_amount-amount_paid) as 'receivables'
              FROM sales
              WHERE customer_id='".$customer_id."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
	}

  public function getAccountTitleById($account_title_id){
    $link = $this->connect();
    $query = "SELECT account_title_id,
                      account_name,
                      segment
              FROM account_titles
              WHERE account_title_id = '".mysqli_real_escape_string($link,$account_title_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getAreaList(){
    $link = $this->connect();
    $query = "SELECT area_id,
                      area_name
              FROM areas
              ORDER BY area_name";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getAreaById($area_id){
    $link = $this->connect();
    $query = "SELECT area_id,
                      area_name
              FROM areas
              WHERE area_id = '".mysqli_real_escape_string($link,$area_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getBankAccountList(){
    $link = $this->connect();
    $query = "SELECT ba.account_number,
                      b.bank_id,
                      ba.branch,
                      ba.initial_balance,
                      ba.current_balance
              FROM bank_accounts ba
              INNER JOIN banklist b
              ON b.bank_id = ba.bank_id
              ORDER BY b.bank_name";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getBankAccountById($account_number){
    $link = $this->connect();
    $query = "SELECT ba.account_number,
                      b.bank_id,
                      ba.branch,
                      ba.initial_balance,
                      ba.current_balance
              FROM bank_accounts ba
              INNER JOIN banklist b
              WHERE account_number = '".mysqli_real_escape_string($link,$account_number)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getInventoryReportQuantity($d1, $d2){
    $link = $this->connect();
    $query = "SELECT quantity,
                    item_id,
                    cost,
                    trans_date
            FROM inventory
            WHERE trans_date BETWEEN '".$d1."' AND '".$d2."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
   while($row =mysqli_fetch_assoc($result))
    {
       $data[] = $row;
    }
    return $data;
  }

  public function getInventoryReportItems(){
    $link = $this->connect();
    $query = "SELECT item_description,
                    item_id,
                    cost
            FROM items";
    $result = mysqli_query ( $link, $query );
    $data = array();
   while($row =mysqli_fetch_assoc($result))
    {
       $data[] = $row;
    }
    return $data;
  }

  public function getIncomeStatementSales($d1, $d2){
      $link = $this->connect();
      $query = "SELECT total_amount,
                      discount,
                      sale_id
              FROM sales
              WHERE sale_date BETWEEN '".$d1."' AND '".$d2."'";
      $result = mysqli_query ( $link, $query );
      $data = array();
     while($row =mysqli_fetch_assoc($result))
      {
         $data[] = $row;
      }
      return $data;
  }

  public function getIncomeStatementSaleItem($sale_id){
      $link = $this->connect();
      $query = "SELECT sale_id,
                      item_id AS itemid
              FROM sale_items
               WHERE sale_id = '".$sale_id."'";
      $result = mysqli_query ( $link, $query );
      $row =mysqli_fetch_assoc($result);

      return $row['itemid'];
  }

  public function getIncomeStatementItems($item_id){
      $link = $this->connect();
      $query = "SELECT item_id,
                      cost AS cost
              FROM items
              WHERE item_id = '".$item_id."'";
      $result = mysqli_query ( $link, $query );
      $row =mysqli_fetch_assoc($result);

      return $row['cost'];
  }

  public function getIncomeStatementExpenses(){
      $link = $this->connect();
      $query = "SELECT SUM(amount) AS total_amount
              FROM expense_items";
      $result = mysqli_query ( $link, $query );
      $row =mysqli_fetch_assoc($result);

      return $row['total_amount'];
  }


  public function getCashflowList(){
    $link = $this->connect();
    $query = "SELECT sum(amount) as amount,
                      cf_date,
                      category
              FROM cashflow
							GROUP BY category,cf_date
              ORDER BY cf_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getCashflowListWithRange($d1,$d2){
    $link = $this->connect();
    $query = "SELECT cf_id,
                      amount,
                      particulars,
                      cf_date,
                      category,
                      record_id
              FROM cashflow
							WHERE cf_date BETWEEN '".$d1."' AND '".$d2."'
              ORDER BY particulars";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
	public function getCashflowListByDate($d1){
    $link = $this->connect();
    $query = "SELECT cf_id,
                      amount,
                      particulars,
                      cf_date,
                      category,
                      record_id
              FROM cashflow
							WHERE cf_date = '".$d1."'
              ORDER BY particulars";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getCashflowById($cf_id){
    $link = $this->connect();
    $query = "SELECT cf_id,
                      amount,
                      particulars,
                      cf_date,
                      category,
                      record_id
              FROM cashflow
              WHERE cf_id = '".mysqli_real_escape_string($link,$cf_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getCompanyCheckList(){
    $link = $this->connect();
    $query = "SELECT cc_id,
                      check_no,
                      bank_account_id,
                      check_date,
                      amount
              FROM company_checks
              ORDER BY check_no";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getCompanyCheckById($cc_id){
    $link = $this->connect();
    $query = "SELECT cc_id,
                      check_no,
                      bank_account_id,
                      check_date,
                      amount
              FROM company_checks
              WHERE cc_id = '".mysqli_real_escape_string($link,$cc_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getCustomerList(){
    $link = $this->connect();
    $query = "SELECT c.customer_id,
                    c.customer_name,
                    c.address,
                    c.contact_no,
										a.area_name,
                    c.record_id
              FROM  customers c
							INNER JOIN areas a
							ON a.area_id = c.area_id
              ORDER BY customer_name";
    $result = mysqli_query ( $link, $query );
		$data= array();
    while($row =mysqli_fetch_assoc($result))
    {
			$arr = array(
        "customer_id" => $row['customer_id'],
        "customer_name"=> $row['customer_name'],
        "address"=>  $row['address'],
        "contact_no"=>  $row['contact_no'],
        "area_name"=>  $row['area_name'],
        "record_id"=>  $row['record_id'],
        "receivables"=>  $this->getReceivables($row['customer_id'])
      );
			array_push($data,$arr);
    }
    return $data;
  }

  public function ddlCustomers(){
    $link = $this->connect();
    $query = "SELECT customer_id,
                    customer_name
              FROM  customers
              ORDER BY customer_name";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['customer_id']."'>".$row['customer_name']."</option>";
    }
  }
  public function ddlAccountTitles(){
    $link = $this->connect();
    $query = "SELECT account_title_id,
                    account_name
              FROM  account_titles
              ORDER BY account_name";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['account_title_id']."'>".$row['account_name']."</option>";
    }
  }
  public function getCustomerById($customer_id){
    $link = $this->connect();
    $query = "SELECT customer_id,
                      customer_name,
                      address,
                      contact_no,
                      area_id,
                      record_id
              FROM customers
              WHERE customer_id = '".mysqli_real_escape_string($link,$customer_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getCustomerCheckList(){
    $link = $this->connect();
    $query = "SELECT c.cc_id,
                      c.check_no,
                      c.bank_account_id,
                      c.check_date,
                      c.amount,
                      s.status_name
              FROM customer_checks c
              INNER JOIN status s
              ON s.status_code = c.status
              ORDER BY check_no";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getCustomerCheckById($cc_id){
    $link = $this->connect();
    $query = "SELECT c.cc_id,
                      c.check_no,
                      c.bank_account_id,
                      c.check_date,
                      c.amount,
                      s.status_name
              FROM customer_checks c
              INNER JOIN status s
              ON s.status_code = c.status
              WHERE cc_id = '".mysqli_real_escape_string($link,$cc_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getEmployeeList(){
    $link = $this->connect();
    $query = "SELECT e.employee_id,
                      e.first_name,
                      e.last_name,
                      e.salary,
                      e.type,
                      p.position_name,
                      e.date_hired,
                      e.date_terminated,
                      s.status_name,
                      e.remarks,
                      e.record_id
              FROM employees e
              INNER JOIN positions p
              ON p.position_id = e.position
              INNER JOIN status s
              ON s.status_code = e.status
              ORDER BY first_name";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getEmployeeById($employee_id){
    $link = $this->connect();
    $query = "SELECT e.employee_id,
                      e.first_name,
                      e.last_name,
                      e.salary,
                      e.type,
                      p.position_name,
                      e.date_hired,
                      e.date_terminated,
                      s.status_name,
                      e.remarks,
                      e.record_id
              FROM employees e
              INNER JOIN positions p
              ON p.position_id = e.position
              INNER JOIN status s
              ON s.status_code = e.status
              WHERE employee_id = '".mysqli_real_escape_string($link,$employee_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getExpenseList(){
    $link = $this->connect();
    $query = "SELECT e.expense_id,
                    e.expense_date,
                    e.payee,
                    e.payee_address,
                    a.account_name,
                    e.amount,
                    e.payment_method,
                    e.amount_paid,
                    e.due_date,
                    e.cc_id,
                    e.record_id
              FROM expenses e
              INNER JOIN account_titles a
              ON a.account_title_id = e.account_title_id
              ORDER BY e.expense_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getExpenseById($expense_id){
    $link = $this->connect();
    $query = "SELECT e.expense_id,
                    e.expense_date,
                    e.payee,
                    e.payee_address,
                    a.account_name,
                    e.amount,
                    e.payment_method,
                    e.amount_paid,
                    e.due_date,
                    e.cc_id,
                    e.record_id
              FROM expenses e
              INNER JOIN account_titles a
              ON a.account_title_id = e.account_title_id
              WHERE e.expense_id = '".mysqli_real_escape_string($link,$expense_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getInventory(){
		$link = $this->connect();
    $query = "SELECT i.inv_id,
											i.item_id,
											it.item_description,
											it.display_srp,
											sum(i.quantity) as 'quantity',
											s.supplier_name,
											it.supplier_id,
											i.trans_date
              FROM  items it
							LEFT JOIN inventory i
							ON i.item_id = it.item_id
							INNER JOIN suppliers s
							ON s.supplier_id = it.supplier_id
							GROUP BY it.item_id
              ORDER BY item_description";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
	}

	public function getInventoryRange($d1,$d2){
		$link = $this->connect();
    $query = "SELECT i.inv_id,
											i.item_id,
											it.item_description,
											it.display_srp,
											sum(i.quantity) as 'quantity',
											s.supplier_name,
											i.trans_date
              FROM  inventory i
							INNER JOIN items it
							ON it.item_id = i.item_id
							INNER JOIN suppliers s
							ON s.supplier_id = it.supplier_id
							WHERE i.trans_date BETWEEN '".$d1."' AND '".$d2."'
							GROUP BY i.item_id
              ORDER BY item_description";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
	}

  public function getItemList(){
    $link = $this->connect();
    $query = "SELECT item_id,
                    item_description,
                    cost,
                    record_srp,
                    display_srp,
                    supplier_id,
                    record_id
              FROM  items
              ORDER BY item_description";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getItemById($item_id){
    $link = $this->connect();
    $query = "SELECT item_id,
                    item_description,
                    cost,
                    record_srp,
                    display_srp,
                    supplier_id,
                    record_id
              FROM  items
              WHERE item_id = '".mysqli_real_escape_string($link,$item_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getItemBySupplier($supplier_id){
    $link = $this->connect();
    $query = "SELECT item_id,
                    item_description,
                    cost,
                    record_srp,
                    display_srp,
                    supplier_id,
                    record_id
              FROM  items
              WHERE supplier_id = '".mysqli_real_escape_string($link,$supplier_id)."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getPositionList(){
    $link = $this->connect();
    $query = "SELECT position_id,
                    position_name
              FROM  positions
              ORDER BY item_description";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getPositionById($position_id){
    $link = $this->connect();
    $query = "SELECT position_id,
                    position_name
              FROM  positions
              WHERE position_id = '".mysqli_real_escape_string($link,$position_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getPurchaseOrderList(){
    $link = $this->connect();
    $query = "SELECT p.po_id,
                    s.supplier_name,
                    p.po_date,
                    p.total_amount,
                    p.amount_paid,
                    p.terms,
                    p.due_date,
                    p.payment_method,
                    stat.status_name,
                    p.cc_id,
                    p.record_id
              FROM  purchase_orders p
              INNER JOIN suppliers s
              ON s.supplier_id = p.supplier_id
              INNER JOIN status stat
              ON stat.status_code = p.status
              ORDER BY po_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getPurchaseOrderListRange($d1,$d2){
    $link = $this->connect();
    $query = "SELECT p.po_id,
                    s.supplier_name,
                    p.po_date,
                    p.total_amount,
                    p.amount_paid,
                    p.terms,
                    p.due_date,
                    p.payment_method,
                    stat.status_name,
                    p.cc_id,
                    p.record_id
              FROM  purchase_orders p
              INNER JOIN suppliers s
              ON s.supplier_id = p.supplier_id
              INNER JOIN status stat
              ON stat.status_code = p.status
							WHERE p.po_date BETWEEN '".$d1."' AND '".$d2."'
              ORDER BY po_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getPurchaseOrderById($po_id){
    $link = $this->connect();
    $query = "SELECT p.po_id,
                    s.supplier_name,
                    p.po_date,
                    p.total_amount,
                    p.amount_paid,
                    p.terms,
                    p.due_date,
                    p.payment_method,
                    stat.status_name,
                    p.cc_id,
                    p.record_id
              FROM  purchase_orders p
              INNER JOIN suppliers s
              ON s.supplier_id = p.supplier_id
              INNER JOIN status stat
              ON stat.status_code = p.status
              WHERE p.po_id = '".mysqli_real_escape_string($link,$po_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getPOItems($po_id){
    $link = $this->connect();
    $query = "SELECT p.po_id,
                    i.item_description,
                    p.quantity,
                    p.cost
              FROM  purchase_order_items p
              INNER JOIN items i
              ON i.item_id = p.item_id
              WHERE p.po_id = '".mysqli_real_escape_string($link,$po_id)."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getReturnList(){
    $link = $this->connect();
    $query = "SELECT r.return_id,
                    c.customer_name,
										a.area_name,
                    r.return_date,
                    r.total_amount
              FROM  returns r
              INNER JOIN customers c
              ON c.customer_id = r.customer_id
							INNER JOIN areas a
							ON a.area_id = c.area_id
              ORDER BY r.return_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
	public function getSaleList(){
    $link = $this->connect();
    $query = "SELECT s.sale_id,
                    c.customer_name,
										a.area_name,
                    s.sale_date,
                    s.total_amount,
                    s.amount_paid,
                    s.terms,
                    stat.status_name,
                    s.payment_method,
                    s.due_date,
                    s.cc_id,
                    s.record_id,
										s.discount
              FROM  sales s
              INNER JOIN customers c
              ON c.customer_id = s.customer_id
							INNER JOIN areas a
							ON a.area_id = c.area_id
              INNER JOIN status stat
              ON stat.status_code = s.status
              ORDER BY sale_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getReturnById($return_id){
    $link = $this->connect();
    $query = "SELECT s.return_id,
                    c.customer_name,
                    s.return_date,
                    s.total_amount
              FROM  returns s
              INNER JOIN customers c
              ON c.customer_id = s.customer_id
              WHERE s.return_id = '".mysqli_real_escape_string($link,$return_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getSaleById($si_id){
    $link = $this->connect();
    $query = "SELECT s.sale_id,
                    c.customer_name,
                    s.sale_date,
                    s.total_amount,
                    s.amount_paid,
                    s.terms,
                    stat.status_name,
                    s.payment_method,
                    s.due_date,
                    s.cc_id,
                    s.record_id
              FROM  sales s
              INNER JOIN customers c
              ON c.customer_id = s.customer_id
              INNER JOIN status stat
              ON stat.status_code =s.status
              WHERE s.sale_id = '".mysqli_real_escape_string($link,$si_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getSaleItems($sale_id){
    $link = $this->connect();
    $query = "SELECT p.si_id,
                    i.item_description,
                    p.quantity,
                    p.amount
              FROM  sale_items p
              INNER JOIN items i
              ON i.item_id = p.item_id
              WHERE p.sale_id = '".mysqli_real_escape_string($link,$sale_id)."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getExpenseItems($expense_id){
    $link = $this->connect();
    $query = "SELECT particulars,
										amount
              FROM  expense_items
              WHERE expense_id = '".mysqli_real_escape_string($link,$expense_id)."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
	public function getReturnItems($return_id){
    $link = $this->connect();
    $query = "SELECT p.ri_id,
                    i.item_description,
                    p.quantity,
                    p.cost
              FROM  return_items p
              INNER JOIN items i
              ON i.item_id = p.item_id
              WHERE p.return_id = '".mysqli_real_escape_string($link,$return_id)."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getStatusList(){
    $link = $this->connect();
    $query = "SELECT status_code,
                    status_name
              FROM  status
              ORDER BY status_name";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getStatusById($status_code){
    $link = $this->connect();
    $query = "SELECT status_code,
                    status_name
              FROM  status
              WHERE status_code = '".mysqli_real_escape_string($link,$status_code)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getSupplierList(){
    $link = $this->connect();
    $query = "SELECT supplier_id,
                    supplier_name,
                    address,
                    contact_number,
                    record_id
              FROM  suppliers
              ORDER BY supplier_name";
    $result = mysqli_query ( $link, $query );
		$data= array();
    while($row =mysqli_fetch_assoc($result))
    {
			$arr = array(
        "supplier_id" => $row['supplier_id'],
        "supplier_name"=> $row['supplier_name'],
        "address"=>  $row['address'],
        "contact_number"=>  $row['contact_number'],
        "record_id"=>  $row['record_id'],
        "payables"=>  $this->getPayables($row['supplier_id'])
      );
			array_push($data,$arr);
    }
    return $data;
  }


	public function ddlBanks(){
    $link = $this->connect();
    $query = "SELECT bank_id,
                    bank_name
              FROM  banklist
              ORDER BY bank_name";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['bank_id']."'>".$row['bank_name']."</option>";
    }
  }
	public function ddlSuppliers(){
    $link = $this->connect();
    $query = "SELECT supplier_id,
                    supplier_name
              FROM  suppliers
              ORDER BY supplier_name";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['supplier_id']."'>".$row['supplier_name']."</option>";
    }
  }

  public function ddlAllItems(){
    $link = $this->connect();
    $query = "SELECT item_id,
                    item_description
              FROM  items
              ORDER BY item_description";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['item_id']."'>".$row['item_description']."</option>";
    }
  }

  public function ddlArea(){
    $link = $this->connect();
    $query = "SELECT area_id,
                    area_name
              FROM  areas
              ORDER BY area_name";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['area_id']."'>".$row['area_name']."</option>";
    }
  }

  public function getSupplierById($supplier_id){
    $link = $this->connect();
    $query = "SELECT supplier_id,
                    supplier_name,
                    address,
                    contact_number,
                    record_id
              FROM  suppliers
              WHERE supplier_id = '".mysqli_real_escape_string($link,$supplier_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getUserList(){
    $link = $this->connect();
    $query = "SELECT user_id,
                    username,
                    last_login,
                    access_level
              FROM  users
              ORDER BY username";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getUserById($user_id){
    $link = $this->connect();
    $query = "SELECT user_id,
                    username,
                    last_login,
                    access_level
              FROM  users
              WHERE user_id = '".mysqli_real_escape_string($link,$user_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

	public function getMax($table){
		$link = $this->connect();
    $query = "SELECT `AUTO_INCREMENT`
							FROM  INFORMATION_SCHEMA.TABLES
							WHERE TABLE_SCHEMA = '".DATABASE."'
							AND TABLE_NAME   = '".$table."';";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        return $row['AUTO_INCREMENT'];
    }
	}


	public function login($username, $password) {
		$conn = $this->connect();
    	// Using prepared statements means that SQL injection is not possible.
	    if ($stmt = $conn->prepare("SELECT user_id,username, access_level, password
	        FROM users
	       WHERE username = ?
	        LIMIT 1")) {
	        $stmt->bind_param('s', $username);  // Bind "$username" to parameter.
	        $stmt->execute();    // Execute the prepared query.
	        $stmt->store_result();

	        // get variables from result.
	        $stmt->bind_result($user_id, $username,$access_level, $db_password);
	        $stmt->fetch();


	        if ($stmt->num_rows == 1) {
                if (($password == $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
										session_start();
										session_regenerate_id(TRUE);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/","",$username);
                    $_SESSION['username'] = $username;
										$_SESSION['access_level'] = $access_level;
                    $_SESSION['login_string'] = hash('sha512',
                              $db_password . $user_browser);
                    // Login successful.
                    return $user_id;
                } else {
                    // Password is not correct
                    return false;
                }

	        } else {
	            // No user exists.
	            return false;
	        }
	    }
	}

}

class ui_functions{
	public function showHeader($active){
		print '
			<header class="main-header">
			    <!-- Logo -->
			    <a href="index2.html" class="logo">
			      <!-- mini logo for sidebar mini 50x50 pixels -->
			      <span class="logo-mini"><b>MBV</b></span>
			      <!-- logo for regular state and mobile devices -->
			      <span class="logo-lg"><b>MBV</b>aldez Distribution</span>
			    </a>
			    <!-- Header Navbar: style can be found in header.less -->
			    <nav class="navbar navbar-static-top">
			      <!-- Sidebar toggle button-->
			      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			        <span class="sr-only">Toggle navigation</span>
			      </a>

						<div class="navbar-custom-menu">
		          <ul class="nav navbar-nav">
		            <!-- User Account: style can be found in dropdown.less -->
		            <li class="dropdown user user-menu">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		                <img src="../assets/AdminLTE/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
		                <span class="hidden-xs">'.$_SESSION['username'].'</span>
		              </a>
		              <ul class="dropdown-menu">
		                <!-- User image -->
		                <li class="user-header">
		                  <img src="../assets/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

		                  <p>
		                    '.$_SESSION['username'].'
		                    <!--small>Admin | Web Developer</small-->
		                  </p>
		                </li>
		                <!-- Menu Body -->

		                <!-- Menu Footer-->
		                <li class="user-footer">
		                  <div class="pull-left">
		                    <a href="#" class="btn btn-default btn-flat">Profile</a>
		                  </div>
		                  <div class="pull-right">
		                    <a href="../gateway/logout.php" class="btn btn-default btn-flat">Sign out</a>
		                  </div>
		                </li>
		              </ul>
		            </li>
		            <!-- Control Sidebar Toggle Button -->
		            <li>
		              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gear"></i></a>
		            </li>
		          </ul>
		        </div>
			    </nav>
			  </header>
				<!-- Left side column. contains the logo and sidebar -->
		    <aside class="main-sidebar">
		      <!-- sidebar: style can be found in sidebar.less -->
		      <section class="sidebar">

		        <!-- sidebar menu: : style can be found in sidebar.less -->
		        <ul class="sidebar-menu">
		          <li class="header">MAIN NAVIGATION</li>
		          ';if($active==1) print'
		          <li class="active">';
		          else print '<li>';
		          print'
		            <a href="index.php">
		              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
		            </a>
		          </li>
		          ';if($active==2) print'
		          <li class="active">';
		          else print '<li>';
		          print'
		            <a href="inventory.php">
		              <i class="fa fa-archive"></i> <span>Inventory</span>
		            </a>
		          </li>
		          ';if($active==3) print'
							<li class="active treeview">';
		          else print '<li class="treeview">';
		          print'
			          <a href="#">
			            <i class="fa fa-shopping-cart"></i>
			            <span>Purchases</span>
			            <span class="pull-right-container">
			              <i class="fa fa-angle-left pull-right"></i>
			            </span>
			          </a>
			          <ul class="treeview-menu">
			            <li><a href="purchase_orders.php"><i class="fa fa-circle-o"></i> Purchase Orders List</a></li>
			            <li><a href="suppliers.php"><i class="fa fa-circle-o"></i> Supplier</a></li>
			          </ul>
		          </li>
		          ';if($active==4) print'
		          <li class="active treeview">';
		          else print '<li class="treeview">';
		          print'
			          <a href="#">
			            <i class="fa fa-truck"></i>
			            <span>Sales</span>
			            <span class="pull-right-container">
			              <i class="fa fa-angle-left pull-right"></i>
			            </span>
			          </a>
			          <ul class="treeview-menu">
			            <li><a href="sales.php"><i class="fa fa-circle-o"></i> Sales List</a></li>
			            <li><a href="customers.php"><i class="fa fa-circle-o"></i> Customers</a></li>
			            
			          </ul>
		          </li>
							';if($active==5) print'
							<li class="active treeview">';
		          else print '<li class="treeview">';
		          print'
								<a href="returns.php">
									<i class="fa fa-mail-reply-all"></i> <span>Returns</span>
								</a>
		          </li>
							';if($active==6) print'
							<li class="active treeview">';
		          else print '<li class="treeview">';
		          print'
								<a href="expenses.php">
									<i class="fa fa-credit-card"></i> <span>Expenses</span>
								</a>
		          </li>
							';
							if($_SESSION['access_level']>7){
							if($active==7) print'
		          <li class="active treeview">';
		          else print '<li class="treeview">';
		          print'
			          <a href="#">
			            <i class="fa fa-files-o"></i>
			            <span>Reports</span>
			            <span class="pull-right-container">
			              <i class="fa fa-angle-left pull-right"></i>
			            </span>
			          </a>
			          <ul class="treeview-menu">
			            <li><a href="cashflow.php"><i class="fa fa-circle-o"></i> Cashflow</a></li>
			            <li><a href="incomestatement.php"><i class="fa fa-circle-o"></i> Income Statement</a></li>
			            <li><a href="inventoryreport.php"><i class="fa fa-circle-o"></i> Inventory Report</a></li>
			          </ul>
		          </li>';
							}
              '';if($active==8) print'
              <li class="active">';
              else print '<li>';
              print'
                <a href="recordbankslip.php">
                  <i class="fa fa-bank"></i> <span>Record Bank Slip</span>
                </a>
              </li>
		        </ul>
		      </section>
		      <!-- /.sidebar -->
		    </aside>


			  <style>
				  .sk-folding-cube {
				  margin: 20px auto;
				  width: 40px;
				  height: 40px;
				  position: relative;
				  -webkit-transform: rotateZ(45deg);
				          transform: rotateZ(45deg);
				}

				.sk-folding-cube .sk-cube {
				  float: left;
				  width: 50%;
				  height: 50%;
				  position: relative;
				  -webkit-transform: scale(1.1);
				      -ms-transform: scale(1.1);
				          transform: scale(1.1);
				}
				.sk-folding-cube .sk-cube:before {
				  content: "";
				  position: absolute;
				  top: 0;
				  left: 0;
				  width: 100%;
				  height: 100%;
				  background-color: #333;
				  -webkit-animation: sk-foldCubeAngle 2.4s infinite linear both;
				          animation: sk-foldCubeAngle 2.4s infinite linear both;
				  -webkit-transform-origin: 100% 100%;
				      -ms-transform-origin: 100% 100%;
				          transform-origin: 100% 100%;
				          background:#00acd6;
				}
				.sk-folding-cube .sk-cube2 {
				  -webkit-transform: scale(1.1) rotateZ(90deg);
				          transform: scale(1.1) rotateZ(90deg);
				}
				.sk-folding-cube .sk-cube3 {
				  -webkit-transform: scale(1.1) rotateZ(180deg);
				          transform: scale(1.1) rotateZ(180deg);
				}
				.sk-folding-cube .sk-cube4 {
				  -webkit-transform: scale(1.1) rotateZ(270deg);
				          transform: scale(1.1) rotateZ(270deg);
				}
				.sk-folding-cube .sk-cube2:before {
				  -webkit-animation-delay: 0.3s;
				          animation-delay: 0.3s;
				}
				.sk-folding-cube .sk-cube3:before {
				  -webkit-animation-delay: 0.6s;
				          animation-delay: 0.6s;
				}
				.sk-folding-cube .sk-cube4:before {
				  -webkit-animation-delay: 0.9s;
				          animation-delay: 0.9s;
				}
				@-webkit-keyframes sk-foldCubeAngle {
				  0%, 10% {
				    -webkit-transform: perspective(140px) rotateX(-180deg);
				            transform: perspective(140px) rotateX(-180deg);
				    opacity: 0;
				  } 25%, 75% {
				    -webkit-transform: perspective(140px) rotateX(0deg);
				            transform: perspective(140px) rotateX(0deg);
				    opacity: 1;
				  } 90%, 100% {
				    -webkit-transform: perspective(140px) rotateY(180deg);
				            transform: perspective(140px) rotateY(180deg);
				    opacity: 0;
				  }
				}

				@keyframes sk-foldCubeAngle {
				  0%, 10% {
				    -webkit-transform: perspective(140px) rotateX(-180deg);
				            transform: perspective(140px) rotateX(-180deg);
				    opacity: 0;
				  } 25%, 75% {
				    -webkit-transform: perspective(140px) rotateX(0deg);
				            transform: perspective(140px) rotateX(0deg);
				    opacity: 1;
				  } 90%, 100% {
				    -webkit-transform: perspective(140px) rotateY(180deg);
				            transform: perspective(140px) rotateY(180deg);
				    opacity: 0;
				  }
				}
				</style>

		    <!-- Content Wrapper. Contains page content -->
		    <div class="content-wrapper">
				';

	}
	public function showFooter(){
    print'<footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 0.1.2
      </div>
      <strong>Powered by <a href="http://rpgpunzalan.com">RP</a>.</strong>
    </footer>
  </div>
  <!-- /.content-wrapper -->


	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Create the tabs -->
		<ul class="nav nav-tabs nav-justified control-sidebar-tabs">

		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<!-- Home tab content -->
			<div class="tab-pane" id="control-sidebar-home-tab">
				<h3 class="control-sidebar-heading">Notifications</h3>
				<ul class="control-sidebar-menu">
					<li>
						<a href="javascript:void(0)">
							<i class="menu-icon fa fa-birthday-cake bg-red"></i>

							<div class="menu-info">
								<h4 class="control-sidebar-subheading"> Birthday</h4>

								<p>Will be 23 on April 24th</p>
							</div>
						</a>
					</li>
				</ul>
				<!-- /.control-sidebar-menu -->

			</div>
			<!-- /.tab-pane -->
		</div>
	</aside>
	<!-- /.control-sidebar -->
	<!-- Add the sidebars background. This div must be placed
			 immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
    ';
  }

  public function showHeadHTML($site_title){
    print '
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>RP Axis | '.$site_title.'</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.6 -->
      <link rel="stylesheet" href="../assets/AdminLTE/bootstrap/css/bootstrap.min.css">
			<link rel="stylesheet" href="../assets/AdminLTE/plugins/select2/select2.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../assets/AdminLTE/dist/css/AdminLTE.min.css">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="../assets/AdminLTE/dist/css/skins/_all-skins.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="../assets/AdminLTE/plugins/iCheck/flat/blue.css">
      <!-- Morris chart -->
      <link rel="stylesheet" href="../assets/AdminLTE/plugins/morris/morris.css">
      <!-- jvectormap -->
      <link rel="stylesheet" href="../assets/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
      <!-- Date Picker -->
      <link rel="stylesheet" href="../assets/AdminLTE/plugins/datepicker/datepicker3.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="../assets/AdminLTE/plugins/daterangepicker/daterangepicker.css">
      <!-- bootstrap wysihtml5 - text editor -->
      <link rel="stylesheet" href="../assets/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
      <link rel="stylesheet" href="../assets/AdminLTE/plugins/datatables/dataTables.bootstrap.css">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <script>
        function PrintElem(elem){
          Popup($(elem).html());
        }

        function Popup(data) {
            var mywindow = window.open("", "printDocument", "height=400,width=600");
            mywindow.document.write("<html><head><title>my div</title>");
            mywindow.document.write(\'<link href="../assets/styles/main.css" rel="stylesheet">\');
            mywindow.document.write(\'<link href="../assets/plugins/sbadmin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">\');

            mywindow.document.write(\'<link href="../assets/plugins/sbadmin/dist/css/timeline.css" rel="stylesheet">\');
            mywindow.document.write(\'<link href="../assets/plugins/sbadmin/dist/css/sb-admin-2.css" rel="stylesheet">\');
            mywindow.document.write(\'<link href="../assets/plugins/sbadmin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">\');
            mywindow.document.write("</head><body >");
            mywindow.document.write(data);
            mywindow.document.write("</body></html>");

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10

            mywindow.print();
            mywindow.close();

            return true;
        }
      </script>
    ';
  }
	public function externalScripts(){
		print '
		<!-- jQuery 2.2.3 -->
		<script src="../assets/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
		  $.widget.bridge("uibutton", $.ui.button);
		</script>
		<!-- Bootstrap 3.3.6 -->
		<script src="../assets/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
		<!-- Morris.js charts -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="../assets/AdminLTE/plugins/morris/morris.min.js"></script>
		<!-- Sparkline -->
		<script src="../assets/AdminLTE/plugins/sparkline/jquery.sparkline.min.js"></script>
		<!-- jvectormap -->
		<script src="../assets/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="../assets/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<!-- jQuery Knob Chart -->
		<script src="../assets/AdminLTE/plugins/knob/jquery.knob.js"></script>
		<!-- daterangepicker -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
		<script src="../assets/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
		<script src="../assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="../assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
		<!-- datepicker -->
		<script src="../assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="../assets/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<!-- Slimscroll -->
		<script src="../assets/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="../assets/AdminLTE/plugins/fastclick/fastclick.js"></script>
		<script src="../assets/AdminLTE/plugins/select2/select2.full.min.js"></script>
		<!-- AdminLTE App -->
		<script src="../assets/AdminLTE/dist/js/app.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<!-- AdminLTE for demo purposes -->
		<script src="../assets/AdminLTE/dist/js/demo.js"></script>
		';
	}
}
?>

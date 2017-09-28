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


  public function addCustomer($customer_name,$address,$contact_number,$area_id,$record_id,$preseller){
    $link = $this->connect();
    $query=sprintf("INSERT INTO customers(customer_name,address,contact_no,area_id,record_id,preseller_id)
                      VALUES('".mysqli_real_escape_string($link,$customer_name)."',
                            '".mysqli_real_escape_string($link,$address)."',
                            '".mysqli_real_escape_string($link,$contact_number)."',
                            '".mysqli_real_escape_string($link,$area_id)."',
                            '".mysqli_real_escape_string($link,$record_id)."',
                            '".mysqli_real_escape_string($link,$preseller)."')");

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
                          '".mysqli_real_escape_string($link,date_format($check_date,"Y-m-d"))."',
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

  public function searchShipment($shipment_no){
    $link = $this->connect();
    $query = "SELECT po_id,
                    total_amount,
                    amount_paid,
                    discount,
                    po_date
            FROM purchase_orders
            WHERE shipment_no = '".mysqli_real_escape_string($link,$shipment_no)."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
   while($row =mysqli_fetch_assoc($result))
    {
       $data[] = $row;
    }
    return $data;

  }

  public function updateZeroBalance($shipment_no){
    $link = $this->connect();
    $query=sprintf("UPDATE purchase_orders
                    SET amount_paid = total_amount
                    WHERE shipment_no = '".mysqli_real_escape_string($link,$shipment_no)."'");
    $result = mysqli_query ( $link, $query );

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

  }

  public function updateBalance($shipment_no, $amount_paid, $po_id){
    $link = $this->connect();
    $query=sprintf("UPDATE purchase_orders
                    SET amount_paid = '".mysqli_real_escape_string($link,$amount_paid)."'
                    WHERE shipment_no = '".mysqli_real_escape_string($link,$shipment_no)."'
                    and po_id = '".mysqli_real_escape_string($link,$po_id)."'");
    $result = mysqli_query ( $link, $query );

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

  }

  public function addPurchaseOrder($po_id,$supplier_id,$po_date,$total_amount,$due_date,$status,$record_id,$discount,$shipment_no){
    $link = $this->connect();
    $query=sprintf("INSERT INTO purchase_orders(po_id,supplier_id,po_date,total_amount,amount_paid,due_date,status,record_id,discount,shipment_no)
                    VALUES('".mysqli_real_escape_string($link,$po_id)."',
                          '".mysqli_real_escape_string($link,$supplier_id)."',
                          '".mysqli_real_escape_string($link,date_format($po_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$total_amount)."',
                          '".mysqli_real_escape_string($link,"0")."',
                          '".mysqli_real_escape_string($link,date_format($due_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$status)."',
                          '".mysqli_real_escape_string($link,$record_id)."',
                          '".mysqli_real_escape_string($link,$discount)."',
                          '".mysqli_real_escape_string($link,$shipment_no)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return $po_id;

  }

  public function editPO($po_id,$new_amount,$new_quantity,$item_id){
    $link = $this->connect();
    $query=sprintf("UPDATE purchase_order_items
                    SET quantity = '".mysqli_real_escape_string($link,$new_quantity)."',
                    cost = '".mysqli_real_escape_string($link,$new_amount)."'
                    WHERE po_id = '".mysqli_real_escape_string($link,$po_id)."' AND item_id = '".mysqli_real_escape_string($link,$item_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function editPO2($po_id){
    $link = $this->connect();

    $query=sprintf("UPDATE purchase_orders po
                    INNER JOIN (
                      SELECT po_id, SUM(quantity * cost) as total
                      FROM purchase_order_items
                      GROUP BY po_id
                    ) poi ON po.po_id = '".mysqli_real_escape_string($link,$po_id)."' AND poi.po_id = '".mysqli_real_escape_string($link,$po_id)."'
                    SET po.total_amount = poi.total - po.discount");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function editCustomer($supplier_id,$new_name,$new_address,$new_contact,$new_preseller){
    $link = $this->connect();
    $query=sprintf("UPDATE customers
                    SET customer_name = '".mysqli_real_escape_string($link,$new_name)."',
                    address = '".mysqli_real_escape_string($link,$new_address)."',
                    preseller_id = '".mysqli_real_escape_string($link,$new_preseller)."',
                    contact_no = '".mysqli_real_escape_string($link,$new_contact)."'
                    WHERE customer_id = '".mysqli_real_escape_string($link,$supplier_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function editInventory2($item_id,$new_description,$new_srp){
    $link = $this->connect();
    $query=sprintf("UPDATE items
                    SET item_description = '".mysqli_real_escape_string($link,$new_description)."',
                    display_srp = '".mysqli_real_escape_string($link,$new_srp)."'
                    WHERE item_id = '".mysqli_real_escape_string($link,$item_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function editExpenses($expense_id,$new_date,$new_payee,$new_amount){
    $link = $this->connect();
    $query=sprintf("UPDATE expenses
                    SET expense_date = '".mysqli_real_escape_string($link,$new_date)."',
                    payee = '".mysqli_real_escape_string($link,$new_payee)."',
                    amount = '".mysqli_real_escape_string($link,$new_amount)."'
                    WHERE expense_id = '".mysqli_real_escape_string($link,$expense_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function editReturnItems($return_id,$item_id,$new_quantity,$new_cost){
    $link = $this->connect();
    $query=sprintf("UPDATE return_items
                    SET quantity = '".mysqli_real_escape_string($link,$new_quantity)."',
                    cost = '".mysqli_real_escape_string($link,$new_cost)."'
                    WHERE return_id = '".mysqli_real_escape_string($link,$return_id)."' AND item_id = '".mysqli_real_escape_string($link,$item_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function editReturns($return_id,$new_date){
    $link = $this->connect();

    $query=sprintf("UPDATE returns r
                    INNER JOIN (
                      SELECT return_id, SUM(quantity * cost) as total
                      FROM return_items
                      GROUP BY return_id
                    ) ri ON r.return_id = '".mysqli_real_escape_string($link,$return_id)."' AND ri.return_id = '".mysqli_real_escape_string($link,$return_id)."'
                    SET r.total_amount = ri.total,
                    r.return_date = '".mysqli_real_escape_string($link,$new_date)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function editSupplier($supplier_id,$new_name,$new_address,$new_contact){
    $link = $this->connect();
    $query=sprintf("UPDATE suppliers
                    SET supplier_name = '".mysqli_real_escape_string($link,$new_name)."',
                    address = '".mysqli_real_escape_string($link,$new_address)."',
                    contact_number = '".mysqli_real_escape_string($link,$new_contact)."'
                    WHERE supplier_id = '".mysqli_real_escape_string($link,$supplier_id)."'");

    if (!mysqli_query($link, $query)) {
        $ret = array("status"=>"failed","message"=>mysqli_error($link));
    }else $ret = array("status"=>"success");

    return $ret;

  }

  public function removeEmpty($supplier_id){
    $link = $this->connect();
    $query=sprintf("DELETE FROM return_empty
                    WHERE item_id
                    IN (SELECT item_id FROM items
                    WHERE supplier_id = '".mysqli_real_escape_string($link,$supplier_id)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return true;

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
    $query=sprintf("INSERT INTO collections(payment_method,amount,payment_date,cc_id)
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

  public function addReturnEmpty($item_id,$customer_id,$num_bottle,$num_case,$return_date){/**SEPT4**/
    $link = $this->connect();
    $query=sprintf("INSERT INTO return_empty(item_id,customer_id,num_bottle,num_case,return_date)
                    VALUES('".mysqli_real_escape_string($link,$item_id)."',
                          '".mysqli_real_escape_string($link,$customer_id)."',
                          '".mysqli_real_escape_string($link,$num_bottle)."',
                          '".mysqli_real_escape_string($link,$num_case)."',
                          '".mysqli_real_escape_string($link,date_format($return_date,"Y-m-d"))."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }
  public function addCustomerDeposit($customer_id,$deposit_date,$deposit_amount){ /**SEPT4**/
    $link = $this->connect();
    $query=sprintf("INSERT INTO customer_deposits(customer_id,deposit_date,deposit_amount)
                    VALUES('".mysqli_real_escape_string($link,$customer_id)."',
                          '".mysqli_real_escape_string($link,$deposit_date)."',
                          '".mysqli_real_escape_string($link,$deposit_amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);
  }

  public function addMBDeposit($supplier_id,$deposit_date,$deposit_amount){ /**SEPT4**/
    $link = $this->connect();
    $query=sprintf("INSERT INTO mb_deposits(supplier_id,deposit_date,deposit_amount)
                    VALUES('".mysqli_real_escape_string($link,$supplier_id)."',
                          '".mysqli_real_escape_string($link,$deposit_date)."',
                          '".mysqli_real_escape_string($link,$deposit_amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);
  }

  public function addInventoryEmpty($return_id,$item_id,$num_bottle,$num_case){
    $link = $this->connect();
    $query=sprintf("UPDATE inventory_empty
        SET empty_bottle = empty_bottle + '".mysqli_real_escape_string($link,$num_bottle)."',
        empty_case = empty_case + '".mysqli_real_escape_string($link,$num_case)."'
        WHERE item_id = '".mysqli_real_escape_string($link,$item_id)."'");

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

  public function updateSaleItem($sale_id,$item_id,$quantity,$amount){
    $link = $this->connect();

    $query=sprintf("UPDATE sale_items
                    SET quantity = quantity - '".mysqli_real_escape_string($link,$quantity)."'
                    WHERE sale_id = '".mysqli_real_escape_string($link,$sale_id)."'
                    AND item_id = '".mysqli_real_escape_string($link,$item_id)."'");

    if (!mysqli_query($link, $query)) {

        return mysqli_error($link);
    }else {
      $this->updateSale($sale_id,$amount*$quantity);
      return mysqli_insert_id($link);
    }
  }

  public function updateSale($sale_id,$amount){
    $link = $this->connect();

    $query=sprintf("UPDATE sales
                    SET total_amount = total_amount-'".mysqli_real_escape_string($link,$amount)."'
                    WHERE sale_id = '".mysqli_real_escape_string($link,$sale_id)."'");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }

  public function addCashVoucher($voucher_id,$voucher_date,$payee,$total_amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO cash_vouchers(voucher_id,voucher_date,payee,total_amount)
                    VALUES('".mysqli_real_escape_string($link,$voucher_id)."',
                          '".mysqli_real_escape_string($link,date_format($voucher_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$payee)."',
                          '".mysqli_real_escape_string($link,$total_amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }
  public function addCashVoucherItem($voucher_id,$item_id,$amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO cash_voucher_items(voucher_id,particulars,amount)
                    VALUES('".mysqli_real_escape_string($link,$voucher_id)."',
                          '".mysqli_real_escape_string($link,$item_id)."',
                          '".mysqli_real_escape_string($link,$amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }
  public function addCheckVoucher($voucher_id,$voucher_date,$payee,$check_no,$total_amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO check_vouchers(voucher_id,voucher_date,payee,check_no,total_amount)
                    VALUES('".mysqli_real_escape_string($link,$voucher_id)."',
                          '".mysqli_real_escape_string($link,date_format($voucher_date,"Y-m-d"))."',
                          '".mysqli_real_escape_string($link,$payee)."',
                          '".mysqli_real_escape_string($link,$check_no)."',
                          '".mysqli_real_escape_string($link,$total_amount)."')");

    if (!mysqli_query($link, $query)) {
        return mysqli_error($link);
    }else return mysqli_insert_id($link);

  }
  public function addCheckVoucherItem($voucher_id,$item_id,$amount){
    $link = $this->connect();
    $query=sprintf("INSERT INTO check_voucher_items(voucher_id,particulars,amount)
                    VALUES('".mysqli_real_escape_string($link,$voucher_id)."',
                          '".mysqli_real_escape_string($link,$item_id)."',
                          '".mysqli_real_escape_string($link,$amount)."')");

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

  public function getEmptiesInventory(){
    $link = $this->connect();
    $query = "SELECT it.item_description,
                      sum(re.num_bottle) as 'bottles',
                      sum(re.num_case) as 'cases'
              FROM return_empty re
              INNER JOIN items it
              ON it.item_id = re.item_id
              GROUP BY it.item_id";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "
          <tr>
            <td>".$row['item_description']."</td>
            <td>".$row['bottles']."</td>
            <td>".$row['cases']."</td>
          </tr>
        ";
    }
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

  public function getInventoryReport($d1,$d2){
    $link = $this->connect();
    $query = "SELECT it.item_description,
                      (Select sum(quantity) from inventory
                       where quantity >=1 AND
                       trans_date BETWEEN '$d1' AND '$d2'
                      AND item_id = i.item_id) as 'in',
                       (Select sum(quantity*-1) from inventory
                       where quantity <0 AND
                       trans_date BETWEEN '$d1' AND '$d2'
                      AND item_id = i.item_id) as 'out',
                      sum(i.quantity) as 'total',
                      it.cost
            FROM inventory i
            INNER JOIN items it
            ON it.item_id = i.item_id
            WHERE i.trans_date BETWEEN '".$d1."' AND '".$d2."'
            GROUP BY i.item_id";
    $result = mysqli_query ( $link, $query );
    print "<tbody>";
    $total=0;
    $totalqty=0;
    $index=0;
    $intotal = 0;
    $outtotal = 0;
    while($row =mysqli_fetch_assoc($result))
    {
      $out = 0;
      $in = 0;
      if($row['out']) $out = $row['out'];
      if($row['in']) $in = $row['in'];
      $intotal += $in;
      $outtotal += $out;
      print "<tr id='inventory".$index."'>
        <td id='desc".$index."'>".$row['item_description']."</td>
        <td id='in".$index."'>".number_format($in,0)."</td>
        <td id='out".$index."'>".number_format($out,0)."</td>
        <td id='total".$index."'>".number_format($row['total'],0)."</td>
      </tr>";
      $total += $row['total']*$row['cost'];
      $totalqty += $row['total'];
      $index++;
    }
    print "</tbody>
    <tfooter>
      <tr>
        <td></td>
        <td>".number_format($intotal,2)."</td>
        <td>".number_format($outtotal,2)."</td>
      </tr>
      <tr>
        <td colspan=3>Total Qty</td>
        <td>".number_format($totalqty,2)."</td>
      </tr>
      <tr>
        <td colspan=3>Inventory Cost</td>
        <td>".number_format($total,2)."</td>
      </tr>
    </tfooter>
    ";
    return number_format($total,2);
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

  public function allPayables(){
    $link = $this->connect();
    $query = "SELECT sum(po.total_amount-po.amount_paid) as 'bal',
                    s.supplier_name,
                    po.due_date
              FROM purchase_orders po
              INNER JOIN suppliers s
              ON s.supplier_id = po.supplier_id
              GROUP BY po.due_date, po.supplier_id
              HAVING sum(po.total_amount-po.amount_paid)>0
              ORDER BY po.due_date DESC";
    $result = mysqli_query ( $link, $query );
    print "<tbody>";
    $total = 0;
    $index = 0;
   while($row =mysqli_fetch_assoc($result))
    {
       print "
        <tr id='payableValue".$index."'>
          <td id='supplier".$index."'>".$row['supplier_name']."</td>
          <td id='date".$index."'>".$row['due_date']."</td>
          <td id='bal".$index."'>".number_format($row['bal'],2)."</td>
        </tr>
       ";
       $index++;
       $total+=$row['bal'];
    }
    print "</tbody>
    <tfooter>
      <tr>
        <td colspan=2>Total Payables</td>
        <td>".number_format($total,2)."</td>
      </tr>
    </tfooter>
    ";
    return number_format($total,2);
  }
  public function getSupplierPayables($supplier_id){
    $link = $this->connect();
    $query = "SELECT sum(po.total_amount-po.amount_paid) as 'bal',
                    s.supplier_name,
                    po.due_date
              FROM purchase_orders po
              INNER JOIN suppliers s
              ON s.supplier_id = po.supplier_id
              WHERE po.supplier_id = '".$supplier_id."'
              GROUP BY po.due_date
              HAVING sum(po.total_amount-po.amount_paid)>0";
    $result = mysqli_query ( $link, $query );
    print "<tbody>";
    $total=0;
   while($row =mysqli_fetch_assoc($result))
    {
       print "
        <tr>
          <td>".$row['due_date']."</td>
          <td>".number_format($row['bal'],2)."</td>
        </tr>
       ";
       $total+=$row['bal'];
    }
    print "</tbody>
    <tfooter>
      <tr>
        <td>Total Payables</td>
        <td>".number_format($total,2)."</td>
      </tr>
    </tfooter>
    ";
  }
  public function getCustomerCollectibles($customer_id){
    $link = $this->connect();
    $query = "SELECT sum(po.total_amount-po.amount_paid) as 'bal',
                    s.customer_name,
                    po.due_date
              FROM sales po
              INNER JOIN customers s
              ON s.customer_id = po.customer_id
              WHERE po.customer_id = '".$customer_id."'
              GROUP BY po.due_date
              HAVING sum(po.total_amount-po.amount_paid)>0
              ORDER BY po.due_date DESC";
    $result = mysqli_query ( $link, $query );
    print "<tbody>";
    $total = 0;
   while($row =mysqli_fetch_assoc($result))
    {
       print "
        <tr>
          <td>".$row['due_date']."</td>
          <td>".number_format($row['bal'],2)."</td>
        </tr>
       ";
       $total += $row['bal'];
    }
    print "</tbody>
    <tfooter>
      <tr>
        <td>Total Collectibles</td>
        <td>".number_format($total,2)."</td>
      </tr>
    </tfooter>
    ";
  }
  public function allCollectibles(){
    $link = $this->connect();
    $query = "SELECT sum(po.total_amount-po.amount_paid) as 'bal',
                    s.customer_name,
                    po.due_date
              FROM sales po
              INNER JOIN customers s
              ON s.customer_id = po.customer_id
              GROUP BY po.due_date,po.customer_id
              HAVING sum(po.total_amount-po.amount_paid)>0
              ORDER BY po.due_date DESC";
    $result = mysqli_query ( $link, $query );
    print "<tbody>";
    $total = 0;
    $index = 0;
   while($row =mysqli_fetch_assoc($result))
    {
       print "
        <tr id='collectibleValue".$index."'>
          <td id='customer".$index."'>".$row['customer_name']."</td>
          <td id='date".$index."'>".$row['due_date']."</td>
          <td id='bal".$index."'>".number_format($row['bal'],2)."</td>
        </tr>
       ";
       $total += $row['bal'];
       $index++;
    }
    print "</tbody>
    <tfooter>
      <tr>
        <td colspan=2>Total Collectibles</td>
        <td>".number_format($total,2)."</td>
      </tr>
    </tfooter>
    ";

    return number_format($total,2);
  }

  public function getReturns($customer_id,$d1,$d2){
     $link = $this->connect();
    $query = "SELECT
              sum(ri.quantity) AS rquantity,
              r.total_amount AS total
            FROM returns r
            INNER JOIN return_items ri
            ON ri.return_id = r.return_id
            WHERE r.customer_id = '".$customer_id."' AND r.return_date  BETWEEN '".$d1."' AND '".$d2."'
            GROUP BY r.customer_id";

    $result = mysqli_query ( $link, $query );
     while($row =mysqli_fetch_assoc($result))
    {
      return $row;
    }
  }

  public function cds($d1,$d2){ /**SEPT4**/
    $link = $this->connect();
    $query = "SELECT s.sale_id,
              c.customer_name,
              p.name,
              c.customer_id,
              a.area_name,
              s.sale_date,
              sum(s.total_amount) as total_amount,
              sum(s.amount_paid) as amount_paid,
              sum(s.total_amount-s.amount_paid) as balance
            FROM sales s
            INNER JOIN customers c
            ON c.customer_id = s.customer_id
            INNER JOIN presellers p
            ON p.preseller_id = c.preseller_id
            INNER JOIN areas a
            ON a.area_id = c.area_id
            WHERE s.sale_date BETWEEN '".$d1."' AND '".$d2."'
            GROUP BY s.customer_id

              ";

    $result = mysqli_query ( $link, $query );
    print "<tbody>";

    $index = 0;
    $t1 = 0;
    $t2 = 0;
    $t3 = 0;
    $t4 = 0;
    $t5 = 0;
    $t6 = 0;
   while($row =mysqli_fetch_assoc($result))
    {
       $qty = $this->getTotalQtyCustomer($row['customer_id'],$d1,$d2);
      $d = $this->getReturns($row['customer_id'],$d1,$d2);
      if($d['rquantity']){
        $rq = $d['rquantity'];
      }else
        $rq = 0;

      if($d['total']){
        $rt = $d['total'];
      }else
        $rt = 0;
       print "
        <tr id='cdsValue".$index."'>
          <td height=12 width=30% id='cname".$index."'>".$row['customer_name']."</td>
          <td id='cname".$index."'>".$row['name']."</td>
          <td id='cname".$index."'>".$row['area_name']."</td>
          <td id='sdate".$index."'>".$row['sale_id']."</td>
          <td id='squantity".$index."'>".number_format($qty,0)."</td>
          <td id='samount".$index."'>".number_format($row['total_amount']+$rt,2)."</td>
          <td id='tamount".$index."'>".number_format($rq,0)."</td>
          <td id='tamount".$index."'>".number_format($rt,2)."</td>
          <td id='tamount".$index."'>".number_format($row['amount_paid'],2)."</td>
          <td id='tamount".$index."'>".number_format($row['balance'],2)."</td>
        </tr>
       ";
       $t1 += $qty;
       $t2 += $row['total_amount'];
       $t3 += $rq;
       $t4 += $rt;
       $t5 += $row['amount_paid'];
       $t6 += $row['balance'];
       $index++;
    }
  }

public function getTotalQtySale($sale_id){
  $link = $this->connect();
    $query = "SELECT sum(quantity) as qty
              FROM sale_items
              WHERE sale_id = '".$sale_id."'
              GROUP BY sale_id
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        return $row['qty'];
    }
}
public function getTotalQtyCustomer($customer_id,$d1,$d2){
  $link = $this->connect();
    $query = "SELECT sum(quantity) as qty
              FROM sale_items si
              INNER JOIN sales s
              ON s.sale_id = si.sale_id
              WHERE s.customer_id = '".$customer_id."'
              AND s.sale_date BETWEEN '".$d1."' AND '".$d2."'
              GROUP BY s.customer_id";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        return $row['qty'];
    }
}
public function blankcds($d1,$d2){
    $link = $this->connect();
    $query = "SELECT s.sale_id,
              c.customer_name,
              p.name,
              a.area_name,
              c.customer_id,
              s.sale_date,
              sum(s.total_amount) as total_amount,
              sum(s.amount_paid) as amount_paid,
              sum(s.total_amount-s.amount_paid) as balance
            FROM sales s
            INNER JOIN customers c
            ON c.customer_id = s.customer_id
            INNER JOIN presellers p
            ON c.preseller_id = p.preseller_id
            INNER JOIN areas a
            ON a.area_id = c.area_id
            WHERE s.sale_date BETWEEN '".$d1."' AND '".$d2."'
            GROUP BY s.customer_id, s.sale_date";

    $result = mysqli_query ( $link, $query );
    print "<tbody>";

    $index = 0;
    $t1 = 0;
    $t2 = 0;
    $t3 = 0;
    $t4 = 0;
    $t5 = 0;
    $t6 = 0;
   while($row =mysqli_fetch_assoc($result))
    {
      $qty = $this->getTotalQtyCustomer($row['customer_id'],$d1,$d2);
      $d = $this->getReturns($row['customer_id'],$d1,$d2);
      if($d['rquantity']){
        $rq = $d['rquantity'];
      }else
        $rq = 0;

      if($d['total']){
        $rt = $d['total'];
      }else
        $rt = 0;
       print "
        <tr id='cdsValue".$index."'>
          <td id='cname".$index."'>".$row['customer_name']."</td>
          <td id='aname".$index."'>".$row['name']."</td>
          <td id='aname".$index."'>".$row['area_name']."</td>
          <td id='sdate".$index."'>".$row['sale_id']."</td>
          <td id='squantity".$index."'>".number_format($qty,0)."</td>
          <td id='samount".$index."'>".number_format($row['total_amount'],2)."</td>
          <td id='tamount".$index."'></td>
          <td id='tamount".$index."'></td>
          <td id='tamount".$index."'></td>
          <td id='tamount".$index."'></td>
        </tr>
       ";
       $t1 += $qty;
       $t2 += $row['total_amount'];
       $t3 += $rq;
       $t4 += $rt;
       $t5 += $row['amount_paid'];
       $t6 += $row['balance'];
       $index++;
    }

    
  }
  public function blankcdsarea($d1,$d2,$area){
    $link = $this->connect();
    $query = "SELECT s.sale_id,
              c.customer_name,
              p.name,
              c.customer_id,
              a.area_name,
              s.sale_date,
              sum(s.total_amount) as total_amount,
              sum(s.amount_paid) as amount_paid,
              sum(s.total_amount-s.amount_paid) as balance
            FROM sales s
            INNER JOIN customers c
            ON c.customer_id = s.customer_id
            INNER JOIN presellers p
            ON p.preseller_id = c.preseller_id
            INNER JOIN areas a
            ON a.area_id = c.area_id
            WHERE s.sale_date BETWEEN '".$d1."' AND '".$d2."' AND c.area_id = '".$area."'
            GROUP BY s.customer_id, s.sale_date";

    $result = mysqli_query ( $link, $query );
    print "<tbody>";

    $index = 0;
    $t1 = 0;
    $t2 = 0;
    $t3 = 0;
    $t4 = 0;
    $t5 = 0;
    $t6 = 0;
   while($row =mysqli_fetch_assoc($result))
    {
      $qty = $this->getTotalQtyCustomer($row['customer_id'],$d1,$d2);
      $d = $this->getReturns($row['customer_id'],$d1,$d2);
      if($d['rquantity']){
        $rq = $d['rquantity'];
      }else
        $rq = 0;

      if($d['total']){
        $rt = $d['total'];
      }else
        $rt = 0;
       print "
        <tr id='cdsValue".$index."'>
          <td id='cname".$index."'>".$row['customer_name']."</td>
          <td id='aname".$index."'>".$row['name']."</td>
          <td id='aname".$index."'>".$row['area_name']."</td>
          <td id='sdate".$index."'>".$row['sale_id']."</td>
          <td id='squantity".$index."'>".number_format($qty,0)."</td>
          <td id='samount".$index."'>".number_format($row['total_amount'],2)."</td>
          <td id='tamount".$index."'></td>
          <td id='tamount".$index."'></td>
          <td id='tamount".$index."'></td>
          <td id='tamount".$index."'></td>
        </tr>
       ";
       $t1 += $qty;
       $t2 += $row['total_amount'];
       $t3 += $rq;
       $t4 += $rt;
       $t5 += $row['amount_paid'];
       $t6 += $row['balance'];
       $index++;
    }

    print "
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>".number_format($t1,0)."</th>
          <th>".number_format($t2,2)."</th>
        </tr>
      </tfoot>
    ";
  }

  public function weeklyPayables($d1, $d2){
    $link = $this->connect();
    $query = "SELECT sum(po.total_amount-po.amount_paid) as 'bal',
                    s.supplier_name,
                    po.due_date
              FROM purchase_orders po
              INNER JOIN suppliers s
              ON s.supplier_id = po.supplier_id
              WHERE po.due_date
              BETWEEN '".$d1."' AND '".$d2."'
              GROUP BY po.due_date, po.supplier_id
              HAVING sum(po.total_amount-po.amount_paid)>0
              ORDER BY po.due_date DESC";
    $result = mysqli_query ( $link, $query );
   while($row =mysqli_fetch_assoc($result))
    {
       print "
        <tr>
          <td>".$row['supplier_name']."</td>
          <td>".number_format($row['bal'],2)."</td>
          <td>".$row['due_date']."</td>
        </tr>
       ";
    }
  }
  public function weeklyCollectibles($d1, $d2){
    $link = $this->connect();
    $query = "SELECT sum(po.total_amount-po.amount_paid) as 'bal',
                    s.customer_name,
                    po.due_date
              FROM sales po
              INNER JOIN customers s
              ON s.customer_id = po.customer_id
              WHERE po.due_date BETWEEN '".$d1."' AND '".$d2."'
              GROUP BY po.due_date, po.customer_id
              HAVING sum(po.total_amount-po.amount_paid)>0
              ORDER BY po.due_date DESC";
    $result = mysqli_query ( $link, $query );
   while($row =mysqli_fetch_assoc($result))
    {
       print "
        <tr>
          <td>".$row['customer_name']."</td>
          <td>".number_format($row['bal'],2)."</td>
          <td>".$row['due_date']."</td>
        </tr>
       ";
    }
  }
  public function getPayableReport($d1, $d2){
    $link = $this->connect();
    $query = "SELECT total_amount,amount_paid FROM purchase_orders WHERE due_date BETWEEN '".$d1."' AND '".$d2."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
   while($row =mysqli_fetch_assoc($result))
    {
       $data[] = $row;
    }
    return $data;
  }

  public function getCollectibleReport($d1, $d2){
    $link = $this->connect();
    $query = "SELECT total_amount,
                    amount_paid
            FROM sales
            WHERE due_date BETWEEN '".$d1."' AND '".$d2."'";
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
      $query = "SELECT cost
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

  public function getCustomerList(){ /**SEPT4**/
    $link = $this->connect();
    $query = "SELECT c.customer_id,
                    c.customer_name,
                    c.address,
                    c.contact_no,
                    a.area_name,
                    c.record_id,
                    c.preseller_id,
                    sum(cd.deposit_amount) as deposit
              FROM  customers c
              INNER JOIN areas a
              ON a.area_id = c.area_id
              LEFT JOIN customer_deposits cd
              ON cd.customer_id = c.customer_id
              GROUP BY c.customer_id
              ORDER BY c.customer_name";
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
      print "<tr>
            <td>".$row['customer_id']."</td>
            <td>".$row['customer_name']."</td>
            <td>".$row['address']."</td>
            <td>".$row['contact_no']."</td>
            <td>".$row['area_name']."</td>
            <td>";
            if($this->getReceivables($row['customer_id'])[0]['receivables']) 
              print number_format($this->getReceivables($row['customer_id'])[0]['receivables'],2);
            else print "0"; 
            print"</td>
            <td>";
            if($row['deposit']) 
              print number_format($row['deposit'],2);
            else print "0"; print"</td>
      <td><a href='#' class='btn btn-primary btn-block showEditCustomer' data-toggle='modal' data-target='#editCustomer' data-id='".$row['customer_id']."' data-name='".$row['customer_name']."' data-address='".$row['address']."' data-contact='".$row['contact_no']."' data-preseller='".$row['preseller_id']."'><b>Edit</b></a></tr>";
    }
    return $data;
  }

  public function ddlCustomers(){
    $link = $this->connect();
    $query = "SELECT c.customer_id,
                    customer_name,
                    p.name
              FROM  customers c
              INNER JOIN presellers p
              ON p.preseller_id = c.preseller_id
              ORDER BY customer_name";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['customer_id']."'>".$row['customer_name']. " - " . $row['name']. "</option>";
    }
  }
  public function ddlPresellers(){
    $link = $this->connect();
    $query = "SELECT preseller_id,
                    name
              FROM  presellers
              ORDER BY name";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['preseller_id']."'>".$row['name']."</option>";
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
    $query = "SELECT it.item_id,
                      it.item_description,
                      it.display_srp,
                      s.supplier_name,
                      it.supplier_id
              FROM  items it, suppliers s
              WHERE it.supplier_id = s.supplier_id";
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

  public function getCashVoucherList(){
    $link = $this->connect();
    $query = "SELECT voucher_id,
                      voucher_date,
                      payee,
                      total_amount
              FROM  cash_vouchers
              ORDER BY voucher_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getCashVoucherListRange($d1,$d2){
    $link = $this->connect();
    $query = "SELECT voucher_id,
                      voucher_date,
                      payee,
                      total_amount
              FROM  cash_vouchers
              WHERE voucher_date BETWEEN '".$d1."' AND '".$d2."'
              ORDER BY voucher_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getCheckVoucherList(){
    $link = $this->connect();
    $query = "SELECT voucher_id,
                      voucher_date,
                      payee,
                      check_no,
                      total_amount
              FROM  check_vouchers
              ORDER BY voucher_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getCheckVoucherListRange($d1,$d2){
    $link = $this->connect();
    $query = "SELECT voucher_id,
                      voucher_date,
                      payee,
                      check_no,
                      total_amount
              FROM  check_vouchers
              WHERE voucher_date BETWEEN '".$d1."' AND '".$d2."'
              ORDER BY voucher_date";
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
                    p.record_id,
                    p.shipment_no,
                    sum(pi.quantity) as total_qty
              FROM  purchase_orders p
              INNER JOIN suppliers s
              ON s.supplier_id = p.supplier_id
              INNER JOIN purchase_order_items pi
              ON pi.po_id = p.po_id
              INNER JOIN status stat
              ON stat.status_code = p.status
              GROUP BY p.po_id
              ORDER BY po_date
              ";
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
                    p.record_id,
                    p.shipment_no
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

  public function getCashVoucherById($voucher_id){
    $link = $this->connect();
    $query = "SELECT voucher_id,
                      voucher_date,
                      payee,
                      total_amount
              FROM  cash_vouchers
              WHERE voucher_id = '".mysqli_real_escape_string($link,$voucher_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getCashVoucherItems($voucher_id){
    $link = $this->connect();
    $query = "SELECT particulars,
                    amount
              FROM  cash_voucher_items
              WHERE voucher_id = '".mysqli_real_escape_string($link,$voucher_id)."'";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getCheckVoucherById($voucher_id){
    $link = $this->connect();
    $query = "SELECT voucher_id,
                      voucher_date,
                      payee,
                      check_no,
                      total_amount
              FROM  check_vouchers
              WHERE voucher_id = '".mysqli_real_escape_string($link,$voucher_id)."'
              LIMIT 1";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getCheckVoucherItems($voucher_id){
    $link = $this->connect();
    $query = "SELECT particulars,
                    amount
              FROM  check_voucher_items
              WHERE voucher_id = '".mysqli_real_escape_string($link,$voucher_id)."'";
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
                    p.record_id,
                    p.shipment_no
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
                    i.item_id,
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
                    r.total_amount,
                    ri.quantity,
                    ri.cost,
                    ri.item_id
              FROM  returns r
              INNER JOIN customers c
              ON c.customer_id = r.customer_id
              INNER JOIN areas a
              ON a.area_id = c.area_id
              INNER JOIN return_items ri
              ON r.return_id = ri.return_id

              ORDER BY r.return_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getSales($d1,$d2){
    $link = $this->connect();
    $query = "SELECT sum(total_amount) as 'total_amount'
              FROM  sales s
              WHERE s.sale_date BETWEEN '".$d1."' AND '".$d2."' ";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
      return $row['total_amount'];
    }
  }
  public function getCostOfSales($d1,$d2){
    $link = $this->connect();
    $query = "SELECT sum(i.cost*s.quantity) as 'total_amount'
              FROM  sale_items s
              INNER JOIN items i
              ON i.item_id = s.item_id
              INNER JOIN sales ss
              ON ss.sale_id = s.sale_id
              WHERE ss.sale_date BETWEEN '".$d1."' AND '".$d2."' ";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
      return $row['total_amount'];
    }
  }
  public function getExpenses($d1,$d2){
    $link = $this->connect();
    $query = "SELECT sum(amount) as 'total_amount'
              FROM  expenses
              WHERE expense_date BETWEEN '".$d1."' AND '".$d2."' ";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
      return $row['total_amount'];
    }
  }
  public function prepareDelivery($d1,$preseller_id){
    $link = $this->connect();
    $query = "SELECT i.item_description,
                    sum(pi.quantity) as qty,
                    sum(pi.amount) as total_amount,
                    a.area_name
              FROM  sales po
              INNER JOIN sale_items pi
              ON pi.sale_id = po.sale_id
              INNER JOIN items i
              ON i.item_id = pi.item_id
              INNER JOIN customers c
              ON c.customer_id = po.customer_id
              INNER JOIN areas a
              ON a.area_id = c.area_id
              WHERE po.sale_date = '".$d1."' and pi.quantity>0
              AND c.preseller_id = '".$preseller_id."'
              GROUP BY i.item_id";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }
  public function getSaleSummary($d1){
    $link = $this->connect();
    $query = "SELECT a.area_name,
                    sum(si.quantity) as qty,
                    sum(s.total_amount) as amt
              FROM  sales s
              INNER JOIN sale_items si
              ON si.sale_id = s.sale_id
              INNER JOIN customers c
              ON c.customer_id = s.customer_id
              INNER JOIN areas a
              ON a.area_id = c.area_id
              WHERE s.sale_date = '".$d1."'
              GROUP BY a.area_id
              ORDER BY a.area_name";
    $result = mysqli_query ( $link, $query );
    $total = 0;
    while($row =mysqli_fetch_assoc($result))
    {
        $total+=$row['amt'];
        print "
            <tr>
              <td>".$row['area_name']."</td>
              <td>".$row['qty']."</td>
              <td>".number_format($row['amt'],2)."</td>
            </tr>
        ";
    }
    return $total;
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
        if($row['total_amount']-$row['amount_paid']>0){
            print "<tr><td><a href=saleDetails.php?sale_id=".$row['sale_id'].">".$row['sale_id']."</a>".
                                            "</td><td>".$row['sale_date'].
                                            "</td><td>".$row['customer_name'].
                                            "</td><td>".$row['area_name'].
                                            "</td><td>".$row['total_amount'].
                                            "</td><td>".($row['total_amount']-$row['amount_paid']).
                                            "</td><td>".$row['due_date'].
                                            "</td><td>".$row['status_name'].
                                            "</td><td><a href='#' class='btn btn-primary btn-block showRecordPayment' onclick='addPaymentFull(".$row['sale_id'].",".$row['total_amount'].",".$row['sale_date'].");'><b>FULL</b></a>".
                                            "</td><td><a href='#' class='btn btn-primary btn-block showRecordPayment' data-toggle='modal' data-target='#recordPayment' data-id='".$row['sale_id']."'><b>Record Collection</b></a></tr>";
        }else{
          print "<tr><td><a href=saleDetails.php?sale_id=".$row['sale_id'].">".$row['sale_id']."</a>".
                                            "</td><td>".$row['sale_date'].
                                            "</td><td>".$row['customer_name'].
                                            "</td><td>".$row['area_name'].
                                            "</td><td>".$row['total_amount'].
                                            "</td><td>".($row['total_amount']-$row['amount_paid']).
                                            "</td><td>".$row['due_date'].
                                            "</td><td>".$row['status_name'].
                                            "</td><td>-</td><td>-</td></tr>";
        }
        
    }
    return $data;
  }
  public function getSaleListRange($d1,$d2){
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
              WHERE s.sale_date BETWEEN '".$d1."' AND '".$d2."'
              ORDER BY sale_date";
    $result = mysqli_query ( $link, $query );
    $data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
    return $data;
  }

  public function getPresellers(){

    $link = $this->connect();
    $query = "SELECT preseller_id,
                    name
              FROM  presellers
              ORDER BY name";
    $result = mysqli_query ( $link, $query );
    $select= '<select name="presellers" id="presellers"><option selected disabled>Presellers</option>';
    while($row =mysqli_fetch_assoc($result))
    {
        $select.='<option value="'.$row['preseller_id'].'">'.$row['name'].'</option>';
    }

    $select.='</select>';
    echo $select;

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
                    p.item_id,
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
  public function ddlSaleNumbers(){
    $link = $this->connect();
    $query = "SELECT s.sale_id,
                    s.customer_id,
                    c.customer_name
              FROM  sales s
              INNER JOIN customers c
              ON c.customer_id = s.customer_id
              ORDER BY s.sale_id";
    $result = mysqli_query ( $link, $query );
    while($row =mysqli_fetch_assoc($result))
    {
        print "<option value='".$row['sale_id'].",".$row['customer_id']."'>".$row['sale_id']." - ".$row['customer_name'].  "</option>";
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
          <a href="index.php" class="logo">
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
                  <li><a href="shipment.php"><i class="fa fa-circle-o"></i> Shipment</a></li>
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
                  <li><a href="prepareDelivery.php"><i class="fa fa-circle-o"></i> Prepare Delivery</a></li>
                  <li><a href="blankcds.php"><i class="fa fa-circle-o"></i> Blank CDS</a></li>
                  <li><a href="customerdeliverysheet.php"><i class="fa fa-circle-o"></i> Customer Delivery Sheet</a></li>
                  <li><a href="saleSummary.php"><i class="fa fa-circle-o"></i> Summary of Sales</a></li>
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
              if($active==8) print'
              <li class="active treeview">';
              else print '<li class="treeview">';
              print'
                <a href="#">
                  <i class="fa fa-file-o"></i>
                  <span>Vouchers</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="cash_vouchers.php"><i class="fa fa-circle-o"></i> Cash Vouchers</a></li>
                  <li><a href="check_vouchers.php"><i class="fa fa-circle-o"></i> Check Vouchers</a></li>
                </ul>
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
                  <li><a href="payablecollectible.php"><i class="fa fa-circle-o"></i> Payables and Collectibles</a></li>
                </ul>
              </li>';
              }
              // '';if($active==8) print'
              // <li class="active">';
              // else print '<li>';
              // print'
              //   <a href="recordbankslip.php">
              //     <i class="fa fa-bank"></i> <span>Record Bank Slip</span>
              //   </a>
              // </li>';
              '';if($active==9) print'
              <li class="active">';
              else print '<li>';
              print'
                <a href="returnempties.php">
                  <i class="fa fa-mail-reply-all"></i> <span>Record Customer Deposit</span>
                </a>
              </li>
               ';if($active==10) print'
              <li class="active">';
              else print '<li>';
              print'
                <a href="mavadeposit.php">
                  <i class="fa fa-mail-reply-all"></i> <span>Record Deposit</span>
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

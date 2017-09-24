<?php
require_once('../inc/dbinfo.inc');
require_once('../inc/constants.inc');
class site_settings_util{

  private function connect() {
		$link = mysqli_connect ( HOSTNAME, USERNAME, PASSWORD, DATABASE ) or die ( 'Could not connect: ' . mysqli_error () );
		mysqli_select_db ( $link, DATABASE ) or die ( 'Could not select database' . mysql_error () );
		return $link;
	}

  public function getCompanyName(){
    $link = $this->connect();
    $query = "SELECT value FROM site_settings WHERE setting_key = 'company_name'";
		$result = mysqli_query ( $link, $query );
		while ( $row = mysqli_fetch_row ( $result ) ) {
			return $row[0];
		}
  }

  public function getSiteTitle(){
    $link = $this->connect();
    $query = "SELECT value FROM site_settings WHERE setting_key = 'site_title' LIMIT 1";
		$result = mysqli_query( $link, $query );
		while($row = mysqli_fetch_row($result)) {
			return $row[0];
		}
  }

}
?>

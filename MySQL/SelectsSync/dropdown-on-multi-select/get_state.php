<?php
require_once("DBController.php");
$db_handle = new DBController();
if(!empty($_GET['country_id'])) {
        $coun_id = $_GET["country_id"];           
	$query ="SELECT * FROM states WHERE countryID IN ($coun_id)";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select State</option>
<?php
	foreach($results as $state) {
?>
	<option value="<?php echo $state["id"]; ?>"><?php echo $state["name"]; ?></option>
<?php
	}
}
?>
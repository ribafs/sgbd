<?php
require_once ("DBController.php");
$db_handle = new DBController();
$query = "SELECT * FROM country";
$countryResult = $db_handle->runQuery($query);
?>
<html>
<head>
<TITLE>Dynamically Load Dependent Dropdown on Multi-Select using PHP and
    jQuery</TITLE>


<head>
<style>
body {
    width: 610px;
    font-family: calibri;
}

.frmDronpDown {
    border: 1px solid #7ddaff;
    background-color: #C8EEFD;
    margin: 2px 0px;
    padding: 40px;
    border-radius: 4px;
}

.demoInputBox {
    padding: 10px;
    border: #bdbdbd 1px solid;
    border-radius: 4px;
    background-color: #FFF;
    width: 50%;
}

.row {
    padding-bottom: 15px;
}
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"
    type="text/javascript"></script>
<script>
function getState() {
        var str='';
        var val=document.getElementById('country-list');
        for (i=0;i< val.length;i++) { 
            if(val[i].selected){
                str += val[i].value + ','; 
            }
        }         
        var str=str.slice(0,str.length -1);
        
	$.ajax({          
        	type: "GET",
        	url: "get_state.php",
        	data:'country_id='+str,
        	success: function(data){
        		$("#state-list").html(data);
        	}
	});
}
</script>
</head>
<body>
    <div class="frmDronpDown">
        <div class="row">
            <label>Country:</label><br /> <select name="country[]"
                id="country-list" class="demoInputBox"
                onChange="getState();" multiple size=4>
                <option value="">Select Country</option>
<?php
foreach ($countryResult as $country) {
    ?>
<option value="<?php echo $country["id"]; ?>"><?php echo $country["country_name"]; ?></option>
<?php
}
?>
</select>
        </div>
        <div class="row">
            <label>State:</label><br /> <select name="state[]"
                id="state-list" class="demoInputBox" multiple size=5>
                <option value="">Select State</option>
            </select>
        </div>
    </div>
</body>
</html>
<?php
include('config_company.php');
$result = array();
// $sql = "SELECT top(1) cl.company_name,cl.path_web FROM guest_info us
// left join company_list cl ON cl.id = us.id_company
// WHERE company_code = '{$_GET['code_company']}'";
$sql = "SELECT top(1) company_name,path_web FROM company_list 
WHERE company_code = '{$_GET['code_company']}'";
$stmt = sqlsrv_query($conn,$sql);  
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))    
{    
    $result[] = $row;
} 
sqlsrv_close($conn);
echo json_encode($result);


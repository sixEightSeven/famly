<?php

include('./helpers/famlyFunctions.php');
$serverName = 'localhost';
$username = 'root';
$password =  '';
$dbName = 'famly';
$memberId = $_GET['targetMemberId'];//$_SESSION['targetMemberId'];//101;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($serverName, $username, $password, $dbName);

if( $conn->connect_error ) {
    die("Connection Failed: ");
}

$query = " select 
    fm.famlyMemberId, fm.firstName, fm.lastName,
    fm3.firstName partnerFirstName, fm3.lastName partnerLastName,
    fu.famlyUnitId, fu.famlyUnitCode, fu.unitTypeCode, fu.parent1Id, fu.parent2Id, fu.unitStartDate, cc.childCount,
    fm2.dob, fm2.famlyMemberId, fm2.firstName childFirstName, fm2.lastName childLastName, fm2.sex childSex ";
$query .= "  from famlyMembers fm 
join famlyUnits fu 
    on (fu.parent1Id = ". $memberId ." or fu.parent2Id = ". $memberId ." ) 
left join famlyMembers fm2 
    on (fm2.famlyUnitId = fu.famlyUnitId ) 
join famlyMembers fm3 on
    (fm3.famlyMemberId = fu.parent1Id or fm3.famlyMemberId = fu.parent2Id)
join UnitChildCount cc on 
    ( cc.famlyUnitId = fm2.famlyUnitId and cc.famlyUnitId is not null ) ";
$query .= "  
where 
    fm.famlyMemberId = ". $memberId ." 
    and fm2.famlyMemberId <> ". $memberId ."
    and fm3.famlyMemberId <> ". $memberId ." ";
$query .= "  order by 
    fu.unitStartDate, fm2.dob; ";

$query2 = "
select 
    pm.famlyMemberId, pm.firstName, pm.lastName
    , sm.firstName partnerFirstName, sm.lastName partnerLastName
    , fu.famlyUnitId, fu.famlyUnitCode, fu.unitTypeCode, fu.parent1Id, fu.parent2Id, fu.unitStartDate, cc.childCount
    , fm.dob, fm.famlyMemberId, fm.firstName childFirstName, fm.lastName childLastName, fm.sex childSex 
from famlyUnits fu
left outer join famlyMembers fm 
    on (fm.famlyUnitId = fu.famlyUnitId )
left outer join famlyMembers pm 
    on (pm.famlyMemberId = ". $memberId .")
left outer join famlyMembers sm 
    on ((sm.famlyMemberId <> ". $memberId .") and (sm.famlyMemberId = fu.parent1Id or sm.famlyMemberId = fu.parent2Id))
join V_UnitChildCount cc
    on ( cc.unitId = fu.famlyUnitId)
where 
    fu.parent1id = ". $memberId ." or fu.parent2Id = ". $memberId ." 
order by 
    fu.unitStartDate, fm.dob;

";

$result = $conn->query($query2);

/* reverse traverse loop
for ($row_no = $result->num_rows -1; $row_no >= 0; $row_no--) {
    $result->data_seek($row_no);
    $row = $result->fetch_assoc();
    echo $row['firstName'];
}
*/

echo '
<!DOCTYPE html>
<html lang="en-US">
    <head>
    <title>FamTree - Member Units</title>
    <link rel="stylesheet" href="./assets/css/famlyStyles_Units.css">
    </head>
    <body>
        <table>
    ';

$rowNum = 0;
$previousPartner = "";
$childRow = 0;
$unitChildNdx   = 0;
$maxChildren = 12;
$tableColCount = 15;

foreach($result as $row){
    $rowNum++;
    $memberFirstName = $row['firstName'];
    $memberLastName  = $row['lastName'];
    $currentPartner  = $row['partnerFirstName'];
    //$unitChildNdx++;
    $unitCode       = $row['famlyUnitCode'];
    $unitChildCount = $row['childCount'];
    
    $childMemberId  = $row['famlyMemberId'];
    $childFirstName = $row['childFirstName'];
    $childLastName  = $row['childLastName'];
    $p2FirstName    = $row['partnerFirstName'];
    $p2LastName     = $row['partnerLastName'];
    $childSex       = $row['childSex'];
    $unitType       = $row['unitTypeCode'];

   
    if($rowNum == 1) 
    {
        $unitTableHead = CreateUnitTableHead($tableColCount, $memberFirstName, $memberLastName);
        echo $unitTableHead;
        $unitHeadRow = CreateUnitHeadRow($memberFirstName, $childSex, $tableColCount);
        echo $unitHeadRow;
    } 
    //echo 'child Index: '  /*.$unitChildNdx */    .'&nbsp;&nbsp;&nbsp; '.$childFirstName.'<br /> ';

    if($currentPartner <> $previousPartner){ 
        $newPartnerCard = CreatePartnerCard($unitType, $currentPartner);
        echo $newPartnerCard;

        echo GetUnitImage($unitChildCount);
        echo ShowChildLinks($unitChildCount, $maxChildren);
        echo '</tr> <tr>';
        $childRow = 1;
        $unitChildNdx = 0;
    }
    else{
        $unitChildNdx++;
    }
  
    echo ' 
    ';
    if($unitChildNdx == 0){
        echo '
        <td></td>
        <td></td>
        <td><img src="./images/unitImg_11.png" ></td>';
    }

    if($unitChildNdx < ($unitChildCount ))
    {
        $childCard = GetChildCard($childFirstName, $childMemberId, $childSex);
        echo $childCard;
    }
    else 
    {
        echo '<td></td>';
    }

    //if($currentPartner <> $previousPartner){
        if($unitChildNdx == ($unitChildCount -1)){
            //echo '</br>unitChildNdx:'.$unitChildNdx+1 . 'unitChildCount'.$unitChildCount. '&nbsp;addedCols: '. $tableColCount - ($unitChildCount + 3 ); 
            $padColString = '';
            $padColString .= GetPaddedCols($tableColCount - ($unitChildCount + 3 ));
            echo $padColString;
        //$unitChildNdx = 0;
    }

    $previousPartner = $currentPartner;
    //$unitChildNdx++;
}

echo '            </tbody>
</table>

</body>
</html>
';

$conn->close();
?>
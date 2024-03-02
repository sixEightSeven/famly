<?php
//
function ShowChildLinks($numberOfChildren, $maxCols){
    $linkString = '';
    $ndx = 0;
    
    if($numberOfChildren > 0){
        
        while( $ndx <  $numberOfChildren ) {

            if($ndx == ($numberOfChildren - 1)){
                $linkString .= '  <td><img src="./images/unitImg_09.png" > </td>';
            }
            else {
                $linkString .= '  <td><img src="./images/unitImg_08.png" > </td>';
            }

            $ndx++;
        }
    }

    while ($ndx < $maxCols)
    {
        $linkString .= '<td></td>';
        $ndx++;
    }
    return $linkString;
}

function CreateUnitTableHead($tableColCount, $memberFirstName, $memberLastName){
    $result = '';

    echo '
    <thead>
        <tr>
            <th>Family Units for: '.$memberFirstName.' '.$memberLastName.'</th>
        </tr>
    </thead>
    <tbody>';

    return $result;
}

function CreateUnitHeadRow($firstName, $sex, $maxTableCols){
    $result = '';

    $result = '
    <tr>
    <td></td>
    <td></td>
    <td class='; 
    
    if( $sex == 'M'){
        $result .= '"memMale"';
    } else if ($sex == 'F'){
        $result .= '"memFemale"';
    } else {
        $result .= '"memUnknownSex"';
    } 
    
    $result .= ' >';
    
    $result .=  $firstName.'</td>';
    $result .= GetPaddedCols($maxTableCols - 3);

    return $result;
}

function CreatePartnerCard ($unitType, $partnerName){
    $result = '';

    $result .= '
    </tr>
    <tr>
        <td></td>'.
    '   <td class=';
    
    if( $unitType == 'marriage')
    {
        $result .= '"memPartner-married"'.' >';
    }else {
        $result .= '"memPartner"'.' >';
    };
    $result .= $partnerName.'</td>';

    return $result;
}

function GetUnitImage($unitChildCount){
    $result = '';
            //unit image
            if($unitChildCount == 0){
                $result .= '  <td><img src="./images/unitImg_03.png" ></td>';
            } else {
                $result .= '  <td><img src="./images/unitImg_02.png" ></td>';
            }
 
    return $result;
}

function GetChildCard($firstName, $memberId, $sex){
    $result = '';
    $linkStringBegin = '<a href="memberUnitsDisplay.php?targetMemberId='.$memberId.'">';//'';//'<a href="memberUnitsDisplay.php?targetMemberId='.$memberId.'">';
    $linkStringEnd = '</a>';
    $result .= '<td  class=';
    if( $sex == 'M')
    {
        $result .= '"memMale"';
    } else if ($sex== 'F'){
        $result .='"memFemale"';
    } else {
        $result .='"memUnknownSex"';
    } 
    $result .=' >';
    $result .= $linkStringBegin.$firstName.$linkStringEnd.'</td>';

    return $result;
}

function GetPaddedCols($numOfCells){
    $cellString = '';

    for($cellNdx = 0; $cellNdx < $numOfCells; $cellNdx++){
        //$cellString .= '<td class="memPartner">Empty</td>';
        $cellString .= '<td></td>';
    }
   // echo $cellString;
   return $cellString;
}

function GetUserDisplayName($userName) {
    $result = '';

    $result = 'Michael You Fool';
    return $result;
}
?>
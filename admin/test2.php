<?php
//We've included ../Includes/FusionCharts.php and ../Includes/DBConn.php, which contains
//functions to help us easily embed the charts and connect to a database.
include("../Includes/FusionCharts.php");
include("../Includes/DBConn.php");
?>
<HTML>

<HEAD>
    <TITLE>FusionCharts - Database Example</TITLE>
    http://../../FusionCharts/FusionCharts.js
</HEAD>

<BODY>
    <CENTER>
        <?php
        //In this example, we show how to connect FusionCharts to a database.
        //For the sake of ease, we've used a MySQL database containing two
        //tables.
        //Connect to the DB
        $link = connectToDB();
        //$strXML will be used to store the entire XML document generated
        //Generate the chart element
        $strXML = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units'>";
        //Fetch all factory records
        $strQuery = "select * from Factory_Master";
        $result = mysql_query($strQuery) or die(mysql_error());
        //Iterate through each factory
        if ($result) {
            while ($ors = mysql_fetch_array($result)) {
                //Now create a second query to get details for this factory
                $strQuery = "select sum(Quantity) as TotOutput from Factory_Output where FactoryId=" . $ors['FactoryId'];
                $result2 = mysql_query($strQuery) or die(mysql_error());
                $ors2 = mysql_fetch_array($result2);
                //Generate <set label='..' value='..'/>
                $strXML .= "<set label='" . $ors['FactoryName'] . "' value='" . $ors2['TotOutput'] . "' />";
                //free the resultset
                mysql_free_result($result2);
            }
        }
        mysql_close($link);
        //Finally, close <chart> element
        $strXML .= "</chart>";
        //Create the chart - Pie 3D Chart with data from $strXML
        echo renderChart("../../FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 600, 300, false, true);
        ?>
</BODY>

</HTML>
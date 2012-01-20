<chart caption='Timeliness Per epiweek' lineThickness='1' showValues='0' formatNumberScale='0' anchorRadius='2'   bgColor="FFFFFF" divLineAlpha='20' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridAlpha='5' alternateHGridColor='CC3300' shadowAlpha='40' labelStep="2" numvdivlines='5' chartRightMargin="35" showBorder='0' animation='1' xAxisName='Epiweeks' yAxisName='Days Late'>
        <?php
        mysql_connect("localhost","root","");
        mysql_select_db("idsr");
        
        $sql_past_due = "select count(distinct(surveillance.datereportedby)) as datereported, surveillance.epiweek as epiweek from surveillance,deadlines where surveillance.epiweek = deadlines.epiweek and surveillance.datereportedby > deadlines.deadline group by deadlines.epiweek asc";        
        $sql_result_dues = mysql_query($sql_past_due) or die(mysql_error());
        
        $theabovedata = array();
        $counter = 0;
        
        while ($dataabove = mysql_fetch_array($sql_result_dues)) {
            $theabovedata[$counter][1] = $dataabove['epiweek'];
            $theabovedata[$counter][2] = $dataabove['datereported'];
            $counter++;
        }

        foreach ($theabovedata as $data) {
            ?>
            <set label='<?php echo $data[1]; ?>' value='<?php echo $data[2]; ?>' />

        <?php } ?>      
    
    <styles>
        <definition>
            <style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
            <style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
            <style name="DataShadow" type="Shadow" alpha="40"/>
        </definition>
        <application>
            <apply toObject="DIVLINES" styles="Anim1"/>
            <apply toObject="HGRID" styles="Anim2"/>
            <apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
        </application>
    </styles>
</chart>
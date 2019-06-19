<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'config.php';
        
        // Escape special charactars
        $_POST = array_map('mysql_real_escape_string',$_POST);

        $t_emanresu = $_POST['t_emanresu'];
        $t_emanhtap = $_POST['t_emanhtap'];
        $t_emanmoc_en = $_POST['t_emanmoc_en'];
        $t_emanmoc_jp = $_POST['t_emanmoc_jp'];
        $t_emanmoc_vn = $_POST['t_emanmoc_vn'];
        $t_tacmem = $_POST['t_tacmem'];
        $t_eimoc = $_POST['t_eimoc'];
        $t_sserddamoc_en = $_POST['t_sserddamoc_en'];
        $t_sserddamoc_jp = $_POST['t_sserddamoc_jp'];
        $t_sserddamoc_vn = $_POST['t_sserddamoc_vn'];
        $t_ecnivorpmoc = $_POST['t_ecnivorpmoc'];
        $t_yrtnuocmoc = $_POST['t_yrtnuocmoc'];
        $t_pizmoc = $_POST['t_pizmoc'];
        $t_letmoc = $_POST['t_letmoc'];
        $t_xafmoc = $_POST['t_xafmoc'];
        $t_tcatnoc_en = $_POST['t_tcatnoc_en'];
        $t_tcatnoc_jp = $_POST['t_tcatnoc_jp'];
        $t_tcatnoc_vn = $_POST['t_tcatnoc_vn'];
        $t_noitisop_en = $_POST['t_noitisop_en'];
        $t_noitisop_jp = $_POST['t_noitisop_jp'];
        $t_noitisop_vn = $_POST['t_noitisop_vn'];
        $t_redneg = $_POST['t_redneg'];
        $t_liam = $_POST['t_liam'];
        $t_let = $_POST['t_let'];
        $t_national = $_POST['t_national']; // National for sorting in category, added 2011.07.04, for VN only

        $t_password = "1112233444";

        $sql1 = "insert into flc_member (mem_pass, mem_comname_en, mem_comname_jp, mem_comname_vn, mem_category, mem_address1_en, mem_address1_jp, mem_address1_vn," .
                " mem_addressine1, mem_addressprv1, mem_addresscty1, mem_addresszip1, mem_comtel, mem_comfax, mem_contactname_en, mem_contactname_jp, mem_contactname_vn," .
                " mem_contactposition_en, mem_contactposition_jp, mem_contactposition_vn, mem_contactgender, mem_contactmail, mem_contacttel, mem_template, mem_registdate, mem_registip, mem_national)" .
                " values ('$t_password', '$t_emanmoc_en', '$t_emanmoc_jp', '$t_emanmoc_vn', '$t_tacmem', '$t_sserddamoc_en', '$t_sserddamoc_jp', '$t_sserddamoc_vn'," .
                " '$t_eimoc', '$t_ecnivorpmoc', '$t_yrtnuocmoc', '$t_pizmoc', '$t_letmoc', '$t_xafmoc', '$t_tcatnoc_en', '$t_tcatnoc_jp', '$t_tcatnoc_vn', '$t_noitisop_en', '$t_noitisop_jp', '$t_noitisop_vn'," .
                " '$t_redneg', '$t_liam', '$t_let', '001', '$nowdate', '$getip', '$t_national')";
        @mysql_query($sql1);
        echo $sql1;
        echo "<br /><br /><br />";
        ?>
    </body>
</html>

<?php
    ini_set("session.gc_maxlifetime", "18000");
    session_start();
    
    if ($_SESSION['vp'] != 'exe') {
        echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">";
        exit();
    }
    
    include_once("./include/class.rFastTemplate.php");
    include_once("./include/global_config.php");
    include_once("./include/global_function.php");
    
    $url1 = "adm_structure.html";
    $url2 = "adm_news_add.html";
    
    $tpl = new rFastTemplate("template");
    $tpl->define(
        array(
            "main_tpl" => $url1,
            "detail_tpl" => $url2
        )
    );
    
    mysql_query("use $db_name;");
    
    // --- Global Template Section
    include_once("./include/global_admvalue.php");
    
    // --- Check Use Log
    
    $currentuserid = $_SESSION['vd'];
    
    $sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';";
    $resultusl1 = mysql_query($sqlusl1);
    
    // --------------------
    
    if ($_COOKIE['vlang'] == 'en') {
        $sql1 = "select * from flc_news_genre order by nwg_name_en asc;";
    } elseif ($_COOKIE['vlang'] == 'vn') {
        $sql1 = "select * from flc_news_genre order by nwg_name_vn asc;";
    } else {
        $sql1 = "select * from flc_news_genre order by nwg_name_jp asc;";
    }

    $result1 = mysql_query($sql1);
    while ($dbarr1 = mysql_fetch_array($result1)) {
        if ($_COOKIE['vlang'] == 'en') {
            $nwgname = $dbarr1['nwg_name_en'];
        } elseif ($_COOKIE['vlang'] == 'vn') {
            $nwgname = $dbarr1['nwg_name_vn'];
        } else {
            $nwgname = $dbarr1['nwg_name_jp'];
        }

        $nwgid = $dbarr1['nwg_id'];
        
        $tpl->assign("##nwgid##", $nwgid);
        $tpl->assign("##nwgname##", $nwgname);
        $tpl->parse("#####ROW#####", '.rows_nwg');
    }
    
    if ($_COOKIE['vlang'] == 'en') {
        $sql2 = "select * from flc_news_editor order by nwe_name_en asc;";
    } elseif ($_COOKIE['vlang'] == 'vn') {
        $sql2 = "select * from flc_news_editor order by nwe_name_vn asc;";
    } else {
        $sql2 = "select * from flc_news_editor order by nwe_name_jp asc;";
    }

    $result2 = mysql_query($sql2);
    while ($dbarr2 = mysql_fetch_array($result2)) {
        if ($_COOKIE['vlang'] == 'en') {
            $nwename = $dbarr2['nwe_name_en'];
        } elseif ($_COOKIE['vlang'] == 'vn') {
            $nwename = $dbarr2['nwe_name_vn'];
        } else {
            $nwename = $dbarr2['nwe_name_jp'];
        }

        $nweid = $dbarr2['nwe_id'];
        
        $tpl->assign("##nweid##", $nweid);
        $tpl->assign("##nwename##", $nwename);
        $tpl->parse("#####ROW#####", '.rows_nwe');
    }
    
    $sday = selectday("");
    $smonth = selectmonth("");
    $syear = date("Y");
    
    $tpl->assign("##admid##", $_SESSION['vd']);
    $tpl->assign("##sday##", $sday);
    $tpl->assign("##smonth##", $smonth);
    $tpl->assign("##syear##", $syear);
    
    $tpl->parse("##DETAIL_AREA##", "detail_tpl");
    $tpl->parse("MAIN", "main_tpl");
    $tpl->FastPrint();
    exit();
?>
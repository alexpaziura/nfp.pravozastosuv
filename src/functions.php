<?php

function get_table_inspect()
{
    global $link;
    if (!mysqli_ping($link))
    {
        echo "Error: ". mysqli_error($link);
        exit();
    }
    else
    {
    $sql = "SELECT id_inspekt, active, date_change, username, nzp, pidrozdil, short_name_fu, edrpo, type_fu, name_type_fu, 
              name_vid_perevirki, pidstava_pozaplan, d_start_perevirki, 
              d_end_perevirki, d_start_dialnist, d_end_dialnist, d_nak_zah, n_nak_zah, d_napr_proved, n_napr_proved,
              ker_inspekt_group, ch_inspekt_group,
              d_akt_perevirki, n_akt_perevirki, d_akt_zu, n_akt_zu, vid_akt_zu, name_akt_zu, d_rozp_usun, n_rozp_usun, 
              strok_usun_por, b_usun_lic_umov, name_info_vik, d_dovidki_vik_rozp, dn_akt_nevik, d_post_shtraf,
              n_post_shtraf, suma_shtraf, strok_splat_shtraf, info_splat_shtraf, info_usun_por, d_dovidki_vik_post,
              dn_sluj_ur, sluj_perep_splat, dn_doc_splat, dn_sluj_nap_mat, name_sud_dn_roz, n_sud_sprav,
              d_sud_rish, d_sud_rish_roz, short_zm_rish, name_apel_sud, n_sprav_apel, d_srish_apel, d_res_srish_apel,
              short_zm_rish_apel, dn_kasac_scar, n_sprav_kasac, d_rish_kasac, d_rish_res_kasac, short_zm_rish_kasac,
              primitka_sud_ros, splach_sud_zbir, poklad_sud_zbir, povern_sud_zbir, dn_list_dobro_splat, 
              shtraf_slpach_dobro, dn_sluj_primus, dn_lz_vikon_list, dn_otrum_vikon_list, dn_napr_list_dvs, 
              dn_rekv_otk_vp, short_opis_zah_dvs, dn_rekv_zak_vp, primitka_dod, napr_zap_derjrei, napr_zap_dfs,
              napr_zai_police, napr_info_bank, napr_info_zasn, napr_info_prokuror, napr_info_oms, napr_info_dfs
              FROM inspekt, dic_type_fu, users, dic_vid_perevirki, dic_info_vik, dic_akt_zu
              WHERE type_fu=id_type_fu AND user=id_user AND vid_perevirki=id_vid_perevirki
              AND info_vik_rozp=id_info_vik AND vid_akt_zu=id_akt_zu
              ORDER BY nzp";


    $result = mysqli_query($link, $sql);
    $table_inspekt = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
    return $table_inspekt;

    }
}
function get_row_inspect($id) {
    global $link;
    if (!mysqli_ping($link))
    {
        echo "Error: ". mysqli_error($link);
        exit();
    }
    else
    {
        $sql = "SELECT id_inspekt, type_fu, vid_perevirki, pidstava_pozaplan, vid_akt_zu, info_vik_rozp
              FROM inspekt, dic_type_fu, users, dic_vid_perevirki, dic_info_vik, dic_akt_zu
              WHERE type_fu=id_type_fu AND vid_perevirki=id_vid_perevirki
              AND info_vik_rozp=id_info_vik AND vid_akt_zu=id_akt_zu AND id_inspekt=$id AND inspekt.active=1
              ORDER BY nzp";
        $rowS = '';
        if ($result=mysqli_query($link,$sql))
        {
            $row=mysqli_fetch_assoc($result);
            $rowS = json_encode($row, JSON_UNESCAPED_UNICODE);

            mysqli_free_result($result);
        }
        return $rowS;

    }
}
function get_user()
{
    global $link;
    global $username;
    global $pwd;

    $sql = "SELECT * FROM users";
    $result = mysqli_query($link, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $exist = false;
    foreach ($users as $row) {
        if ((strcmp($row['username'], $username) == 0) && (strcasecmp($row['pwd'], md5($pwd)) == 0)) {
            session_start();
            if ($row['active_user']==1) {
                $exist = true;
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['user'] = $row['username'];
                $_SESSION['group'] = $row['memberof'];
                $_SESSION['full_name'] = $row['full_name'];
                if (strcmp('ДеРЗІТ', $row['memberof']) == 0) {
                    mysqli_change_user($link, 'pravadmin', "!AD_dfp?2004_1", "pravozastosuv");
                }
            }
            break;
        }
    }

    return $exist;
}
function isUserActive() {
    global $link;
    if (!mysqli_ping($link))
    {
        echo "Error: ". mysqli_error($link);
        exit();
    }
    $isActive = false;
    $sql = "SELECT active_user FROM users WHERE id_user=" . $_SESSION['id_user'];
    if ($result=mysqli_query($link,$sql))
    {
        while ($row=mysqli_fetch_row($result))
        {
            if ($row[0] == 1) {
               $isActive = true;
            }
        }
        mysqli_free_result($result);
    }
    return $isActive;
}

function get_dics() {
    global $link;
    if (!mysqli_ping($link))
    {
        echo "Error: ". mysqli_error($link);
        exit();
    }

    $sql = "SELECT * FROM dic_type_fu WHERE visible=1;";
    $sql .= "SELECT * FROM dic_vid_perevirki WHERE visible=1;";
    $sql .= "SELECT * FROM dic_pidstava_pozaplan WHERE visible=1;";
    $sql .= "SELECT * FROM dic_akt_zu WHERE visible=1";

    $dics = array();
    if (mysqli_multi_query($link, $sql)) {
        do {
            if ($result = mysqli_store_result($link)) {
                $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                array_push($dics, $row);
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($link));
    }
    return $dics;

}

function get_dic($dic){
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: ". mysqli_error($link);
        exit();
    }

    $sql = "SELECT * FROM ".$dic;


    $result = mysqli_query($link, $sql);

    $table_type_fu = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $table_type_fu;

}

function add_inspekt() {
    if(!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: ". mysqli_error($link);
        exit();
    }
    $index_pidrozdil = 0;
    switch ($_SESSION['group']) {
        case "ДеРЗІТ":
            $index_pidrozdil = 10;
            break;
        case "НПЗ":
            $index_pidrozdil = 13;
            break;
        case "ЮР":
            $index_pidrozdil = 11;
            break;
        case "СК":
            $index_pidrozdil = 13;
            break;
        case "ФК":
            $index_pidrozdil = 16;
            break;
        case "КС":
            $index_pidrozdil = 15;
            break;
        case "РРФП":
            $index_pidrozdil = 17;
            break;
    }
    $nzp = trim(htmlspecialchars($_POST['nzp'], ENT_QUOTES));
    $active = 1;
    $date_change = strtotime(date('d.m.Y H:i:s'));
    $user = $_SESSION['id_user'];
    $short_name_fu = "'" . trim(htmlspecialchars($_POST['short_name_fu'], ENT_QUOTES)) . "'";
    $edrpo = "'" .trim(htmlspecialchars($_POST['edrpoE'])). "'";
    $type_fo = htmlspecialchars($_POST['type_fo']);
    $vid_perevirki = htmlspecialchars($_POST['vid_perevirkiS']);
    $pidstava_pozaplanS = 'NULL';
    if(isset($_POST['pidstava_pozaplanS'])) {
        $pidstavi = $_POST['pidstava_pozaplanS'];
        $pidstava_pozaplanS = "'";
        foreach ($pidstavi as $value) {
            $pidstava_pozaplanS = $pidstava_pozaplanS.$value."; ";
        }
        $pidstava_pozaplanS = $pidstava_pozaplanS."'";
    }
    $d_start_perevirki = $_POST['d_start_perevirki'] != '' ? strtotime($_POST['d_start_perevirki']) : 'NULL';
    $d_end_perevirki = $_POST['d_end_perevirki'] != '' ? strtotime($_POST['d_end_perevirki']) : 'NULL';
    $d_start_dialnist = $_POST['d_start_dialnist'] != '' ? strtotime($_POST['d_start_dialnist']) : 'NULL';
    $d_end_dialnist = $_POST['d_end_dialnist'] != '' ? strtotime($_POST['d_end_dialnist']) : 'NULL';
    $d_nak_zah = $_POST['d_nak_zah'] != '' ? strtotime($_POST['d_nak_zah']) : 'NULL';
    $n_nak_zah = $_POST['n_nak_zah'] != '' ? "'".trim(htmlspecialchars($_POST['n_nak_zah']))."'" : 'NULL';
    $d_napr_proved = $_POST['d_napr_proved'] != '' ? strtotime($_POST['d_napr_proved']) : 'NULL';
    $n_napr_proved = $_POST['n_napr_proved'] != '' ? "'".trim(htmlspecialchars($_POST['n_napr_proved']))."'" : 'NULL';
    $ker_inspekt_group = $_POST['ker_inspekt_group'] != '' ? "'".trim(htmlspecialchars($_POST['ker_inspekt_group'], ENT_QUOTES))."'" : 'NULL';
    $ch_inspekt_group = $_POST['ch_inspekt_group'] != '' ? "'".trim(htmlspecialchars($_POST['ch_inspekt_group'], ENT_QUOTES))."'" : 'NULL';
    $d_akt_perevirki = $_POST['d_akt_perevirki'] != '' ? strtotime($_POST['d_akt_perevirki']) : 'NULL';
    $n_akt_perevirki = $_POST['n_akt_perevirki'] != '' ? trim(htmlspecialchars($_POST['n_akt_perevirki'])) : 'NULL';
    $d_akt_zu = $_POST['d_akt_zu'] != '' ? strtotime($_POST['d_akt_zu']) : 'NULL';
    $n_akt_zu = $_POST['n_akt_zu'] != '' ? "'".trim(htmlspecialchars($_POST['n_akt_zu']))."'" : 'NULL';
    $vid_akt_zu = htmlspecialchars($_POST['vid_akt_zu']);
    $d_rozp_usun = $_POST['d_rozp_usun'] != '' ? strtotime($_POST['d_rozp_usun']) : 'NULL';
    $n_rozp_usun = $_POST['n_rozp_usun'] != '' ? "'".htmlspecialchars($_POST['n_rozp_usun'])."'" : 'NULL';
    $strok_usun_por = $_POST['strok_usun_por'] != '' ? "'".trim(htmlspecialchars($_POST['strok_usun_por']))."'" : 'NULL';
    $b_usun_lic_umov = $_POST['b_usun_lic_umov'] == '' ? 'NULL' : htmlspecialchars($_POST['b_usun_lic_umov']);
    $info_vik_rozp = htmlspecialchars($_POST['info_vik_rozp']);
    $d_dovidki_vik_rozp = $_POST['d_dovidki_vik_rozp'] != '' ? strtotime($_POST['d_dovidki_vik_rozp']) : 'NULL';
    $dn_akt_nevik = "'".$_POST['d_akt_nevik'].' '.trim(htmlspecialchars($_POST['n_akt_nevik']))."'";
    $d_post_shtraf = $_POST['d_post_shtraf'] != '' ? strtotime($_POST['d_post_shtraf']) : 'NULL';
    $n_post_shtraf = $_POST['n_post_shtraf'] != '' ? "'".htmlspecialchars($_POST['n_post_shtraf'])."'" : 'NULL';
    $suma_shtraf = $_POST['suma_shtraf'] != '' ? trim(htmlspecialchars($_POST['suma_shtraf'])) : 'NULL';
    $strok_splat_shtraf = $_POST['strok_splat_shtraf'] != '' ? strtotime($_POST['strok_splat_shtraf']) : 'NULL';
    $info_splat_shtraf = $_POST['info_splat_shtraf'] != '' ? strtotime($_POST['info_splat_shtraf']) : 'NULL';
    $info_usun_por = $_POST['info_usun_por'] != '' ? "'".trim(htmlspecialchars($_POST['info_usun_por']))."'" : 'NULL';
    $d_dovidki_vik_post = $_POST['d_dovidki_vik_post'] != '' ? strtotime($_POST['d_dovidki_vik_post']) : 'NULL';
    $dn_sluj_ur = "'".$_POST['d_sluj_ur'].' '.trim(htmlspecialchars($_POST['n_sluj_ur']))."'";
    $sluj_perep_splat = $_POST['sluj_perep_splat'] != '' ? "'".trim(htmlspecialchars($_POST['sluj_perep_splat']))."'" : 'NULL';
    $dn_doc_splat = "'".$_POST['d_doc_splat'].' '.trim(htmlspecialchars($_POST['n_doc_splat']))."'";
    $dn_sluj_nap_mat = "'".$_POST['d_sluj_nap_mat'].' '.trim(htmlspecialchars($_POST['n_sluj_nap_mat']))."'";


    $sql = "INSERT INTO inspekt (active, date_change, user, nzp, pidrozdil, short_name_fu, edrpo, type_fu, vid_perevirki, pidstava_pozaplan,
            d_start_perevirki, d_end_perevirki, d_start_dialnist, d_end_dialnist, d_nak_zah, n_nak_zah,
            d_napr_proved, n_napr_proved, ker_inspekt_group, ch_inspekt_group, d_akt_perevirki,
            n_akt_perevirki, d_akt_zu, n_akt_zu, vid_akt_zu, d_rozp_usun, n_rozp_usun, strok_usun_por,
            b_usun_lic_umov, info_vik_rozp, d_dovidki_vik_rozp, dn_akt_nevik, d_post_shtraf, n_post_shtraf, suma_shtraf,
            strok_splat_shtraf, info_splat_shtraf, info_usun_por, d_dovidki_vik_post, dn_sluj_ur, sluj_perep_splat, 
            dn_doc_splat, dn_sluj_nap_mat) 
            VALUES ($active, $date_change, $user, $nzp, $index_pidrozdil, $short_name_fu,$edrpo,$type_fo,$vid_perevirki,$pidstava_pozaplanS,
            $d_start_perevirki, $d_end_perevirki, $d_start_dialnist, $d_end_dialnist, $d_nak_zah, $n_nak_zah,
            $d_napr_proved, $n_napr_proved, $ker_inspekt_group, $ch_inspekt_group, $d_akt_perevirki,
            $n_akt_perevirki, $d_akt_zu, $n_akt_zu, $vid_akt_zu, $d_rozp_usun, $n_rozp_usun, $strok_usun_por,
            $b_usun_lic_umov, $info_vik_rozp, $d_dovidki_vik_rozp, $dn_akt_nevik, $d_post_shtraf, $n_post_shtraf,
            $suma_shtraf, $strok_splat_shtraf, $info_splat_shtraf, $info_usun_por, $d_dovidki_vik_post, $dn_sluj_ur,
            $sluj_perep_splat, $dn_doc_splat, $dn_sluj_nap_mat)";
    $result = mysqli_query($link, $sql);

    if ($result) {
        return true;
    } else {
        $logs = fopen("logs.txt", "w") or die("Unable to open file!");
        $txt = "Error: " . $sql . "\n" . mysqli_error($link);
        fwrite($logs, $txt);
        fclose($logs);
        return false;
    }

}

function edit_nag () {
    if(!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: ". mysqli_error($link);
        exit();
    }

}

<?php

function full_trim($str)
{
    return trim(preg_replace('/\s{2,}/', ' ', $str));

}

function get_table_inspect()
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    } else {
        $sql = "SELECT id_inspekt, active, date_change, username, nzp, pidrozdil, short_name_fu, edrpo, type_fu, name_type_fu, 
              vid_perevirki, name_vid_perevirki, pidstava_pozaplan, d_start_perevirki, 
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

function get_row_inspect($id)
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    } else {
        $sql = "SELECT id_inspekt, type_fu, vid_perevirki, pidstava_pozaplan, vid_akt_zu, info_vik_rozp
              FROM inspekt, dic_type_fu, users, dic_vid_perevirki, dic_info_vik, dic_akt_zu
              WHERE type_fu=id_type_fu AND vid_perevirki=id_vid_perevirki
              AND info_vik_rozp=id_info_vik AND vid_akt_zu=id_akt_zu AND id_inspekt=$id AND inspekt.active=1
              ORDER BY nzp";
        $rowS = '';
        if ($result = mysqli_query($link, $sql)) {
            $row = mysqli_fetch_assoc($result);
            $rowS = json_encode($row, JSON_UNESCAPED_UNICODE);

            mysqli_free_result($result);
        }
        return $rowS;

    }
}

function add_inspekt()
{
    if (!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
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
    $nzp = full_trim(htmlspecialchars($_POST['nzp'], ENT_QUOTES));
    $active = 1;
    $date_change = strtotime(date('d.m.Y H:i:s'));
    $user = $_SESSION['id_user'];
    $short_name_fu = "'" . full_trim(htmlspecialchars($_POST['short_name_fu'], ENT_QUOTES)) . "'";
    $edrpo = "'" . full_trim(htmlspecialchars($_POST['edrpoE'])) . "'";
    $type_fo = htmlspecialchars($_POST['type_fo']);
    $vid_perevirki = $_POST['vid_perevirkiS'] != '' ? htmlspecialchars($_POST['vid_perevirkiS']) : 1;
    $pidstava_pozaplanS = 'NULL';
    if (isset($_POST['pidstava_pozaplanS'])) {
        $pidstavi = $_POST['pidstava_pozaplanS'];
        $pidstava_pozaplanS = "'";
        foreach ($pidstavi as $value) {
            $pidstava_pozaplanS = $pidstava_pozaplanS . $value . "; ";
        }
        $pidstava_pozaplanS = $pidstava_pozaplanS . "'";
    }
    $d_start_perevirki = $_POST['d_start_perevirki'] != '' ? strtotime($_POST['d_start_perevirki']) : 'NULL';
    $d_end_perevirki = $_POST['d_end_perevirki'] != '' ? strtotime($_POST['d_end_perevirki']) : 'NULL';
    $d_start_dialnist = $_POST['d_start_dialnist'] != '' ? strtotime($_POST['d_start_dialnist']) : 'NULL';
    $d_end_dialnist = $_POST['d_end_dialnist'] != '' ? strtotime($_POST['d_end_dialnist']) : 'NULL';
    $d_nak_zah = $_POST['d_nak_zah'] != '' ? strtotime($_POST['d_nak_zah']) : 'NULL';
    $n_nak_zah = $_POST['n_nak_zah'] != '' ? "'№" . full_trim(htmlspecialchars($_POST['n_nak_zah'], ENT_QUOTES)) . "'" : 'NULL';
    $d_napr_proved = $_POST['d_napr_proved'] != '' ? strtotime($_POST['d_napr_proved']) : 'NULL';
    $n_napr_proved = $_POST['n_napr_proved'] != '' ? "'№" . full_trim(htmlspecialchars($_POST['n_napr_proved'], ENT_QUOTES)) . "'" : 'NULL';
    $ker_inspekt_group = $_POST['ker_inspekt_group'] != '' ? "'" . full_trim(htmlspecialchars($_POST['ker_inspekt_group'], ENT_QUOTES)) . "'" : 'NULL';
    $ch_inspekt_group = $_POST['ch_inspekt_group'] != '' ? "'" . full_trim(htmlspecialchars($_POST['ch_inspekt_group'], ENT_QUOTES)) . "'" : 'NULL';
    $d_akt_perevirki = $_POST['d_akt_perevirki'] != '' ? strtotime($_POST['d_akt_perevirki']) : 'NULL';
    $n_akt_perevirki = $_POST['n_akt_perevirki'] != '' ? "'№" .full_trim(htmlspecialchars($_POST['n_akt_perevirki'], ENT_QUOTES)). "'" : 'NULL';
    $d_akt_zu = $_POST['d_akt_zu'] != '' ? strtotime($_POST['d_akt_zu']) : 'NULL';
    $n_akt_zu = $_POST['n_akt_zu'] != '' ? "'" . "'№" .full_trim(htmlspecialchars($_POST['n_akt_zu'], ENT_QUOTES)) . "'" : 'NULL';
    $vid_akt_zu = $_POST['vid_akt_zu'] != '' ? htmlspecialchars($_POST['vid_akt_zu']) : 1;
    $d_rozp_usun = $_POST['d_rozp_usun'] != '' ? strtotime($_POST['d_rozp_usun']) : 'NULL';
    $n_rozp_usun = $_POST['n_rozp_usun'] != '' ? "'№" . full_trim(htmlspecialchars($_POST['n_rozp_usun'], ENT_QUOTES)) . "'" : 'NULL';
    $strok_usun_por = $_POST['strok_usun_por'] != '' ? "'" . full_trim(htmlspecialchars($_POST['strok_usun_por'], ENT_QUOTES)) . "'" : 'NULL';
    $b_usun_lic_umov = $_POST['b_usun_lic_umov'] == '' ? 'NULL' : htmlspecialchars($_POST['b_usun_lic_umov']);
    $info_vik_rozp = $_POST['info_vik_rozp'] != '' ? htmlspecialchars($_POST['info_vik_rozp']) : 1;
    $d_dovidki_vik_rozp = $_POST['d_dovidki_vik_rozp'] != '' ? strtotime($_POST['d_dovidki_vik_rozp']) : 'NULL';
    $dn_akt_nevik = "'" . $_POST['d_akt_nevik'];
    if(full_trim(htmlspecialchars($_POST['n_akt_nevik'], ENT_QUOTES)) != '') {
        $dn_akt_nevik .= ' №' . full_trim(htmlspecialchars($_POST['n_akt_nevik'], ENT_QUOTES));
    }
    $dn_akt_nevik .= "'";
    $d_post_shtraf = $_POST['d_post_shtraf'] != '' ? strtotime($_POST['d_post_shtraf']) : 'NULL';
    $n_post_shtraf = $_POST['n_post_shtraf'] != '' ? "'№" . full_trim(htmlspecialchars($_POST['n_post_shtraf'], ENT_QUOTES)) . "'" : 'NULL';
    $suma_shtraf = $_POST['suma_shtraf'] != '' ? full_trim(htmlspecialchars($_POST['suma_shtraf'], ENT_QUOTES))." грн." : 'NULL';
    $strok_splat_shtraf = $_POST['strok_splat_shtraf'] != '' ? strtotime($_POST['strok_splat_shtraf']) : 'NULL';
    $info_splat_shtraf = $_POST['info_splat_shtraf'] != '' ? strtotime($_POST['info_splat_shtraf']) : 'NULL';
    $info_usun_por = $_POST['info_usun_por'] != '' ? "'" . full_trim(htmlspecialchars($_POST['info_usun_por'], ENT_QUOTES)) . "'" : 'NULL';
    $d_dovidki_vik_post = $_POST['d_dovidki_vik_post'] != '' ? strtotime($_POST['d_dovidki_vik_post']) : 'NULL';
    $dn_sluj_ur = "'" . $_POST['d_sluj_ur'] . ' ' . full_trim(htmlspecialchars($_POST['n_sluj_ur'], ENT_QUOTES)) . "'";
    $sluj_perep_splat = $_POST['sluj_perep_splat'] != '' ? "'" . full_trim(htmlspecialchars($_POST['sluj_perep_splat'], ENT_QUOTES)) . "'" : 'NULL';
    $dn_doc_splat = "'" . $_POST['d_doc_splat'];
    if(full_trim(htmlspecialchars($_POST['n_doc_splat'], ENT_QUOTES)) != '') {
        $dn_doc_splat .= ' №' . full_trim(htmlspecialchars($_POST['n_doc_splat'], ENT_QUOTES));
    }
    $dn_doc_splat.= "'";
    $dn_sluj_nap_mat = "'" . $_POST['d_sluj_nap_mat'];
    if(full_trim(htmlspecialchars($_POST['n_doc_splat'], ENT_QUOTES)) != '') {
        $dn_sluj_nap_mat .= ' №' . full_trim(htmlspecialchars($_POST['n_sluj_nap_mat'], ENT_QUOTES));
    }
    $dn_sluj_nap_mat .= "'";
    $povern_sud_zbir = "'";
    if(full_trim(htmlspecialchars($_POST['n_povern_sud_zbir'],ENT_QUOTES)) !='') {
        $povern_sud_zbir .= "№" . full_trim(htmlspecialchars($_POST['n_povern_sud_zbir'],ENT_QUOTES));
    }
    if($_POST['d_povern_sud_zbir'] !='') {
        $povern_sud_zbir .= " " . $_POST['d_povern_sud_zbir'];
    }
    if(full_trim(htmlspecialchars($_POST['s_povern_sud_zbir'],ENT_QUOTES)) !='') {
        $povern_sud_zbir .= " " . full_trim(htmlspecialchars($_POST['s_povern_sud_zbir'],ENT_QUOTES))." грн.";
    }
    $povern_sud_zbir .= "'";
    $dn_list_dobro_splat = "'" . $_POST['d_list_dobro_splat'];
    if(full_trim(htmlspecialchars($_POST['n_list_dobro_splat'], ENT_QUOTES)) !='') {
        $dn_list_dobro_splat .= ' №' . full_trim(htmlspecialchars($_POST['n_list_dobro_splat'], ENT_QUOTES));
    }
    $dn_list_dobro_splat .= "'";
    $shtraf_slpach_dobro = "'";
    if(full_trim(htmlspecialchars($_POST['n_shtraf_splach_dobro'],ENT_QUOTES)) !='') {
        $shtraf_slpach_dobro .= "№" . full_trim(htmlspecialchars($_POST['n_shtraf_splach_dobro'],ENT_QUOTES));
    }
    if($_POST['d_shtraf_splach_dobro'] !='') {
        $shtraf_slpach_dobro .= " " . $_POST['d_shtraf_splach_dobro'];
    }
    if(full_trim(htmlspecialchars($_POST['s_shtraf_splach_dobro'],ENT_QUOTES)) !='') {
        $shtraf_slpach_dobro .= " " . full_trim(htmlspecialchars($_POST['s_shtraf_splach_dobro'],ENT_QUOTES))." грн.";
    }
    $shtraf_slpach_dobro .= "'";

    $dn_sluj_primus = "'" . $_POST['d_sluj_primus'];
    if(full_trim(htmlspecialchars($_POST['n_sluj_primus'], ENT_QUOTES)) !='') {
        $dn_sluj_primus .= ' №' . full_trim(htmlspecialchars($_POST['n_sluj_primus'], ENT_QUOTES));
    }
    $dn_sluj_primus .= "'";
    $napr_zap_derjrei = $_POST['napr_zap_derjrei'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_zap_derjrei'], ENT_QUOTES)) . "'" : 'NULL';
    $napr_zap_dfs = $_POST['napr_zap_dfs'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_zap_dfs'], ENT_QUOTES)) . "'" : 'NULL';
    $napr_zai_police = $_POST['napr_zai_police'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_zai_police'], ENT_QUOTES)) . "'" : 'NULL';
    $napr_info_bank = $_POST['napr_info_bank'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_info_bank'], ENT_QUOTES)) . "'" : 'NULL';
    $napr_info_zasn = $_POST['napr_info_zasn'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_info_zasn'], ENT_QUOTES)) . "'" : 'NULL';
    $napr_info_prokuror = $_POST['napr_info_prokuror'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_info_prokuror'], ENT_QUOTES)) . "'" : 'NULL';
    $napr_info_oms = $_POST['napr_info_oms'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_info_oms'], ENT_QUOTES)) . "'" : 'NULL';
    $napr_info_dfs = $_POST['napr_info_dfs'] != '' ? "'" . full_trim(htmlspecialchars($_POST['napr_info_dfs'], ENT_QUOTES)) . "'" : 'NULL';


    $sql = "INSERT INTO inspekt (active, date_change, user, nzp, pidrozdil, short_name_fu, edrpo, type_fu, vid_perevirki, pidstava_pozaplan,
            d_start_perevirki, d_end_perevirki, d_start_dialnist, d_end_dialnist, d_nak_zah, n_nak_zah,
            d_napr_proved, n_napr_proved, ker_inspekt_group, ch_inspekt_group, d_akt_perevirki,
            n_akt_perevirki, d_akt_zu, n_akt_zu, vid_akt_zu, d_rozp_usun, n_rozp_usun, strok_usun_por,
            b_usun_lic_umov, info_vik_rozp, d_dovidki_vik_rozp, dn_akt_nevik, d_post_shtraf, n_post_shtraf, suma_shtraf,
            strok_splat_shtraf, info_splat_shtraf, info_usun_por, d_dovidki_vik_post, dn_sluj_ur, sluj_perep_splat, 
            dn_doc_splat, dn_sluj_nap_mat, povern_sud_zbir, dn_list_dobro_splat, shtraf_slpach_dobro, dn_sluj_primus, 
            napr_zap_derjrei, napr_zap_dfs, napr_zai_police, napr_info_bank, napr_info_zasn, napr_info_prokuror,
            napr_info_oms, napr_info_dfs) 
            VALUES ($active, $date_change, $user, $nzp, $index_pidrozdil, $short_name_fu,$edrpo,$type_fo,$vid_perevirki,$pidstava_pozaplanS,
            $d_start_perevirki, $d_end_perevirki, $d_start_dialnist, $d_end_dialnist, $d_nak_zah, $n_nak_zah,
            $d_napr_proved, $n_napr_proved, $ker_inspekt_group, $ch_inspekt_group, $d_akt_perevirki,
            $n_akt_perevirki, $d_akt_zu, $n_akt_zu, $vid_akt_zu, $d_rozp_usun, $n_rozp_usun, $strok_usun_por,
            $b_usun_lic_umov, $info_vik_rozp, $d_dovidki_vik_rozp, $dn_akt_nevik, $d_post_shtraf, $n_post_shtraf,
            $suma_shtraf, $strok_splat_shtraf, $info_splat_shtraf, $info_usun_por, $d_dovidki_vik_post, $dn_sluj_ur,
            $sluj_perep_splat, $dn_doc_splat, $dn_sluj_nap_mat, $povern_sud_zbir, $dn_list_dobro_splat, 
            $shtraf_slpach_dobro, $dn_sluj_primus, $napr_zap_derjrei, $napr_zap_dfs, $napr_zai_police, $napr_info_bank,
            $napr_info_zasn, $napr_info_prokuror, $napr_info_oms, $napr_info_dfs)";
    $result = mysqli_query($link, $sql);

    if ($result) {
        writeLog('QUERY', $sql, 1);
        return true;
    } else {
        writeLog('QUERY', $sql, 0);
        $logs = fopen("logs.txt", "w") or die("Unable to open file!");
        $txt = "Error: " . $sql . "\n" . mysqli_error($link);
        fwrite($logs, $txt);
        fclose($logs);
        return false;
    }

}

function edit_nag()
{
    if (!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }
    $sql = "SELECT * FROM inspekt WHERE id_inspekt=" . $_POST['id_inspekt'] . ";";
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
        $old_val = $row;
        unset($row);
        mysqli_free_result($result);
    } else {
        return false;
    }
    $new_val = array();
    $new_val['pidrozdil'] = 0;
    switch ($_SESSION['group']) {
        case "ДеРЗІТ":
            $new_val['pidrozdil'] = 10;
            break;
        case "НПЗ":
            $new_val['pidrozdil'] = 13;
            break;
        case "ЮР":
            $new_val['pidrozdil'] = 11;
            break;
        case "СК":
            $new_val['pidrozdil'] = 13;
            break;
        case "ФК":
            $new_val['pidrozdil'] = 16;
            break;
        case "КС":
            $new_val['pidrozdil'] = 15;
            break;
        case "РРФП":
            $new_val['pidrozdil'] = 17;
            break;
    }
    $new_val['nzp'] = full_trim(htmlspecialchars($_POST['nzpE'], ENT_QUOTES));
    $new_val['date_change'] = strtotime(date('d.m.Y H:i:s'));
    $new_val['user'] = $_SESSION['id_user'];
    $new_val['short_name_fu'] = full_trim(htmlspecialchars($_POST['short_name_fuE'], ENT_QUOTES));
    $new_val['edrpo'] = full_trim(htmlspecialchars($_POST['edrpoEE']));
    $new_val['type_fo'] = htmlspecialchars($_POST['type_foE']);
    $new_val['vid_perevirki'] = $_POST['vid_perevirkiSE'] != '' ? htmlspecialchars($_POST['vid_perevirkiSE']) : 1;
    $new_val['pidstava_pozaplanS'] = "";
    if (isset($_POST['pidstava_pozaplanSE'])) {
        $pidstavi = $_POST['pidstava_pozaplanSE'];
        $new_val['pidstava_pozaplanS'] = "'";
        foreach ($pidstavi as $value) {
            $new_val['pidstava_pozaplanS'] = $new_val['pidstava_pozaplanS'] . $value . "; ";
        }
        $new_val['pidstava_pozaplanS'] = $new_val['pidstava_pozaplanS'] . "'";
    }
    $new_val['d_start_perevirki'] = strtotime($_POST['d_start_perevirkiE']);
    $new_val['d_end_perevirki'] = strtotime($_POST['d_end_perevirkiE']);
    $new_val['d_start_dialnist'] = strtotime($_POST['d_start_dialnistE']);
    $new_val['d_end_dialnist'] = strtotime($_POST['d_end_dialnistE']);
    $new_val['d_nak_zah'] = strtotime($_POST['d_nak_zahE']);
    $new_val['n_nak_zah'] = full_trim(htmlspecialchars($_POST['n_nak_zahE'], ENT_QUOTES));
    $new_val['d_napr_proved'] = strtotime($_POST['d_napr_provedE']);
    $new_val['n_napr_proved'] = full_trim(htmlspecialchars($_POST['n_napr_provedE'], ENT_QUOTES));


    $diffs = array();
    $diffs['nzp'] = $new_val['nzp'] != $old_val['nzp']? $new_val['nzp'] : "" ;
    $diffs['pidrozdil'] = $new_val['pidrozdil'] != $old_val['pidrozdil']? $new_val['pidrozdil'] : "" ;
    $diffs['short_name_fu'] = $new_val['short_name_fu'] != $old_val['short_name_fu']? "'".$new_val['short_name_fu']."'" : "" ;
    $diffs['edrpo'] = $new_val['edrpo'] != $old_val['edrpo']? "'".$new_val['edrpo']."'" : "" ;
    $diffs['type_fu'] = $new_val['type_fo'] != $old_val['type_fu']? $new_val['type_fo'] : "" ;
    $diffs['vid_perevirki'] = $new_val['vid_perevirki'] != $old_val['vid_perevirki']? $new_val['vid_perevirki'] : "" ;
    $diffs['pidstava_pozaplan'] = $new_val['pidstava_pozaplanS'] != "'".$old_val['pidstava_pozaplan']."'"? $new_val['pidstava_pozaplanS'] : "" ;
    $diffs['d_start_perevirki'] = $new_val['d_start_perevirki'] != $old_val['d_start_perevirki']? $new_val['d_start_perevirki'] : "" ;
    $diffs['d_end_perevirki'] = $new_val['d_end_perevirki'] != $old_val['d_end_perevirki']? $new_val['d_end_perevirki'] : "" ;
    $diffs['d_start_dialnist'] = $new_val['d_start_dialnist'] != $old_val['d_start_dialnist']? $new_val['d_start_dialnist'] : "" ;
    $diffs['d_end_dialnist'] = $new_val['d_end_dialnist'] != $old_val['d_end_dialnist']? $new_val['d_end_dialnist'] : "" ;
    $diffs['d_nak_zah'] = $new_val['d_nak_zah'] != $old_val['d_nak_zah']? $new_val['d_nak_zah'] : "" ;
    $old_val['n_nak_zah'] = substr($old_val['n_nak_zah'],1);
    if (($new_val['n_nak_zah'] != $old_val['n_nak_zah'])&&($new_val['n_nak_zah'] != "")) {
        $diffs['n_nak_zah'] = "'№".$new_val['n_nak_zah']."'";
    } else {
        $diffs['n_nak_zah'] = "";
    }
    $diffs['d_napr_proved'] = $new_val['d_napr_proved'] != $old_val['d_napr_proved']? $new_val['d_napr_proved'] : "" ;
    $old_val['n_napr_proved'] = substr($old_val['n_napr_proved'],1);
    if (($new_val['n_napr_proved'] != $old_val['n_napr_proved'])&&($new_val['n_napr_proved'] != "")) {
        $diffs['n_napr_proved'] = "'№".$new_val['n_napr_proved']."'";
    } else {
        $diffs['n_napr_proved'] = "";
    }


    $isNoChanged = true;
    foreach ($diffs as $key => $value) {
        if ($value != "") {
            $isNoChanged = false;
        }
    }
    if ($isNoChanged == true) {
        return true;
    }
    $query = "date_change = ".$new_val['date_change'].", user = ".$new_val['user'];
    $i = 1;
    foreach ($diffs as $key => $value) {
        if ($value != "") {
            $query .= ", " . $key . "=" . $value;
            $i++;
        }
    }
    $sql = "UPDATE inspekt SET " . $query . " WHERE id_inspekt=" . $_POST['id_inspekt'] . ";";
    $result = mysqli_query($link, $sql);
    if ($result) {
        writeLog('QUERY', $sql, 1);
        return true;
    } else {
        writeLog('QUERY', $sql, 0);
        $logs = fopen("logs.txt", "w") or die("Unable to open file!");
        $txt = "Error: " . $sql . "\n" . mysqli_error($link);
        fwrite($logs, $txt);
        fclose($logs);
        return false;
    }



}


function get_users()
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }

    $sql = "SELECT * FROM users WHERE id_user <> 0";


    $result = mysqli_query($link, $sql);

    $table_users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $table_users;

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
            if ($row['active_user'] == 1) {
                $exist = true;
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['user'] = $row['username'];
                $_SESSION['group'] = $row['memberof'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['action_time'] = microtime(true);
            }
            break;
        }
    }
    if ($exist) {
        writeLog('AUTH', 'LOGIN', 1);
    } else {
        writeLog('AUTH', 'LOGIN', 0);
    }
    return $exist;
}

function isUserActive()
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }
    $isActive = false;
    $sql = "SELECT active_user FROM users WHERE id_user=" . $_SESSION['id_user'];
    if ($result = mysqli_query($link, $sql)) {
        while ($row = mysqli_fetch_row($result)) {
            if ($row[0] == 1) {
                $isActive = true;
            }
        }
        mysqli_free_result($result);
    }
    return $isActive;
}

function add_user()
{
    if (!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }
    $username = "'" . trim(htmlspecialchars($_POST['username'])) . "'";
    $password = "'" . md5(trim(htmlspecialchars($_POST['password']))) . "'";
    $pib = "'" . trim(htmlspecialchars($_POST['pib'])) . "'";
    $memberof = '';
    switch ($_POST['memberof']) {
        case "DeRZIT":
            $memberof = 'ДеРЗІТ';
            break;
        case "NPZ":
            $memberof = 'НПЗ';
            break;
        case "UR":
            $memberof = 'ЮР';
            break;
        case "SK":
            $memberof = 'СК';
            break;
        case "FK":
            $memberof = 'ФК';
            break;
        case "KS":
            $memberof = 'КС';
            break;
        case "RRFP":
            $memberof = 'РРФП';
            break;
        case "All_read":
            $memberof = 'Read';
            break;
    }
    $active = 0;
    if (isset($_POST['active'])) {
        $active = 1;
    }

    $sql = "INSERT INTO users (username, pwd, full_name, memberof, active_user) VALUES ($username, $password, $pib, 
            '$memberof', $active)";
    $result = mysqli_query($link, $sql);
    if ($result) {
        writeLog('QUERY', $sql, 1);
        return true;
    } else {
        writeLog('QUERY', $sql, 0);
        $logs = fopen("logs.txt", "w") or die("Unable to open file!");
        $txt = "Error: " . $sql . "\n" . mysqli_error($link);
        fwrite($logs, $txt);
        fclose($logs);
        return false;
    }
}

function edit_user()
{
    if (!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }
    $sql = "SELECT * FROM users WHERE id_user=" . $_POST['id_user'] . ";";
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
        extract($row, EXTR_PREFIX_ALL, 'old');
        mysqli_free_result($result);
    } else {
        return false;
    }

    $username_new = full_trim(htmlspecialchars($_POST['username_edit']));
    $password_new = full_trim(htmlspecialchars($_POST['password_edit']));
    $full_name_new = full_trim(htmlspecialchars($_POST['pib_edit']));
    $memberof_new = '';
    switch ($_POST['memberof_edit']) {
        case "DeRZIT":
            $memberof_new = 'ДеРЗІТ';
            break;
        case "NPZ":
            $memberof_new = 'НПЗ';
            break;
        case "UR":
            $memberof_new = 'ЮР';
            break;
        case "SK":
            $memberof_new = 'СК';
            break;
        case "FK":
            $memberof_new = 'ФК';
            break;
        case "KS":
            $memberof_new = 'КС';
            break;
        case "RRFP":
            $memberof_new = 'РРФП';
            break;
        case "All_read":
            $memberof_new = 'Read';
            break;
    }
    $active_user_new = isset($_POST['active_edit']) ? 1 : 0;

    $sql_set = array(
        "username" => "",
        "pwd" => "",
        "full_name" => "",
        "memberof" => "",
        "active_user" => ""
    );
    if ($old_username != $username_new) {
        $sql_set["username"] = "'$username_new'";
    }
    if ($password_new != '') {
        if ($old_pwd != md5($password_new)) {
            $sql_set["pwd"] = "'" . md5($password_new) . "'";
        }
    }
    if ($old_full_name != $full_name_new) {
        $sql_set["full_name"] = "'$full_name_new'";
    }
    if ($old_memberof != $memberof_new) {
        $sql_set["memberof"] = "'$memberof_new'";
    }
    if ($old_active_user != $active_user_new) {
        $sql_set["active_user"] = "$active_user_new";
    }
    $query = "";
    $isNoChanged = true;
    foreach ($sql_set as $key => $value) {
        if ($value != "") {
            $isNoChanged = false;
        }
    }
    if ($isNoChanged == true) {
        return true;
    }
    $i = 1;
    foreach ($sql_set as $key => $value) {
        if (($value != "") && ($i == 1)) {
            $query .= $key . "=" . $value;
            $i++;
        } elseif ($value != "") {
            $query .= ", " . $key . "=" . $value;
            $i++;
        }
    }
    $sql = "UPDATE users SET " . $query . " WHERE id_user=" . $_POST['id_user'] . ";";
    $result = mysqli_query($link, $sql);
    if ($result) {
        writeLog('QUERY', $sql, 1);
        return true;
    } else {
        writeLog('QUERY', $sql, 0);
        $logs = fopen("logs.txt", "w") or die("Unable to open file!");
        $txt = "Error: " . $sql . "\n" . mysqli_error($link);
        fwrite($logs, $txt);
        fclose($logs);
        return false;
    }
}

function delete_user()
{
    //TODO rewrite sql query
    if (!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }
    $ids = $_POST['id_user_delete'];
    $pieces = explode("; ", $ids);
    $pieces = array_diff($pieces,['']);
    $iter = new CachingIterator(new ArrayIterator($pieces));
    $umov = '';
    foreach ($iter as $val) {
        $umov .= "id_user = " . $val;
        if ($iter->hasNext()) {
            $umov .= " OR ";
        }
    }
    $sql = "UPDATE users SET active_user = 0, visible = 0 WHERE $umov;";
    $result = mysqli_query($link, $sql);
    if ($result) {
        writeLog('QUERY', $sql, 1);
        return true;
    } else {
        writeLog('QUERY', $sql, 0);
        $logs = fopen("logs.txt", "w") or die("Unable to open file!");
        $txt = "Error: " . $sql . "\n" . mysqli_error($link);
        fwrite($logs, $txt);
        fclose($logs);
        return false;
    }
}


function get_dics()
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
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

function get_dic($dic)
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }

    $sql = "SELECT * FROM " . $dic;


    $result = mysqli_query($link, $sql);

    $table_dic = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $table_dic;

}

function add_row_dic($dic) {

    if (!isUserActive()) {
        return false;
    }
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }
    $column = '';
    switch ($dic) {
        case "dic_type_fu":
            $column = 'name_type_fu';
            break;
    }

    $val = "'" . full_trim(htmlspecialchars($_POST['type_sub'])) . "'";

    $sql = "INSERT INTO $dic ($column, visible) VALUES ($val, 1);";

    $result = mysqli_query($link, $sql);
    if ($result) {
        writeLog('QUERY', $sql, 1);
        return true;
    } else {
        writeLog('QUERY', $sql, 0);
        $logs = fopen("logs.txt", "w") or die("Unable to open file!");
        $txt = "Error: " . $sql . "\n" . mysqli_error($link);
        fwrite($logs, $txt);
        fclose($logs);
        return false;
    }
}

function edit_row_dic($dic) {

}

function del_row_dic($dic) {

}


function writeLog($type, $query, $status)
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }
    $time = strtotime(date('d.m.Y H:i:s'));
    $user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
    $query = mysqli_real_escape_string($link, $query);
    $sql = "INSERT INTO logs (time_exec, type, user, query, status) VALUES ($time, '$type', $user, '$query', '$status')";
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

function get_logs()
{
    global $link;
    if (!mysqli_ping($link)) {
        echo "Error: " . mysqli_error($link);
        exit();
    }

    $sql = "SELECT id_log, time_exec, type, username, query, status FROM logs, users WHERE user=id_user";


    $result = mysqli_query($link, $sql);

    $table_logs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $table_logs;

}

function dev_mod($stat) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ip_arr = explode(".", $ip);
    $ac = fopen("../.htaccess", "w") or die("Unable to open file!");
    $rules = "RewriteEngine On\n";
    fwrite($ac, $rules);
    $rules = "RewriteBase /\n";
    fwrite($ac, $rules);
    $rules = "RewriteRule ^([^.?]+)$ %{REQUEST_URI}.php [L]\n";
    fwrite($ac, $rules);
    $rules = "RewriteCond %{THE_REQUEST} \"^[^ ]* .?.php[? ].$\"\n";
    fwrite($ac, $rules);
    $rules = "RewriteRule .* - [L,R=404]\n";
    fwrite($ac, $rules);
    $rules = "RewriteCond %{HTTPS} =off\n";
    fwrite($ac, $rules);
    $rules = "RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [QSA,L]\n";
    fwrite($ac, $rules);
    $rules = "ErrorDocument 404 /404.php\n";
    fwrite($ac, $rules);
    $rules = "<IfModule mod_rewrite.c>\nRewriteCond %{REQUEST_URI} !/work$\n";
    fwrite($ac, $rules);
    if($stat == 1) {
        $rules = "RewriteCond %{REMOTE_ADDR} !^".$ip_arr[0]."\.".$ip_arr[1]."\.".$ip_arr[2]."\.".$ip_arr[3]."\n";
    } else {
        $rules = "RewriteCond %{REMOTE_ADDR} !^192\.168\.0\.*\n";
        $rules .= "RewriteCond %{REMOTE_ADDR} !^10\.10\.*\.*\n";
    }
    fwrite($ac, $rules);
    $rules = "RewriteCond %{REQUEST_FILENAME} !-f\nRewriteRule $ /work.php [R=302,L]\n</IfModule>\n";
    fwrite($ac, $rules);
    fclose($ac);

    $ac2 = fopen(".htaccess", "w") or die("Unable to open file!");
    $rules = "RewriteEngine On\n";
    fwrite($ac2, $rules);
    $rules = "RewriteBase /\n";
    fwrite($ac2, $rules);
    $rules = "RewriteCond %{REQUEST_URI} ^/cms\n";
    fwrite($ac2, $rules);
    $rules = "RewriteRule ^index\.php(.*)$ /cms/$1 [L,R=200]\n";
    fwrite($ac2, $rules);
    $rules = "RewriteRule ^([^.?]+)$ %{REQUEST_URI}.php [L]\n";
    fwrite($ac2, $rules);
    $rules = "RewriteCond %{THE_REQUEST} \"^[^ ]* .?.php[? ].$\"\n";
    fwrite($ac2, $rules);
    $rules = "RewriteRule .* - [L,R=404]\n";
    fwrite($ac2, $rules);
    $rules = "RewriteCond %{HTTPS} =off\n";
    fwrite($ac2, $rules);
    $rules = "RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [QSA,L]\n";
    fwrite($ac2, $rules);
    $rules = "ErrorDocument 404 /404.php\n";
    fwrite($ac2, $rules);
    $rules = "<IfModule mod_rewrite.c>\nRewriteCond %{REQUEST_URI} !/work$\n";
    fwrite($ac2, $rules);
    if($stat == 1) {
        $rules = "RewriteCond %{REMOTE_ADDR} !^" . $ip_arr[0] . "\." . $ip_arr[1] . "\." . $ip_arr[2] . "\." . $ip_arr[3] . "\n";
    } else {
        $rules = "RewriteCond %{REMOTE_ADDR} !^192\.168\.0\.*\n";
        $rules .= "RewriteCond %{REMOTE_ADDR} !^10\.10\.*\.*\n";
    }
    fwrite($ac2, $rules);
    $rules = "RewriteCond %{REQUEST_FILENAME} !-f\nRewriteRule $ /work.php [R=302,L]\n</IfModule>\n";
    fwrite($ac2, $rules);
    fclose($ac2);
    return true;
}
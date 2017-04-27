<?php
require_once("database.php");
require_once("functions.php");
if($_POST['getT']!="") {
//echo "Success";
$table_inspekt = get_table_inspect();
$m = "";
foreach ($table_inspekt as $row) {

$m = $m . "<tr>";
    $m = $m . "<td></td>";
    $m = $m . "<td>" . $row['nzp'] . "</td>";
    $m = $m . "<td>" . $row['pidrozdil'] . "</td>";
    $m = $m . "<td>" . $row['short_name_fu'] . "</td>";
    $m = $m . "<td>" . $row['edrpo'] . "</td>";
    $m = $m . "<td>" . $row['name_type_fu'] . "</td>";
    $m = $m . "<td>" . $row['vid_perevirki'] . "</td>";
    $m = $m . "<td>" . $row['name_pidstav'] . "</td>";
    $m = $m . "<td>" . $row['d_start_perevirki'] == NULL ? '' : date($format_date, $row['d_start_perevirki']) . "</td>";
    $m = $m . "<td>" . $row['d_end_perevirki'] == NULL ? '' : date($format_date, $row['d_end_perevirki']) . "</td>";
    $m = $m . "<td>" . $row['d_start_dialnist'] == NULL ? '' : date($format_date, $row['d_start_dialnist']) . "</td>";
    $m = $m . "<td>" . $row['d_end_dialnist'] == NULL ? '' : date($format_date, $row['d_end_dialnist']) . "</td>";
    $m = $m . "<td>" . $row['d_nak_zah'] == NULL ? '' : date($format_date, $row['d_nak_zah']) . "</td>";
    $m = $m . "<td>" . $row['n_nak_zah'] . "</td>";
    $m = $m . "<td>" . $row['d_napr_proved'] == NULL ? '' : date($format_date, $row['d_napr_proved']) . "</td>";
    $m = $m . "<td>" . $row['n_napr_proved'] . "</td>";
    $m = $m . "<td>" . $row['ker_inspekt_group'] . "</td>";
    $m = $m . "<td>" . $row['ch_inspekt_group'] . "</td>";
    $m = $m . "<td>" . $row['d_akt_perevirki'] == NULL ? '' : date($format_date, $row['d_akt_perevirki']) . "</td>";
    $m = $m . "<td>" . $row['n_akt_perevirki'] . "</td>";
    $m = $m . "<td>" . $row['d_akt_zu'] == NULL ? '' : date($format_date, $row['d_akt_zu']) . "</td>";
    $m = $m . "<td>" . $row['n_akt_zu'] . "</td>";
    $m = $m . "<td>" . $row['vid_akt_zu'] . "</td>";
    $m = $m . "<td>" . $row['d_rozp_usun'] == NULL ? '' : date($format_date, $row['d_rozp_usun']) . "</td>";
    $m = $m . "<td>" . $row['n_rozp_usun'] . "</td>";
    $m = $m . "<td>" . $row['strok_usun_por'] . "</td>";
    $m = $m . "<td>" . $row['b_usun_lic_umov'] . "</td>";
    $m = $m . "<td>" . $row['info_vik_rozp'] . "</td>";
    $m = $m . "<td>" . $row['d_dovidki_vik_rozp'] . "</td>";
    $m = $m . "<td>" . $row['dn_akt_nevik'] . "</td>";
    $m = $m . "<td>" . $row['d_post_shtraf'] == NULL ? '' : date($format_date, $row['d_post_shtraf']) . "</td>";
    $m = $m . "<td>" . $row['n_post_shtraf'] . "</td>";
    $m = $m . "<td>" . $row['suma_shtraf'] . "</td>";
    $m = $m . "<td>" . $row['strok_splat_shtraf'] . "</td>";
    $m = $m . "<td>" . $row['info_splat_shtraf'] . "</td>";
    $m = $m . "<td>" . $row['info_usun_por'] . "</td>";
    $m = $m . "<td>" . $row['d_dovidki_vik_post'] == NULL ? '' : date($format_date, $row['d_dovidki_vik_post']) . "</td>";
    $m = $m . "<td>" . $row['dn_sluj_ur'] . "</td>";
    $m = $m . "<td>" . $row['sluj_perep_splat'] . "</td>";
    $m = $m . "<td>" . $row['dn_doc_splat'] . "</td>";
    $m = $m . "<td>" . $row['dn_sluj_nap_mat'] . "</td>";
    $m = $m . "<td>" . $row['name_sud_dn_poz'] . "</td>";
    $m = $m . "<td>" . $row['n_sud_sprav'] . "</td>";
    $m = $m . "<td>" . $row['d_sud_rish'] == NULL ? '' : date($format_date, $row['d_sud_rish']) . "</td>";
    $m = $m . "<td>" . $row['d_sud_rish_ros'] == NULL ? '' : date($format_date, $row['d_sud_rish_ros']) . "</td>";
    $m = $m . "<td>" . $row['short_zm_rish'] . "</td>";
    $m = $m . "<td>" . $row['name_apel_sud'] . "</td>";
    $m = $m . "<td>" . $row['n_ssprav_apel'] . "</td>";
    $m = $m . "<td>" . $row['d_srish_apel'] == NULL ? '' : date($format_date, $row['d_srish_apel']) . "</td>";
    $m = $m . "<td>" . $row['d_res_srish_apel'] == NULL ? '' : date($format_date, $row['d_res_srish_apel']) . "</td>";
    $m = $m . "<td>" . $row['short_zm_rish_apel'] . "</td>";
    $m = $m . "<td>" . $row['dn_kasac_scar'] . "</td>";
    $m = $m . "<td>" . $row['n_sprav_kasac'] . "</td>";
    $m = $m . "<td>" . $row['d_rish_kasac'] == NULL ? '' : date($format_date, $row['d_rish_kasac']) . "</td>";
    $m = $m . "<td>" . $row['d_rish_res_kasac'] == NULL ? '' : date($format_date, $row['d_rish_res_kasac']) . "</td>";
    $m = $m . "<td>" . $row['short_zm_rish_kasac'] . "</td>";
    $m = $m . "<td>" . $row['primitka_sud_roz'] . "</td>";
    $m = $m . "<td>" . $row['splach_sud_zbir'] . "</td>";
    $m = $m . "<td>" . $row['poklad_sud_zbir'] . "</td>";
    $m = $m . "<td>" . $row['povern_sud_zbir'] . "</td>";
    $m = $m . "<td>" . $row['dn_list_dobro_splat'] . "</td>";
    $m = $m . "<td>" . $row['shtraf_splach_dobro'] . "</td>";
    $m = $m . "<td>" . $row['dn_sluj_primus'] . "</td>";
    $m = $m . "<td>" . $row['dn_lz_vikon_list'] . "</td>";
    $m = $m . "<td>" . $row['dn_otrum_vikon_list'] . "</td>";
    $m = $m . "<td>" . $row['dn_napr_list_dvs'] . "</td>";
    $m = $m . "<td>" . $row['dn_rekv_otk_vp'] . "</td>";
    $m = $m . "<td>" . $row['short_opis_zah_dvs'] . "</td>";
    $m = $m . "<td>" . $row['dn_rekv_zak_vp'] . "</td>";
    $m = $m . "<td>" . $row['primitka_dod'] . "</td>";
    $m = $m . "<td>" . $row['napr_zap_derjrei'] . "</td>";
    $m = $m . "<td>" . $row['napr_zap_dfs'] . "</td>";
    $m = $m . "<td>" . $row['napr_zai_police'] . "</td>";
    $m = $m . "<td>" . $row['napr_info_bank'] . "</td>";
    $m = $m . "<td>" . $row['napr_info_zasn'] . "</td>";
    $m = $m . "<td>" . $row['napr_info_prokuror'] . "</td>";
    $m = $m . "<td>" . $row['napr_info_oms'] . "</td>";
    $m = $m . "<td>" . $row['napr_info_dfs'] . "</td>";


    $m = $m . "</tr>";
}
echo $m;
}
?>
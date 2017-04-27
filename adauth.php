<?php

/*
set_time_limit(30);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

// config
$ldapserver = 'gey.dfp.gov.ua';
$ldapuser      = 'o_paziura';
$ldappass     = 'Plesha95332';
$ldaptree    = "OU=DFP Users, DC=dfp,DC=gov,DC=ua";

// connect
$ldapconn = ldap_connect($ldapserver) or die("Could not connect to LDAP server.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
if($ldapconn) {
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldapuser, $ldappass) or die ("Error trying to bind: ".ldap_error($ldapconn));
    // verify binding
    if ($ldapbind) {
        echo "LDAP bind successful...<br /><br />";


        $result = ldap_search($ldapconn,$ldaptree, "(cn=*)") or die ("Error in search query: ".ldap_error($ldapconn));
        $data = ldap_get_entries($ldapconn, $result);

        // SHOW ALL DATA
        echo '<h1>Dump all data</h1><pre>';
        print_r($data);
        echo '</pre>';


        // iterate over array and print data for each entry
        echo '<h1>Show me the users</h1>';
        for ($i=0; $i<$data["count"]; $i++) {
            //echo "dn is: ". $data[$i]["dn"] ."<br />";
            echo "User: ". $data[$i]["cn"][0] ."<br />";
            if(isset($data[$i]["mail"][0])) {
                echo "Email: ". $data[$i]["mail"][0] ."<br /><br />";
            } else {
                echo "Email: None<br /><br />";
            }
        }
        // print number of entries found
        echo "Number of entries found: " . ldap_count_entries($ldapconn, $result);
    } else {
        echo "LDAP bind failed...";
    }

}

// all done? clean up
ldap_close($ldapconn);
*/
/*$domain = 'dfp.gov.ua';
$username = 'o_paziura';
$password = 'Plesha95332';
$ldapconfig['host'] = 'gey.dfp.gov.ua';
$ldapconfig['port'] = 389;
$ldapconfig['basedn'] = 'dc=dfp,dc=gov,dc=ua';

$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

$dn="ou=DFP Users,".$ldapconfig['basedn'];
$bind=ldap_bind($ds, $username .'@' .$domain, $password);
$isITuser = ldap_search($bind,$dn,'(&(objectClass=User)(sAMAccountName=' . $username. '))');
if ($isITuser) {
    echo("Login correct");
} else {
    echo("Login incorrect");
}*/
/*
$ldaphost = "ldaps://gey.dfp.gov.ua/";
//$ldapUsername  = "cn=o_paziura,ou=\"DFP\ Users\",dc=dfp,dc=gov,dc=ua";
$ldapPassword = "Plesha95332";

$connect = ldap_connect($ldaphost);
$auth_user = 'CN=o_paziura,OU=DFP Users,DC=dfp,DC=gov,DC=ua';
$bind = ldap_bind($connect, $auth_user , $ldapPassword);

*/



/*$ds = ldap_connect($ldaphost) or die("Could not connect to {$ldaphost}");

if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)){
    print "Could not set LDAPv3\r\n";
}
else {
// now we need to bind to the ldap server
    $bth = ldap_bind($ds, $ldapUsername, $ldapPassword) or die("\r\nCould not connect to LDAP server\r\n");
}*/

/*
function mydap_start($host,$username,$password) {
    global $mydap;
    if(isset($mydap)) die('Error, LDAP connection already established');

    // Connect to AD
    $mydap = ldap_connect($host) or die('Error connecting to LDAP');
    @ldap_bind($mydap,$username,$password) or die('Error binding to LDAP: '.ldap_error($mydap));

    return true;
}

function mydap_end() {
    global $mydap;
    if(!isset($mydap)) die('Error, no LDAP connection established');

    // Close existing LDAP connection
    ldap_unbind($mydap);
}

function mydap_attributes($user,$keep=false) {
    global $mydap;
    if(!isset($mydap)) die('Error, no LDAP connection established');
    if(empty($user)) die('Error, no LDAP user specified');

    // Query user attributes
    $results = ldap_search($mydap,$user,'sn=*',$keep) or die('Error searching LDAP: '.ldap_error($mydap));
    $attributes = ldap_get_entries($mydap, $results);

    // Return attributes list
    return $attributes[0];
}

function mydap_members($group) {
    global $mydap;
    if(!isset($mydap)) die('Error, no LDAP connection established');
    if(empty($group)) die('Error, no LDAP group specified');

    // Query group members
    $results = ldap_search($mydap,$group,'cn=*',array('member')) or die('Error searching LDAP: '.ldap_error($mydap));
    $members = ldap_get_entries($mydap, $results);

    if(!isset($members[0]['member'])) return false;

    // Remove 'count' element from array
    array_shift($members[0]['member']);

    // Return member list
    return $members[0]['member'];
}

// ==================================================================================
// Example Usage
// ==================================================================================

// Establish connection
mydap_start(
    'gey.dfp.gov.ua', // Active Directory server
    'o_paziura@dfp.gov.ua', // Active Directory search user
    'Plesha95332' // Active Directory search user password
);

// Get members of our group by providing dn
$members = mydap_members('OU=DFP Users,DC=dfp,DC=gov,DC=ua');
if(!$members) die('No group members found');

// Here you could pull another group's members by running myldap_members again
// And merge the results with the previous results, or whatever you need
// ...

// User attributes we want to obtain
$keep = array('displayname','samaccountname');

// Iterate each member to get attributes
foreach($members as $m) {
    $attr = mydap_attributes($m,$keep);

    // Do what you will, such as store or display member information
    echo "{$attr['displayname'][0]}, {$attr['samaccountname'][0]}&lt;br&gt;";
}

// Close connection
mydap_end();*/





    /*$username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $domain = 'dfp.gov.ua';
    $ldapconfig['host'] = 'gey.dfp.gov.ua';
    $ldapconfig['port'] = 389;
    $ldapconfig['basedn'] = 'dc=dfp,dc=gov,dc=ua';

    $ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

    $dn="ou=DFP Users,".$ldapconfig['basedn'];
    $bind=ldap_bind($ds, $username .'@' .$domain, $password);
    $isITuser = ldap_search($bind,$dn,'(&(objectClass=User)(sAMAccountName=' . $username. '))');
    if ($isITuser) {
        echo("Login correct");
    } else {
        echo("Login incorrect");
    }*/
// using ldap bind
/*$ldaprdn  = 'o_paziura@dfp.gov.ua';     // ldap rdn or dn
$ldappass = 'Plesha95332';  // associated password

// connect to ldap server
$ldapconn = ldap_connect("gey.dfp.gov.ua")
or die("Could not connect to LDAP server.");

if ($ldapconn) {

    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    // verify binding
    if ($ldapbind) {
        echo "LDAP bind successful...";
    } else {
        echo "LDAP bind failed...";
    }

}*/
require_once('src/adLDAP.php');
$adldap = new adLDAP(array('base_dn'=>'OU=DFP Users,DC=dfp,DC=gov,DC=ua', 'account_suffix'=>'@dfp.gov.ua',
    'domain_controllers'=>array('gey.gfp.gov.ua'),
'use_ssl'=> true));
$authUser = $adldap->user()->authenticate('o_paziura', 'Plesha95332');
if ($authUser == true) {
    echo "User authenticated successfully";
}
else {
    // getLastError is not needed, but may be helpful for finding out why:
    echo $adldap->getLastError()."<br>";

    echo "User authentication unsuccessful";
}

?>
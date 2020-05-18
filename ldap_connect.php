<?php session_start();

/**
 * Created by Joe of ExchangeCore.com
 */

if(isset($_POST['username']) && isset($_POST['password'])){
    
    require_once("Handler/model/FinanceList.php");

    
        
    
    if (!empty($_POST['username']) && !empty($_POST['password'])){
                $adServer = "ldap://ad.onsemi.com";

        $ldap = ldap_connect($adServer);

        $username = $_POST['username']; // FF ID
        $password = $_POST['password'];
     
        $ldaprdn = 'onsemi' . "\\" . $username;
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        $bind = @ldap_bind($ldap, $ldaprdn, $password);

        if ($bind) {

            $user_info = new FinanceList();

            $user_result = $user_info->get_user_data($username);
            //print_r($user_result);

            $filter="(sAMAccountName=$username)";
            $result = ldap_search($ldap,"dc=MYDOMAIN,dc=COM",$filter);
            ldap_sort($ldap,$result,"sn");
            $info = ldap_get_entries($ldap, $result);
            
            
                
                $_SESSION['crs_username'] = $user_result['ffId'];
                $_SESSION['firstname'] = $user_result['firstName'];
                $_SESSION['lastname'] = $user_result['lastName'];
          

            $user_priv = $user_info->get_priv_data($_SESSION['crs_username']);
            
            $_SESSION['crs_username'];
            $privLen = sizeof($user_priv);
            for ($priv=0 ; $priv < $privLen ; $priv++){

                $_SESSION['userType'] = $user_priv[$priv]['type'];
            }
            if ($username == "zbdtjy" || $username == "zbh4bc" || $username == "fg6cwj" || $username == "ffz7bg" || $username == "zbhffw" || $username == "ffzjxf" || $username == "fg88pn" || $username == "fg68jy")
            {
                $_SESSION['userType'] = 2;
            }
            @ldap_close($ldap);
            
            //print_r($_SESSION);
            header("Location: index.php");
            exit();
        }
    }
}



//echo "FALSE";
$_SESSION['message'] = 1;
header("Location: login.php");
exit();
?>

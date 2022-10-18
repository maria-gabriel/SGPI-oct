<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class contraresController extends Controller
{
    public function index(){
          
       return view('contrares');
    }

     public function actua(Request $request){

        try {
       $adldap = new adLDAP();
       }
       catch (adLDAPException $e) {
           echo $e;
           exit();
       }
          if($request->password == $request->password2){
            if($adldap->authenticate($request->username,$request->password)){
                $user = new User();
                $user = User::where('username', $request->username)->first();
                $user->password = Hash::make($request->password);
                $user->update();
                return view('contrares')->with('documents')->with('actualiza','Contraseña actualizada correctamente.');
            }else{
                return view('contrares')->with('documents')->with('erroract','Contraseña o usuario no encontrados en sistema.');
            }
            
          }else{
            return view('contrares')->with('documents')->with('errorcontra','Las contraseñas no coinciden.');
          }
    }
}
class adLDAP {
    
    /**
     * Define the different types of account in AD
     */
    const ADLDAP_NORMAL_ACCOUNT = 805306368;
    const ADLDAP_WORKSTATION_TRUST = 805306369;
    const ADLDAP_INTERDOMAIN_TRUST = 805306370;
    const ADLDAP_SECURITY_GLOBAL_GROUP = 268435456;
    const ADLDAP_DISTRIBUTION_GROUP = 268435457;
    const ADLDAP_SECURITY_LOCAL_GROUP = 536870912;
    const ADLDAP_DISTRIBUTION_LOCAL_GROUP = 536870913;
    const ADLDAP_FOLDER = 'OU';
    const ADLDAP_CONTAINER = 'CN';
    
    /**
    * The default port for LDAP non-SSL connections
    */
    const ADLDAP_LDAP_PORT = '389';
    /**
    * The default port for LDAPS SSL connections
    */
    const ADLDAP_LDAPS_PORT = '636';
    
    /**
    * The account suffix for your domain, can be set when the class is invoked
    * 
    * @var string
    */   
    protected $accountSuffix = "@redssm.ssm.gob.mx";
    
    /**
    * The base dn for your domain
    * 
    * If this is set to null then adLDAP will attempt to obtain this automatically from the rootDSE
    * 
    * @var string
    */
    protected $baseDn = "DC=redssm,DC=ssm,DC=gob,DC=mx"; 
    
    /** 
    * Port used to talk to the domain controllers. 
    *  
    * @var int 
    */ 
    protected $adPort = self::ADLDAP_LDAP_PORT; 
    
    /**
    * Array of domain controllers. Specifiy multiple controllers if you
    * would like the class to balance the LDAP queries amongst multiple servers
    * 
    * @var array
    */
    protected $domainControllers = array("192.168.10.180");
    
    /**
    * Optional account with higher privileges for searching
    * This should be set to a domain admin account
    * 
    * @var string
    * @var string
    */
    protected $adminUsername = NULL;
    protected $adminPassword = NULL;
    
    /**
    * AD does not return the primary group. http://support.microsoft.com/?kbid=321360
    * This tweak will resolve the real primary group. 
    * Setting to false will fudge "Domain Users" and is much faster. Keep in mind though that if
    * someone's primary group is NOT domain users, this is obviously going to mess up the results
    * 
    * @var bool
    */
    protected $realPrimaryGroup = true;
    
    /**
    * Use SSL (LDAPS), your server needs to be setup, please see
    * http://adldap.sourceforge.net/wiki/doku.php?id=ldap_over_ssl
    * 
    * @var bool
    */
    protected $useSSL = false;
    
    /**
    * Use TLS
    * If you wish to use TLS you should ensure that $useSSL is set to false and vice-versa
    * 
    * @var bool
    */
    protected $useTLS = false;
    
    /**
    * Use SSO  
    * To indicate to adLDAP to reuse password set by the brower through NTLM or Kerberos 
    * 
    * @var bool
    */
    protected $useSSO = false;
    
    /**
    * When querying group memberships, do it recursively 
    * eg. User Fred is a member of Group A, which is a member of Group B, which is a member of Group C
    * user_ingroup("Fred","C") will returns true with this option turned on, false if turned off     
    * 
    * @var bool
    */
    protected $recursiveGroups = true;
    
    // You should not need to edit anything below this line
    //******************************************************************************************
    
    /**
    * Connection and bind default variables
    * 
    * @var mixed
    * @var mixed
    */
    protected $ldapConnection;
    protected $ldapBind;
    
    /**
    * Get the active LDAP Connection
    * 
    * @return resource
    */
    public function getLdapConnection() {
        if ($this->ldapConnection) {
            return $this->ldapConnection;   
        }
        return false;
    }
    
    /**
    * Get the bind status
    * 
    * @return bool
    */
    public function getLdapBind() {
        return $this->ldapBind;
    }
    
    /**
    * Get the current base DN
    * 
    * @return string
    */
    public function getBaseDn() {
        return $this->baseDn;   
    }
    
    /**
    * The group class
    * 
    * @var adLDAPGroups
    */
    protected $groupClass;
    
    /**
    * Get the group class interface
    * 
    * @return adLDAPGroups
    */
    public function group() {
        if (!$this->groupClass) {
            $this->groupClass = new adLDAPGroups($this);
        }   
        return $this->groupClass;
    }
    
    /**
    * The user class
    * 
    * @var adLDAPUsers
    */
    protected $userClass;
    
    /**
    * Get the userclass interface
    * 
    * @return adLDAPUsers
    */
    public function user() {
        if (!$this->userClass) {
            $this->userClass = new adLDAPUsers($this);
        }   
        return $this->userClass;
    }
    
    /**
    * The folders class
    * 
    * @var adLDAPFolders
    */
    protected $folderClass;
    
    /**
    * Get the folder class interface
    * 
    * @return adLDAPFolders
    */
    public function folder() {
        if (!$this->folderClass) {
            $this->folderClass = new adLDAPFolders($this);
        }   
        return $this->folderClass;
    }
    
    /**
    * The utils class
    * 
    * @var adLDAPUtils
    */
    protected $utilClass;
    
    /**
    * Get the utils class interface
    * 
    * @return adLDAPUtils
    */
    public function utilities() {
        if (!$this->utilClass) {
            $this->utilClass = new adLDAPUtils($this);
        }   
        return $this->utilClass;
    }
    
    /**
    * The contacts class
    * 
    * @var adLDAPContacts
    */
    protected $contactClass;
    
    /**
    * Get the contacts class interface
    * 
    * @return adLDAPContacts
    */
    public function contact() {
        if (!$this->contactClass) {
            $this->contactClass = new adLDAPContacts($this);
        }   
        return $this->contactClass;
    }
    
    /**
    * The exchange class
    * 
    * @var adLDAPExchange
    */
    protected $exchangeClass;
    
    /**
    * Get the exchange class interface
    * 
    * @return adLDAPExchange
    */
    public function exchange() {
        if (!$this->exchangeClass) {
            $this->exchangeClass = new adLDAPExchange($this);
        }   
        return $this->exchangeClass;
    }
    
    /**
    * The computers class
    * 
    * @var adLDAPComputers
    */
    protected $computersClass;
    
    /**
    * Get the computers class interface
    * 
    * @return adLDAPComputers
    */
    public function computer() {
        if (!$this->computerClass) {
            $this->computerClass = new adLDAPComputers($this);
        }   
        return $this->computerClass;
    }

    /**
    * Getters and Setters
    */
    
    /**
    * Set the account suffix
    * 
    * @param string $accountSuffix
    * @return void
    */
    public function setAccountSuffix($accountSuffix)
    {
          $this->accountSuffix = $accountSuffix;
    }

    /**
    * Get the account suffix
    * 
    * @return string
    */
    public function getAccountSuffix()
    {
          return $this->accountSuffix;
    }
    
    /**
    * Set the domain controllers array
    * 
    * @param array $domainControllers
    * @return void
    */
    public function setDomainControllers(array $domainControllers)
    {
          $this->domainControllers = $domainControllers;
    }

    /**
    * Get the list of domain controllers
    * 
    * @return void
    */
    public function getDomainControllers()
    {
          return $this->domainControllers;
    }
    
    /**
    * Sets the port number your domain controller communicates over
    * 
    * @param int $adPort
    */
    public function setPort($adPort) 
    { 
        $this->adPort = $adPort; 
    } 
    
    /**
    * Gets the port number your domain controller communicates over
    * 
    * @return int
    */
    public function getPort() 
    { 
        return $this->adPort; 
    } 
    
    /**
    * Set the username of an account with higher priviledges
    * 
    * @param string $adminUsername
    * @return void
    */
    public function setAdminUsername($adminUsername)
    {
          $this->adminUsername = $adminUsername;
    }

    /**
    * Get the username of the account with higher priviledges
    * 
    * This will throw an exception for security reasons
    */
    public function getAdminUsername()
    {
          throw new adLDAPException('For security reasons you cannot access the domain administrator account details');
    }
    
    /**
    * Set the password of an account with higher priviledges
    * 
    * @param string $adminPassword
    * @return void
    */
    public function setAdminPassword($adminPassword)
    {
          $this->adminPassword = $adminPassword;
    }

    /**
    * Get the password of the account with higher priviledges
    * 
    * This will throw an exception for security reasons
    */
    public function getAdminPassword()
    {
          throw new adLDAPException('For security reasons you cannot access the domain administrator account details');
    }
    
    /**
    * Set whether to detect the true primary group
    * 
    * @param bool $realPrimaryGroup
    * @return void
    */
    public function setRealPrimaryGroup($realPrimaryGroup)
    {
          $this->realPrimaryGroup = $realPrimaryGroup;
    }

    /**
    * Get the real primary group setting
    * 
    * @return bool
    */
    public function getRealPrimaryGroup()
    {
          return $this->realPrimaryGroup;
    }
    
    /**
    * Set whether to use SSL
    * 
    * @param bool $useSSL
    * @return void
    */
    public function setUseSSL($useSSL)
    {
          $this->useSSL = $useSSL;
          // Set the default port correctly 
          if($this->useSSL) { 
            $this->setPort(self::ADLDAP_LDAPS_PORT); 
          }
          else { 
            $this->setPort(self::ADLDAP_LDAP_PORT); 
          } 
    }

    /**
    * Get the SSL setting
    * 
    * @return bool
    */
    public function getUseSSL()
    {
          return $this->useSSL;
    }
    
    /**
    * Set whether to use TLS
    * 
    * @param bool $useTLS
    * @return void
    */
    public function setUseTLS($useTLS)
    {
          $this->useTLS = $useTLS;
    }

    /**
    * Get the TLS setting
    * 
    * @return bool
    */
    public function getUseTLS()
    {
          return $this->useTLS;
    }
    
    /**
    * Set whether to use SSO
    * Requires ldap_sasl_bind support. Be sure --with-ldap-sasl is used when configuring PHP otherwise this function will be undefined. 
    * 
    * @param bool $useSSO
    * @return void
    */
    public function setUseSSO($useSSO)
    {
          if ($useSSO === true && !$this->ldapSaslSupported()) {
              throw new adLDAPException('No LDAP SASL support for PHP.  See: http://www.php.net/ldap_sasl_bind');
          }
          $this->useSSO = $useSSO;
    }

    /**
    * Get the SSO setting
    * 
    * @return bool
    */
    public function getUseSSO()
    {
          return $this->useSSO;
    }
    
    /**
    * Set whether to lookup recursive groups
    * 
    * @param bool $recursiveGroups
    * @return void
    */
    public function setRecursiveGroups($recursiveGroups)
    {
          $this->recursiveGroups = $recursiveGroups;
    }

    /**
    * Get the recursive groups setting
    * 
    * @return bool
    */
    public function getRecursiveGroups()
    {
          return $this->recursiveGroups;
    }

    /**
    * Default Constructor
    * 
    * Tries to bind to the AD domain over LDAP or LDAPs
    * 
    * @param array $options Array of options to pass to the constructor
    * @throws Exception - if unable to bind to Domain Controller
    * @return bool
    */
    function __construct($options = array()) {
        // You can specifically overide any of the default configuration options setup above
        if (count($options) > 0) {
            if (array_key_exists("account_suffix",$options)){ $this->accountSuffix = $options["account_suffix"]; }
            if (array_key_exists("base_dn",$options)){ $this->baseDn = $options["base_dn"]; }
            if (array_key_exists("domain_controllers",$options)){ 
                if (!is_array($options["domain_controllers"])) { 
                    throw new adLDAPException('[domain_controllers] option must be an array');
                }
                $this->domainControllers = $options["domain_controllers"]; 
            }
            if (array_key_exists("admin_username",$options)){ $this->adminUsername = $options["admin_username"]; }
            if (array_key_exists("admin_password",$options)){ $this->adminPassword = $options["admin_password"]; }
            if (array_key_exists("real_primarygroup",$options)){ $this->realPrimaryGroup = $options["real_primarygroup"]; }
            if (array_key_exists("use_ssl",$options)){ $this->setUseSSL($options["use_ssl"]); }
            if (array_key_exists("use_tls",$options)){ $this->useTLS = $options["use_tls"]; }
            if (array_key_exists("recursive_groups",$options)){ $this->recursiveGroups = $options["recursive_groups"]; }
            if (array_key_exists("ad_port",$options)){ $this->setPort($options["ad_port"]); } 
            if (array_key_exists("sso",$options)) { 
                $this->setUseSSO($options["sso"]);
                if (!$this->ldapSaslSupported()) {
                    $this->setUseSSO(false);
                }
            } 
        }
        
        if ($this->ldapSupported() === false) {
            throw new adLDAPException('No LDAP support for PHP.  See: http://www.php.net/ldap');
        }

        return $this->connect();
    }

    /**
    * Default Destructor
    * 
    * Closes the LDAP connection
    * 
    * @return void
    */
    function __destruct() { 
        $this->close(); 
    }

    /**
    * Connects and Binds to the Domain Controller
    * 
    * @return bool
    */
    public function connect() 
    {
        // Connect to the AD/LDAP server as the username/password
        $domainController = $this->randomController();
        if ($this->useSSL) {
            $this->ldapConnection = ldap_connect("ldaps://" . $domainController, $this->adPort);
        } else {
            $this->ldapConnection = ldap_connect($domainController, $this->adPort);
        }
               
        // Set some ldap options for talking to AD
        ldap_set_option($this->ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldapConnection, LDAP_OPT_REFERRALS, 0);
        
        if ($this->useTLS) {
            ldap_start_tls($this->ldapConnection);
        }
               
        // Bind as a domain admin if they've set it up
        if ($this->adminUsername !== NULL && $this->adminPassword !== NULL) {
            $this->ldapBind = @ldap_bind($this->ldapConnection, $this->adminUsername . $this->accountSuffix, $this->adminPassword);
            if (!$this->ldapBind) {
                if ($this->useSSL && !$this->useTLS) {
                    // If you have problems troubleshooting, remove the @ character from the ldapldapBind command above to get the actual error message
                    throw new adLDAPException('Bind to Active Directory failed. Either the LDAPs connection failed or the login credentials are incorrect. AD said: ' . $this->getLastError());
                }
                else {
                    throw new adLDAPException('Bind to Active Directory failed. Check the login credentials and/or server details. AD said: ' . $this->getLastError());
                }
            }
        }
        if ($this->useSSO && $_SERVER['REMOTE_USER'] && $this->adminUsername === null && $_SERVER['KRB5CCNAME']) {
            putenv("KRB5CCNAME=" . $_SERVER['KRB5CCNAME']);  
            $this->ldapBind = @ldap_sasl_bind($this->ldapConnection, NULL, NULL, "GSSAPI"); 
            if (!$this->ldapBind){ 
                throw new adLDAPException('Rebind to Active Directory failed. AD said: ' . $this->getLastError()); 
            }
            else {
                return true;
            }
        }
                
        
        if ($this->baseDn == NULL) {
            $this->baseDn = $this->findBaseDn();   
        }
        
        return true;
    }
    
    /**
    * Closes the LDAP connection
    * 
    * @return void
    */
    public function close() {
        if ($this->ldapConnection) {
            @ldap_close($this->ldapConnection);
        }
    }
    
    /**
    * Validate a user's login credentials
    * 
    * @param string $username A user's AD username
    * @param string $password A user's AD password
    * @param bool optional $preventRebind
    * @return bool
    */
    public function authenticate($username, $password, $preventRebind = false) {
        // Prevent null binding
        if ($username === NULL || $password === NULL) { return false; } 
        if (empty($username) || empty($password)) { return false; }
        
        // Allow binding over SSO for Kerberos
        if ($this->useSSO && $_SERVER['REMOTE_USER'] && $_SERVER['REMOTE_USER'] == $username && $this->adminUsername === NULL && $_SERVER['KRB5CCNAME']) { 
            putenv("KRB5CCNAME=" . $_SERVER['KRB5CCNAME']);
            $this->ldapBind = @ldap_sasl_bind($this->ldapConnection, NULL, NULL, "GSSAPI");
            if (!$this->ldapBind) {
                throw new adLDAPException('Rebind to Active Directory failed. AD said: ' . $this->getLastError());
            }
            else {
                return true;
            }
        }
        
        // Bind as the user        
        $ret = true;
        $this->ldapBind = @ldap_bind($this->ldapConnection, $username . $this->accountSuffix, $password);
        if (!$this->ldapBind){ 
            $ret = false; 
        }
        
        // Cnce we've checked their details, kick back into admin mode if we have it
        if ($this->adminUsername !== NULL && !$preventRebind) {
            $this->ldapBind = @ldap_bind($this->ldapConnection, $this->adminUsername . $this->accountSuffix , $this->adminPassword);
            if (!$this->ldapBind){
                // This should never happen in theory
                throw new adLDAPException('Rebind to Active Directory failed. AD said: ' . $this->getLastError());
            } 
        } 
        
        return $ret;
    }
    
    /**
    * Find the Base DN of your domain controller
    * 
    * @return string
    */
    public function findBaseDn() 
    {
        $namingContext = $this->getRootDse(array('defaultnamingcontext'));   
        return $namingContext[0]['defaultnamingcontext'][0];
    }
    
    /**
    * Get the RootDSE properties from a domain controller
    * 
    * @param array $attributes The attributes you wish to query e.g. defaultnamingcontext
    * @return array
    */
    public function getRootDse($attributes = array("*", "+")) {
        if (!$this->ldapBind){ return (false); }
        
        $sr = @ldap_read($this->ldapConnection, NULL, 'objectClass=*', $attributes);
        $entries = @ldap_get_entries($this->ldapConnection, $sr);
        return $entries;
    }

    /**
    * Get last error from Active Directory
    * 
    * This function gets the last message from Active Directory
    * This may indeed be a 'Success' message but if you get an unknown error
    * it might be worth calling this function to see what errors were raised
    * 
    * return string
    */
    public function getLastError() {
        return @ldap_error($this->ldapConnection);
    }
    
    /**
    * Detect LDAP support in php
    * 
    * @return bool
    */    
    protected function ldapSupported()
    {
        if (!function_exists('ldap_connect')) {
            return false;   
        }
        return true;
    }
    
    /**
    * Detect ldap_sasl_bind support in PHP
    * 
    * @return bool
    */
    protected function ldapSaslSupported()
    {
        if (!function_exists('ldap_sasl_bind')) {
            return false;
        }
        return true;
    }
    
    /**
    * Schema
    * 
    * @param array $attributes Attributes to be queried
    * @return array
    */    
    public function adldap_schema($attributes){
    
        // LDAP doesn't like NULL attributes, only set them if they have values
        // If you wish to remove an attribute you should set it to a space
        // TO DO: Adapt user_modify to use ldap_mod_delete to remove a NULL attribute
        $mod=array();
        
        // Check every attribute to see if it contains 8bit characters and then UTF8 encode them
        array_walk($attributes, array($this, 'encode8bit'));

        if ($attributes["address_city"]){ $mod["l"][0]=$attributes["address_city"]; }
        if ($attributes["address_code"]){ $mod["postalCode"][0]=$attributes["address_code"]; }
        //if ($attributes["address_country"]){ $mod["countryCode"][0]=$attributes["address_country"]; } // use country codes?
        if ($attributes["address_country"]){ $mod["c"][0]=$attributes["address_country"]; }
        if ($attributes["address_pobox"]){ $mod["postOfficeBox"][0]=$attributes["address_pobox"]; }
        if ($attributes["address_state"]){ $mod["st"][0]=$attributes["address_state"]; }
        if ($attributes["address_street"]){ $mod["streetAddress"][0]=$attributes["address_street"]; }
        if ($attributes["company"]){ $mod["company"][0]=$attributes["company"]; }
        if ($attributes["change_password"]){ $mod["pwdLastSet"][0]=0; }
        if ($attributes["department"]){ $mod["department"][0]=$attributes["department"]; }
        if ($attributes["description"]){ $mod["description"][0]=$attributes["description"]; }
        if ($attributes["display_name"]){ $mod["displayName"][0]=$attributes["display_name"]; }
        if ($attributes["email"]){ $mod["mail"][0]=$attributes["email"]; }
        if ($attributes["expires"]){ $mod["accountExpires"][0]=$attributes["expires"]; } //unix epoch format?
        if ($attributes["firstname"]){ $mod["givenName"][0]=$attributes["firstname"]; }
        if ($attributes["home_directory"]){ $mod["homeDirectory"][0]=$attributes["home_directory"]; }
        if ($attributes["home_drive"]){ $mod["homeDrive"][0]=$attributes["home_drive"]; }
        if ($attributes["initials"]){ $mod["initials"][0]=$attributes["initials"]; }
        if ($attributes["logon_name"]){ $mod["userPrincipalName"][0]=$attributes["logon_name"]; }
        if ($attributes["manager"]){ $mod["manager"][0]=$attributes["manager"]; }  //UNTESTED ***Use DistinguishedName***
        if ($attributes["office"]){ $mod["physicalDeliveryOfficeName"][0]=$attributes["office"]; }
        if ($attributes["password"]){ $mod["unicodePwd"][0]=$this->user()->encodePassword($attributes["password"]); }
        if ($attributes["profile_path"]){ $mod["profilepath"][0]=$attributes["profile_path"]; }
        if ($attributes["script_path"]){ $mod["scriptPath"][0]=$attributes["script_path"]; }
        if ($attributes["surname"]){ $mod["sn"][0]=$attributes["surname"]; }
        if ($attributes["title"]){ $mod["title"][0]=$attributes["title"]; }
        if ($attributes["telephone"]){ $mod["telephoneNumber"][0]=$attributes["telephone"]; }
        if ($attributes["mobile"]){ $mod["mobile"][0]=$attributes["mobile"]; }
        if ($attributes["pager"]){ $mod["pager"][0]=$attributes["pager"]; }
        if ($attributes["ipphone"]){ $mod["ipphone"][0]=$attributes["ipphone"]; }
        if ($attributes["web_page"]){ $mod["wWWHomePage"][0]=$attributes["web_page"]; }
        if ($attributes["fax"]){ $mod["facsimileTelephoneNumber"][0]=$attributes["fax"]; }
        if ($attributes["enabled"]){ $mod["userAccountControl"][0]=$attributes["enabled"]; }
        if ($attributes["homephone"]){ $mod["homephone"][0]=$attributes["homephone"]; }
        
        // Distribution List specific schema
        if ($attributes["group_sendpermission"]){ $mod["dlMemSubmitPerms"][0]=$attributes["group_sendpermission"]; }
        if ($attributes["group_rejectpermission"]){ $mod["dlMemRejectPerms"][0]=$attributes["group_rejectpermission"]; }
        
        // Exchange Schema
        if ($attributes["exchange_homemdb"]){ $mod["homeMDB"][0]=$attributes["exchange_homemdb"]; }
        if ($attributes["exchange_mailnickname"]){ $mod["mailNickname"][0]=$attributes["exchange_mailnickname"]; }
        if ($attributes["exchange_proxyaddress"]){ $mod["proxyAddresses"][0]=$attributes["exchange_proxyaddress"]; }
        if ($attributes["exchange_usedefaults"]){ $mod["mDBUseDefaults"][0]=$attributes["exchange_usedefaults"]; }
        if ($attributes["exchange_policyexclude"]){ $mod["msExchPoliciesExcluded"][0]=$attributes["exchange_policyexclude"]; }
        if ($attributes["exchange_policyinclude"]){ $mod["msExchPoliciesIncluded"][0]=$attributes["exchange_policyinclude"]; }       
        if ($attributes["exchange_addressbook"]){ $mod["showInAddressBook"][0]=$attributes["exchange_addressbook"]; }    
        if ($attributes["exchange_altrecipient"]){ $mod["altRecipient"][0]=$attributes["exchange_altrecipient"]; } 
        if ($attributes["exchange_deliverandredirect"]){ $mod["deliverAndRedirect"][0]=$attributes["exchange_deliverandredirect"]; }    
        
        // This schema is designed for contacts
        if ($attributes["exchange_hidefromlists"]){ $mod["msExchHideFromAddressLists"][0]=$attributes["exchange_hidefromlists"]; }
        if ($attributes["contact_email"]){ $mod["targetAddress"][0]=$attributes["contact_email"]; }
        
        //echo ("<pre>"); print_r($mod);
        /*
        // modifying a name is a bit fiddly
        if ($attributes["firstname"] && $attributes["surname"]){
            $mod["cn"][0]=$attributes["firstname"]." ".$attributes["surname"];
            $mod["displayname"][0]=$attributes["firstname"]." ".$attributes["surname"];
            $mod["name"][0]=$attributes["firstname"]." ".$attributes["surname"];
        }
        */

        if (count($mod)==0){ return (false); }
        return ($mod);
    }
    
    /**
    * Convert 8bit characters e.g. accented characters to UTF8 encoded characters
    */
    protected function encode8Bit(&$item, $key) {
        $encode = false;
        if (is_string($item)) {
            for ($i=0; $i<strlen($item); $i++) {
                if (ord($item[$i]) >> 7) {
                    $encode = true;
                }
            }
        }
        if ($encode === true && $key != 'password') {
            $item = utf8_encode($item);   
        }
    }
    
    /**
    * Select a random domain controller from your domain controller array
    * 
    * @return string
    */
    protected function randomController() 
    {
        mt_srand(doubleval(microtime()) * 100000000); // For older PHP versions
        /*if (sizeof($this->domainControllers) > 1) {
            $adController = $this->domainControllers[array_rand($this->domainControllers)]; 
            // Test if the controller is responding to pings
            $ping = $this->pingController($adController); 
            if ($ping === false) { 
                // Find the current key in the domain controllers array
                $key = array_search($adController, $this->domainControllers);
                // Remove it so that we don't end up in a recursive loop
                unset($this->domainControllers[$key]);
                // Select a new controller
                return $this->randomController(); 
            }
            else { 
                return ($adController); 
            }
        } */
        return $this->domainControllers[array_rand($this->domainControllers)];
    }  
    
    /** 
    * Test basic connectivity to controller 
    * 
    * @return bool
    */ 
    protected function pingController($host) {
        $port = $this->adPort; 
        fsockopen($host, $port, $errno, $errstr, 10); 
        if ($errno > 0) {
            return false;
        }
        return true;
    }

}

abstract class adLDAPCollection
{
    /**
    * The current adLDAP connection via dependency injection
    * 
    * @var adLDAP
    */
    protected $adldap;
    
    /**
    * The current object being modifed / called
    * 
    * @var mixed
    */
    protected $currentObject;
    
    /**
    * The raw info array from Active Directory
    * 
    * @var array
    */
    protected $info;
    
    public function __construct($info, adLDAP $adldap) 
    {
        $this->setInfo($info);   
        $this->adldap = $adldap;
    }
    
    /**
    * Set the raw info array from Active Directory
    * 
    * @param array $info
    */
    public function setInfo(array $info) 
    {
        if ($this->info && sizeof($info) >= 1) {
            unset($this->info);
        }
        $this->info = $info;   
    }
    
    /**
    * Magic get method to retrieve data from the raw array in a formatted way
    * 
    * @param string $attribute
    * @return mixed
    */
    public function __get($attribute)
    {
        if (isset($this->info[0]) && is_array($this->info[0])) {
            foreach ($this->info[0] as $keyAttr => $valueAttr) {
                if (strtolower($keyAttr) == strtolower($attribute)) {
                    if ($this->info[0][strtolower($attribute)]['count'] == 1) {
                        return $this->info[0][strtolower($attribute)][0];   
                    }
                    else {
                        $array = array();
                        foreach ($this->info[0][strtolower($attribute)] as $key => $value) {
                            if ((string)$key != 'count') {
                                $array[$key] = $value;
                            } 
                        }  
                        return $array;   
                    }
                }   
            }
        }
        else {
            return NULL;   
        }
    }    
    
    /**
    * Magic set method to update an attribute
    * 
    * @param string $attribute
    * @param string $value
    * @return bool
    */
    abstract public function __set($attribute, $value);
    
    /** 
    * Magic isset method to check for the existence of an attribute 
    * 
    * @param string $attribute 
    * @return bool 
    */ 
    public function __isset($attribute) {
        if (isset($this->info[0]) && is_array($this->info[0])) { 
            foreach ($this->info[0] as $keyAttr => $valueAttr) { 
                if (strtolower($keyAttr) == strtolower($attribute)) { 
                    return true; 
                } 
            } 
        } 
        return false; 
     } 
}

class adLDAPGroups {
    /**
    * The current adLDAP connection via dependency injection
    * 
    * @var adLDAP
    */
    protected $adldap;
    
    public function __construct(adLDAP $adldap) {
        $this->adldap = $adldap;
    }
    
    /**
    * Add a group to a group
    * 
    * @param string $parent The parent group name
    * @param string $child The child group name
    * @return bool
    */
    public function addGroup($parent,$child){

        // Find the parent group's dn
        $parentGroup = $this->ginfo($parent, array("cn"));
        if ($parentGroup[0]["dn"] === NULL){
            return false; 
        }
        $parentDn = $parentGroup[0]["dn"];
        
        // Find the child group's dn
        $childGroup = $this->info($child, array("cn"));
        if ($childGroup[0]["dn"] === NULL){ 
            return false; 
        }
        $childDn = $childGroup[0]["dn"];
                
        $add = array();
        $add["member"] = $childDn;
        
        $result = @ldap_mod_add($this->adldap->getLdapConnection(), $parentDn, $add);
        if ($result == false) { 
            return false; 
        }
        return true;
    }
    
    /**
    * Add a user to a group
    * 
    * @param string $group The group to add the user to
    * @param string $user The user to add to the group
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return bool
    */
    public function addUser($group, $user, $isGUID = false)
    {
        // Adding a user is a bit fiddly, we need to get the full DN of the user
        // and add it using the full DN of the group
        
        // Find the user's dn
        $userDn = $this->adldap->user()->dn($user, $isGUID);
        if ($userDn === false) { 
            return false; 
        }
        
        // Find the group's dn
        $groupInfo = $this->info($group, array("cn"));
        if ($groupInfo[0]["dn"] === NULL) { 
            return false; 
        }
        $groupDn = $groupInfo[0]["dn"];
        
        $add = array();
        $add["member"] = $userDn;
        
        $result = @ldap_mod_add($this->adldap->getLdapConnection(), $groupDn, $add);
        if ($result == false) { 
            return false; 
        }
        return true;
    }
    
    /**
    * Add a contact to a group
    * 
    * @param string $group The group to add the contact to
    * @param string $contactDn The DN of the contact to add
    * @return bool
    */
    public function addContact($group, $contactDn)
    {
        // To add a contact we take the contact's DN
        // and add it using the full DN of the group
        
        // Find the group's dn
        $groupInfo = $this->info($group, array("cn"));
        if ($groupInfo[0]["dn"] === NULL) { 
            return false; 
        }
        $groupDn = $groupInfo[0]["dn"];
        
        $add = array();
        $add["member"] = $contactDn;
        
        $result = @ldap_mod_add($this->adldap->getLdapConnection(), $groupDn, $add);
        if ($result == false) { 
            return false; 
        }
        return true;
    }

    /**
    * Create a group
    * 
    * @param array $attributes Default attributes of the group
    * @return bool
    */
    public function create($attributes)
    {
        if (!is_array($attributes)){ return "Attributes must be an array"; }
        if (!array_key_exists("group_name", $attributes)){ return "Missing compulsory field [group_name]"; }
        if (!array_key_exists("container", $attributes)){ return "Missing compulsory field [container]"; }
        if (!array_key_exists("description", $attributes)){ return "Missing compulsory field [description]"; }
        if (!is_array($attributes["container"])){ return "Container attribute must be an array."; }
        $attributes["container"] = array_reverse($attributes["container"]);

        //$member_array = array();
        //$member_array[0] = "cn=user1,cn=Users,dc=yourdomain,dc=com";
        //$member_array[1] = "cn=administrator,cn=Users,dc=yourdomain,dc=com";
        
        $add = array();
        $add["cn"] = $attributes["group_name"];
        $add["samaccountname"] = $attributes["group_name"];
        $add["objectClass"] = "Group";
        $add["description"] = $attributes["description"];
        //$add["member"] = $member_array; UNTESTED

        $container = "OU=" . implode(",OU=", $attributes["container"]);
        $result = ldap_add($this->adldap->getLdapConnection(), "CN=" . $add["cn"] . ", " . $container . "," . $this->adldap->getBaseDn(), $add);
        if ($result != true) { 
            return false; 
        }
        return true;
    }
    
    /**
    * Delete a group account 
    * 
    * @param string $group The group to delete (please be careful here!) 
    * 
    * @return array 
    */
    public function delete($group) {
        if (!$this->adldap->getLdapBind()){ return false; }
        if ($group === null){ return "Missing compulsory field [group]"; }
        
        $groupInfo = $this->info($group, array("*"));
        $dn = $groupInfo[0]['distinguishedname'][0]; 
        $result = $this->adldap->folder()->delete($dn); 
        if ($result !== true) { 
            return false; 
        } return true;   
    }

    /**
    * Remove a group from a group
    * 
    * @param string $parent The parent group name
    * @param string $child The child group name
    * @return bool
    */
    public function removeGroup($parent , $child)
    {
    
        // Find the parent dn
        $parentGroup = $this->info($parent, array("cn"));
        if ($parentGroup[0]["dn"] === NULL) { 
            return false; 
        }
        $parentDn = $parentGroup[0]["dn"];
        
        // Find the child dn
        $childGroup = $this->info($child, array("cn"));
        if ($childGroup[0]["dn"] === NULL) { 
            return false; 
        }
        $childDn = $childGroup[0]["dn"];
        
        $del = array();
        $del["member"] = $childDn;
        
        $result = @ldap_mod_del($this->adldap->getLdapConnection(), $parentDn, $del);
        if ($result == false) { 
            return false; 
        }
        return true;
    }
    
    /**
    * Remove a user from a group
    * 
    * @param string $group The group to remove a user from
    * @param string $user The AD user to remove from the group
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return bool
    */
    public function removeUser($group, $user, $isGUID = false)
    {
    
        // Find the parent dn
        $groupInfo = $this->info($group, array("cn"));
        if ($groupInfo[0]["dn"] === NULL){ 
            return false; 
        }
        $groupDn = $groupInfo[0]["dn"];
        
        // Find the users dn
        $userDn = $this->adldap->user()->dn($user, $isGUID);
        if ($userDn === false) {
            return false; 
        }

        $del = array();
        $del["member"] = $userDn;
        
        $result = @ldap_mod_del($this->adldap->getLdapConnection(), $groupDn, $del);
        if ($result == false) {
            return false; 
        }
        return true;
    }
    
    /**
    * Remove a contact from a group
    * 
    * @param string $group The group to remove a user from
    * @param string $contactDn The DN of a contact to remove from the group
    * @return bool
    */
    public function removeContact($group, $contactDn)
    {
    
        // Find the parent dn
        $groupInfo = $this->info($group, array("cn"));
        if ($groupInfo[0]["dn"] === NULL) { 
            return false; 
        }
        $groupDn = $groupInfo[0]["dn"];
    
        $del = array();
        $del["member"] = $contactDn;
        
        $result = @ldap_mod_del($this->adldap->getLdapConnection(), $groupDn, $del);
        if ($result == false) { 
            return false; 
        }
        return true;
    }
    
    /**
    * Return a list of groups in a group
    * 
    * @param string $group The group to query
    * @param bool $recursive Recursively get groups
    * @return array
    */
    public function inGroup($group, $recursive = NULL)
    {
        if (!$this->adldap->getLdapBind()){ return false; }
        if ($recursive === NULL){ $recursive = $this->adldap->getRecursiveGroups(); } // Use the default option if they haven't set it 
        
        // Search the directory for the members of a group
        $info = $this->info($group, array("member","cn"));
        $groups = $info[0]["member"];
        if (!is_array($groups)) {
            return false;   
        }
 
        $groupArray = array();

        for ($i=0; $i<$groups["count"]; $i++){ 
             $filter = "(&(objectCategory=group)(distinguishedName=" . $this->adldap->utilities()->ldapSlashes($groups[$i]) . "))";
             $fields = array("samaccountname", "distinguishedname", "objectClass");
             $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
             $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);

             // not a person, look for a group  
             if ($entries['count'] == 0 && $recursive == true) {  
                $filter = "(&(objectCategory=group)(distinguishedName=" . $this->adldap->utilities()->ldapSlashes($groups[$i]) . "))";  
                $fields = array("distinguishedname");  
                $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);  
                $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);  
                if (!isset($entries[0]['distinguishedname'][0])) {
                    continue;  
                }
                $subGroups = $this->inGroup($entries[0]['distinguishedname'][0], $recursive);  
                if (is_array($subGroups)) {
                    $groupArray = array_merge($groupArray, $subGroups); 
                    $groupArray = array_unique($groupArray);  
                }
                continue;  
             } 

             $groupArray[] = $entries[0]['distinguishedname'][0];
        }
        return $groupArray;
    }
    
    /**
    * Return a list of members in a group
    * 
    * @param string $group The group to query
    * @param bool $recursive Recursively get group members
    * @return array
    */
    public function members($group, $recursive = NULL)
    {
        if (!$this->adldap->getLdapBind()){ return false; }
        if ($recursive === NULL){ $recursive = $this->adldap->getRecursiveGroups(); } // Use the default option if they haven't set it 
        // Search the directory for the members of a group
        $info = $this->info($group, array("member","cn"));
        $users = $info[0]["member"];
        if (!is_array($users)) {
            return false;   
        }
 
        $userArray = array();

        for ($i=0; $i<$users["count"]; $i++){ 
             $filter = "(&(objectCategory=person)(distinguishedName=" . $this->adldap->utilities()->ldapSlashes($users[$i]) . "))";
             $fields = array("samaccountname", "distinguishedname", "objectClass");
             $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
             $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);

             // not a person, look for a group  
             if ($entries['count'] == 0 && $recursive == true) {  
                $filter = "(&(objectCategory=group)(distinguishedName=" . $this->adldap->utilities()->ldapSlashes($users[$i]) . "))";  
                $fields = array("samaccountname");  
                $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);  
                $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);  
                if (!isset($entries[0]['samaccountname'][0])) {
                    continue;  
                }
                $subUsers = $this->members($entries[0]['samaccountname'][0], $recursive);  
                if (is_array($subUsers)) {
                    $userArray = array_merge($userArray, $subUsers); 
                    $userArray = array_unique($userArray);  
                }
                continue;  
             } 
             else if ($entries['count'] == 0) {   
                continue; 
             } 

             if ((!isset($entries[0]['samaccountname'][0]) || $entries[0]['samaccountname'][0] === NULL) && $entries[0]['distinguishedname'][0] !== NULL) {
                 $userArray[] = $entries[0]['distinguishedname'][0];
             }
             else if ($entries[0]['samaccountname'][0] !== NULL) {
                $userArray[] = $entries[0]['samaccountname'][0];
             }
        }
        return $userArray;
    }
    
    /**
    * Group Information.  Returns an array of raw information about a group.
    * The group name is case sensitive
    * 
    * @param string $groupName The group name to retrieve info about
    * @param array $fields Fields to retrieve
    * @return array
    */
    public function info($groupName, $fields = NULL)
    {
        if ($groupName === NULL) { return false; }
        if (!$this->adldap->getLdapBind()) { return false; }
        
        if (stristr($groupName, '+')) {
            $groupName = stripslashes($groupName);   
        }
        
        $filter = "(&(objectCategory=group)(name=" . $this->adldap->utilities()->ldapSlashes($groupName) . "))";
        if ($fields === NULL) { 
            $fields = array("member","memberof","cn","description","distinguishedname","objectcategory","samaccountname"); 
        }
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);

        return $entries;
    }
    
    /**
    * Group Information.  Returns an collection
    * The group name is case sensitive
    * 
    * @param string $groupName The group name to retrieve info about
    * @param array $fields Fields to retrieve
    * @return adLDAPGroupCollection
    */
    public function infoCollection($groupName, $fields = NULL)
    {
        if ($groupName === NULL) { return false; }
        if (!$this->adldap->getLdapBind()) { return false; }
        
        $info = $this->info($groupName, $fields);
        if ($info !== false) {
            $collection = new adLDAPGroupCollection($info, $this->adldap);
            return $collection;
        }
        return false;
    }
    
    /**
    * Return a complete list of "groups in groups"
    * 
    * @param string $group The group to get the list from
    * @return array
    */
    public function recursiveGroups($group)
    {
        if ($group === NULL) { return false; }

        $stack = array(); 
        $processed = array(); 
        $retGroups = array(); 
     
        array_push($stack, $group); // Initial Group to Start with 
        while (count($stack) > 0) {
            $parent = array_pop($stack);
            array_push($processed, $parent);
            
            $info = $this->info($parent, array("memberof"));
            
            if (isset($info[0]["memberof"]) && is_array($info[0]["memberof"])) {
                $groups = $info[0]["memberof"]; 
                if ($groups) {
                    $groupNames = $this->adldap->utilities()->niceNames($groups);  
                    $retGroups = array_merge($retGroups, $groupNames); //final groups to return
                    foreach ($groupNames as $id => $groupName) { 
                        if (!in_array($groupName, $processed)) {
                            array_push($stack, $groupName);
                        }
                    }
                }
            }
        }
        
        return $retGroups;
    }
    
    /**
    * Returns a complete list of the groups in AD based on a SAM Account Type  
    * 
    * @param string $sAMAaccountType The account type to return
    * @param bool $includeDescription Whether to return a description
    * @param string $search Search parameters
    * @param bool $sorted Whether to sort the results
    * @return array
    */
    public function search($sAMAaccountType = adLDAP::ADLDAP_SECURITY_GLOBAL_GROUP, $includeDescription = false, $search = "*", $sorted = true) {
        if (!$this->adldap->getLdapBind()) { return false; }
        
        $filter = '(&(objectCategory=group)';
        if ($sAMAaccountType !== null) {
            $filter .= '(samaccounttype='. $sAMAaccountType .')';
        }
        $filter .= '(cn=' . $search . '))';
        // Perform the search and grab all their details
        $fields = array("samaccountname", "description");
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);

        $groupsArray = array();        
        for ($i=0; $i<$entries["count"]; $i++){
            if ($includeDescription && strlen($entries[$i]["description"][0]) > 0 ) {
                $groupsArray[$entries[$i]["samaccountname"][0]] = $entries[$i]["description"][0];
            }
            else if ($includeDescription){
                $groupsArray[$entries[$i]["samaccountname"][0]] = $entries[$i]["samaccountname"][0];
            }
            else {
                array_push($groupsArray, $entries[$i]["samaccountname"][0]);
            }
        }
        if ($sorted) { 
            asort($groupsArray); 
        }
        return $groupsArray;
    }
    
    /**
    * Returns a complete list of all groups in AD
    * 
    * @param bool $includeDescription Whether to return a description
    * @param string $search Search parameters
    * @param bool $sorted Whether to sort the results
    * @return array
    */
    public function all($includeDescription = false, $search = "*", $sorted = true){
        $groupsArray = $this->search(null, $includeDescription, $search, $sorted);
        return $groupsArray;
    }
    
    /**
    * Returns a complete list of security groups in AD
    * 
    * @param bool $includeDescription Whether to return a description
    * @param string $search Search parameters
    * @param bool $sorted Whether to sort the results
    * @return array
    */
    public function allSecurity($includeDescription = false, $search = "*", $sorted = true){
        $groupsArray = $this->search(adLDAP::ADLDAP_SECURITY_GLOBAL_GROUP, $includeDescription, $search, $sorted);
        return $groupsArray;
    }
    
    /**
    * Returns a complete list of distribution lists in AD
    * 
    * @param bool $includeDescription Whether to return a description
    * @param string $search Search parameters
    * @param bool $sorted Whether to sort the results
    * @return array
    */
    public function allDistribution($includeDescription = false, $search = "*", $sorted = true){
        $groupsArray = $this->search(adLDAP::ADLDAP_DISTRIBUTION_GROUP, $includeDescription, $search, $sorted);
        return $groupsArray;
    }
    
    /**
    * Coping with AD not returning the primary group
    * http://support.microsoft.com/?kbid=321360 
    * 
    * This is a re-write based on code submitted by Bruce which prevents the 
    * need to search each security group to find the true primary group
    * 
    * @param string $gid Group ID
    * @param string $usersid User's Object SID
    * @return mixed
    */
    public function getPrimaryGroup($gid, $usersid)
    {
        if ($gid === NULL || $usersid === NULL) { return false; }
        $sr = false;

        $gsid = substr_replace($usersid, pack('V',$gid), strlen($usersid)-4,4);
        $filter = '(objectsid=' . $this->adldap->utilities()->getTextSID($gsid).')';
        $fields = array("samaccountname","distinguishedname");
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);

        if (isset($entries[0]['distinguishedname'][0])) {
            return $entries[0]['distinguishedname'][0];
        }
        return false;
     }
     
     /**
    * Coping with AD not returning the primary group
    * http://support.microsoft.com/?kbid=321360 
    * 
    * For some reason it's not possible to search on primarygrouptoken=XXX
    * If someone can show otherwise, I'd like to know about it :)
    * this way is resource intensive and generally a pain in the @#%^
    * 
    * @deprecated deprecated since version 3.1, see get get_primary_group
    * @param string $gid Group ID
    * @return string
    */
    public function cn($gid){    
        if ($gid === NULL) { return false; }
        $sr = false;
        $r = '';
        
        $filter = "(&(objectCategory=group)(samaccounttype=" . adLDAP::ADLDAP_SECURITY_GLOBAL_GROUP . "))";
        $fields = array("primarygrouptoken", "samaccountname", "distinguishedname");
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);
        
        for ($i=0; $i<$entries["count"]; $i++){
            if ($entries[$i]["primarygrouptoken"][0] == $gid) {
                $r = $entries[$i]["distinguishedname"][0];
                $i = $entries["count"];
            }
        }

        return $r;
    }
}

class adLDAPUsers {
    /**
    * The current adLDAP connection via dependency injection
    * 
    * @var adLDAP
    */
    protected $adldap;
    
    public function __construct(adLDAP $adldap) {
        $this->adldap = $adldap;
    }
    
    /**
    * Validate a user's login credentials
    * 
    * @param string $username A user's AD username
    * @param string $password A user's AD password
    * @param bool optional $prevent_rebind
    * @return bool
    */
    public function authenticate($username, $password, $preventRebind = false) {
        return $this->adldap->authenticate($username, $password, $preventRebind);
    }
    
    /**
    * Create a user
    * 
    * If you specify a password here, this can only be performed over SSL
    * 
    * @param array $attributes The attributes to set to the user account
    * @return bool
    */
    public function create($attributes)
    {
        // Check for compulsory fields
        if (!array_key_exists("username", $attributes)){ return "Missing compulsory field [username]"; }
        if (!array_key_exists("firstname", $attributes)){ return "Missing compulsory field [firstname]"; }
        if (!array_key_exists("surname", $attributes)){ return "Missing compulsory field [surname]"; }
        if (!array_key_exists("email", $attributes)){ return "Missing compulsory field [email]"; }
        if (!array_key_exists("container", $attributes)){ return "Missing compulsory field [container]"; }
        if (!is_array($attributes["container"])){ return "Container attribute must be an array."; }

        if (array_key_exists("password",$attributes) && (!$this->adldap->getUseSSL() && !$this->adldap->getUseTLS())){ 
            throw new adLDAPException('SSL must be configured on your webserver and enabled in the class to set passwords.');
        }

        if (!array_key_exists("display_name", $attributes)) { 
            $attributes["display_name"] = $attributes["firstname"] . " " . $attributes["surname"]; 
        }

        // Translate the schema
        $add = $this->adldap->adldap_schema($attributes);
        
        // Additional stuff only used for adding accounts
        $add["cn"][0] = $attributes["display_name"];
        $add["samaccountname"][0] = $attributes["username"];
        $add["objectclass"][0] = "top";
        $add["objectclass"][1] = "person";
        $add["objectclass"][2] = "organizationalPerson";
        $add["objectclass"][3] = "user"; //person?
        //$add["name"][0]=$attributes["firstname"]." ".$attributes["surname"];

        // Set the account control attribute
        $control_options = array("NORMAL_ACCOUNT");
        if (!$attributes["enabled"]) { 
            $control_options[] = "ACCOUNTDISABLE"; 
        }
        $add["userAccountControl"][0] = $this->accountControl($control_options);
        
        // Determine the container
        $attributes["container"] = array_reverse($attributes["container"]);
        $container = "OU=" . implode(", OU=",$attributes["container"]);

        // Add the entry
        $result = @ldap_add($this->adldap->getLdapConnection(), "CN=" . $add["cn"][0] . ", " . $container . "," . $this->adldap->getBaseDn(), $add);
        if ($result != true) { 
            return false; 
        }
        
        return true;
    }
    
    /**
    * Account control options
    *
    * @param array $options The options to convert to int 
    * @return int
    */
    protected function accountControl($options)
    {
        $val=0;

        if (is_array($options)) {
            if (in_array("SCRIPT",$options)){ $val=$val+1; }
            if (in_array("ACCOUNTDISABLE",$options)){ $val=$val+2; }
            if (in_array("HOMEDIR_REQUIRED",$options)){ $val=$val+8; }
            if (in_array("LOCKOUT",$options)){ $val=$val+16; }
            if (in_array("PASSWD_NOTREQD",$options)){ $val=$val+32; }
            //PASSWD_CANT_CHANGE Note You cannot assign this permission by directly modifying the UserAccountControl attribute.
            //For information about how to set the permission programmatically, see the "Property flag descriptions" section.
            if (in_array("ENCRYPTED_TEXT_PWD_ALLOWED",$options)){ $val=$val+128; }
            if (in_array("TEMP_DUPLICATE_ACCOUNT",$options)){ $val=$val+256; }
            if (in_array("NORMAL_ACCOUNT",$options)){ $val=$val+512; }
            if (in_array("INTERDOMAIN_TRUST_ACCOUNT",$options)){ $val=$val+2048; }
            if (in_array("WORKSTATION_TRUST_ACCOUNT",$options)){ $val=$val+4096; }
            if (in_array("SERVER_TRUST_ACCOUNT",$options)){ $val=$val+8192; }
            if (in_array("DONT_EXPIRE_PASSWORD",$options)){ $val=$val+65536; }
            if (in_array("MNS_LOGON_ACCOUNT",$options)){ $val=$val+131072; }
            if (in_array("SMARTCARD_REQUIRED",$options)){ $val=$val+262144; }
            if (in_array("TRUSTED_FOR_DELEGATION",$options)){ $val=$val+524288; }
            if (in_array("NOT_DELEGATED",$options)){ $val=$val+1048576; }
            if (in_array("USE_DES_KEY_ONLY",$options)){ $val=$val+2097152; }
            if (in_array("DONT_REQ_PREAUTH",$options)){ $val=$val+4194304; } 
            if (in_array("PASSWORD_EXPIRED",$options)){ $val=$val+8388608; }
            if (in_array("TRUSTED_TO_AUTH_FOR_DELEGATION",$options)){ $val=$val+16777216; }
        }
        return $val;
    }
    
    /**
    * Delete a user account
    * 
    * @param string $username The username to delete (please be careful here!)
    * @param bool $isGUID Is the username a GUID or a samAccountName
    * @return array
    */
    public function delete($username, $isGUID = false) 
    {      
        $userinfo = $this->info($username, array("*"), $isGUID);
        $dn = $userinfo[0]['distinguishedname'][0];
        $result = $this->adldap->folder()->delete($dn);
        if ($result != true) { 
            return false;
        }        
        return true;
    }
    
    /**
    * Groups the user is a member of
    * 
    * @param string $username The username to query
    * @param bool $recursive Recursive list of groups
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return array
    */
    public function groups($username, $recursive = NULL, $isGUID = false)
    {
        if ($username === NULL) { return false; }
        if ($recursive === NULL) { $recursive = $this->adldap->getRecursiveGroups(); } // Use the default option if they haven't set it
        if (!$this->adldap->getLdapBind()) { return false; }
        
        // Search the directory for their information
        $info = @$this->info($username, array("memberof", "primarygroupid"), $isGUID);
        $groups = $this->adldap->utilities()->niceNames($info[0]["memberof"]); // Presuming the entry returned is our guy (unique usernames)

        if ($recursive === true){
            foreach ($groups as $id => $groupName){
                $extraGroups = $this->adldap->group()->recursiveGroups($groupName);
                $groups = array_merge($groups, $extraGroups);
            }
        }
        
        return $groups;
    }
    
    /**
    * Find information about the users. Returned in a raw array format from AD
    * 
    * @param string $username The username to query
    * @param array $fields Array of parameters to query
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return array
    */
    public function info($username, $fields = NULL, $isGUID = false)
    {
        if ($username === NULL) { return false; }
        if (!$this->adldap->getLdapBind()) { return false; }

        if ($isGUID === true) {
            $username = $this->adldap->utilities()->strGuidToHex($username);
            $filter = "objectguid=" . $username;
        }
        else if (strstr($username, "@")) {
             $filter = "userPrincipalName=" . $username;
        }
        else {
             $filter = "samaccountname=" . $username;
        }
        $filter = "(&(objectCategory=person)({$filter}))";
        if ($fields === NULL) { 
            $fields = array("samaccountname","mail","memberof","department","displayname","telephonenumber","primarygroupid","objectsid"); 
        }
        if (!in_array("objectsid", $fields)) {
            $fields[] = "objectsid";
        }
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);
        
        if (isset($entries[0])) {
            if ($entries[0]['count'] >= 1) {
                if (in_array("memberof", $fields)) {
                    // AD does not return the primary group in the ldap query, we may need to fudge it
                    if ($this->adldap->getRealPrimaryGroup() && isset($entries[0]["primarygroupid"][0]) && isset($entries[0]["objectsid"][0])){
                        //$entries[0]["memberof"][]=$this->group_cn($entries[0]["primarygroupid"][0]);
                        $entries[0]["memberof"][] = $this->adldap->group()->getPrimaryGroup($entries[0]["primarygroupid"][0], $entries[0]["objectsid"][0]);
                    } else {
                        $entries[0]["memberof"][] = "CN=Domain Users,CN=Users," . $this->adldap->getBaseDn();
                    }
                    if (!isset($entries[0]["memberof"]["count"])) {
                        $entries[0]["memberof"]["count"] = 0;
                    }
                    $entries[0]["memberof"]["count"]++;
                }
            }
            
            return $entries;
        }
        return false;
    }
    public function info_ricardo($username, $fields = NULL, $isGUID = false)
    {
        if ($username === NULL) { return false; }
        if (!$this->adldap->getLdapBind()) { return false; }

        if ($isGUID === true) {
            $username = $this->adldap->utilities()->strGuidToHex($username);
            $filter = "objectguid=" . $username;
        }
        else if (strstr($username, "@")) {
             $filter = "userPrincipalName=" . $username;
        }
        else {
             $filter = "samaccountname=" . $username;
        }
        $filter = "(&(objectCategory=person)({$filter}))";
        if ($fields === NULL) { 
            $fields = array("samaccountname","mail","memberof","department","displayname","telephonenumber","primarygroupid","objectsid","description"); 
        }
        if (!in_array("objectsid", $fields)) {
            $fields[] = "objectsid";
        }
        
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter);

        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);
        
        if (isset($entries[0])) {
            if ($entries[0]['count'] >= 1) {
                if (in_array("memberof", $fields)) {
                    // AD does not return the primary group in the ldap query, we may need to fudge it
                    if ($this->adldap->getRealPrimaryGroup() && isset($entries[0]["primarygroupid"][0]) && isset($entries[0]["objectsid"][0])){
                        //$entries[0]["memberof"][]=$this->group_cn($entries[0]["primarygroupid"][0]);
                        $entries[0]["memberof"][] = $this->adldap->group()->getPrimaryGroup($entries[0]["primarygroupid"][0], $entries[0]["objectsid"][0]);
                    } else {
                        $entries[0]["memberof"][] = "CN=Domain Users,CN=Users," . $this->adldap->getBaseDn();
                    }
                    if (!isset($entries[0]["memberof"]["count"])) {
                        $entries[0]["memberof"]["count"] = 0;
                    }
                    $entries[0]["memberof"]["count"]++;
                }
            }
            
            return $entries;
        }
        return false;
    }
    /**
    * Find information about the users. Returned in a raw array format from AD
    * 
    * @param string $username The username to query
    * @param array $fields Array of parameters to query
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return mixed
    */
    public function infoCollection($username, $fields = NULL, $isGUID = false)
    {
        if ($username === NULL) { return false; }
        if (!$this->adldap->getLdapBind()) { return false; }
        
        $info = $this->info($username, $fields, $isGUID);
        
        if ($info !== false) {
            $collection = new adLDAPUserCollection($info, $this->adldap);
            return $collection;
        }
        return false;
    }
    
    /**
    * Determine if a user is in a specific group
    * 
    * @param string $username The username to query
    * @param string $group The name of the group to check against
    * @param bool $recursive Check groups recursively
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return bool
    */
    public function inGroup($username, $group, $recursive = NULL, $isGUID = false)
    {
        if ($username === NULL) { return false; }
        if ($group === NULL) { return false; }
        if (!$this->adldap->getLdapBind()) { return false; }
        if ($recursive === NULL) { $recursive = $this->adldap->getRecursiveGroups(); } // Use the default option if they haven't set it
        
        // Get a list of the groups
        $groups = $this->groups($username, $recursive, $isGUID);
        
        // Return true if the specified group is in the group list
        if (in_array($group, $groups)) { 
            return true; 
        }

        return false;
    }
    
    /**
    * Determine a user's password expiry date
    * 
    * @param string $username The username to query
    * @param book $isGUID Is the username passed a GUID or a samAccountName
    * @requires bcmath http://www.php.net/manual/en/book.bc.php
    * @return array
    */
    public function passwordExpiry($username, $isGUID = false) 
    {
        if ($username === NULL) { return "Missing compulsory field [username]"; }
        if (!$this->adldap->getLdapBind()) { return false; }
        if (!function_exists('bcmod')) { throw new adLDAPException("Missing function support [bcmod] http://www.php.net/manual/en/book.bc.php"); };
        
        $userInfo = $this->info($username, array("pwdlastset", "useraccountcontrol"), $isGUID);
        $pwdLastSet = $userInfo[0]['pwdlastset'][0];
        $status = array();
        
        if ($userInfo[0]['useraccountcontrol'][0] == '66048') {
            // Password does not expire
            return "Does not expire";
        }
        if ($pwdLastSet === '0') {
            // Password has already expired
            return "Password has expired";
        }
        
         // Password expiry in AD can be calculated from TWO values:
         //   - User's own pwdLastSet attribute: stores the last time the password was changed
         //   - Domain's maxPwdAge attribute: how long passwords last in the domain
         //
         // Although Microsoft chose to use a different base and unit for time measurements.
         // This function will convert them to Unix timestamps
         $sr = ldap_read($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), 'objectclass=*', array('maxPwdAge'));
         if (!$sr) {
             return false;
         }
         $info = ldap_get_entries($this->adldap->getLdapConnection(), $sr);
         $maxPwdAge = $info[0]['maxpwdage'][0];
         

         // See MSDN: http://msdn.microsoft.com/en-us/library/ms974598.aspx
         //
         // pwdLastSet contains the number of 100 nanosecond intervals since January 1, 1601 (UTC), 
         // stored in a 64 bit integer. 
         //
         // The number of seconds between this date and Unix epoch is 11644473600.
         //
         // maxPwdAge is stored as a large integer that represents the number of 100 nanosecond
         // intervals from the time the password was set before the password expires.
         //
         // We also need to scale this to seconds but also this value is a _negative_ quantity!
         //
         // If the low 32 bits of maxPwdAge are equal to 0 passwords do not expire
         //
         // Unfortunately the maths involved are too big for PHP integers, so I've had to require
         // BCMath functions to work with arbitrary precision numbers.
         if (bcmod($maxPwdAge, 4294967296) === '0') {
            return "Domain does not expire passwords";
        }
        
        // Add maxpwdage and pwdlastset and we get password expiration time in Microsoft's
        // time units.  Because maxpwd age is negative we need to subtract it.
        $pwdExpire = bcsub($pwdLastSet, $maxPwdAge);
    
        // Convert MS's time to Unix time
        $status['expiryts'] = bcsub(bcdiv($pwdExpire, '10000000'), '11644473600');
        $status['expiryformat'] = date('Y-m-d H:i:s', bcsub(bcdiv($pwdExpire, '10000000'), '11644473600'));
        
        return $status;
    }
    
    /**
    * Modify a user
    * 
    * @param string $username The username to query
    * @param array $attributes The attributes to modify.  Note if you set the enabled attribute you must not specify any other attributes
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return bool
    */
    public function modify($username, $attributes, $isGUID = false)
    {
        if ($username === NULL) { return "Missing compulsory field [username]"; }
        if (array_key_exists("password", $attributes) && !$this->adldap->getUseSSL() && !$this->adldap->getUseTLS()) { 
            throw new adLDAPException('SSL/TLS must be configured on your webserver and enabled in the class to set passwords.');
        }

        // Find the dn of the user
        $userDn = $this->dn($username, $isGUID);
        if ($userDn === false) { 
            return false; 
        }
        
        // Translate the update to the LDAP schema                
        $mod = $this->adldap->adldap_schema($attributes);
        
        // Check to see if this is an enabled status update
        if (!$mod && !array_key_exists("enabled", $attributes)){ 
            return false; 
        }
        
        // Set the account control attribute (only if specified)
        if (array_key_exists("enabled", $attributes)){
            if ($attributes["enabled"]){ 
                $controlOptions = array("NORMAL_ACCOUNT"); 
            }
            else { 
                $controlOptions = array("NORMAL_ACCOUNT", "ACCOUNTDISABLE"); 
            }
            $mod["userAccountControl"][0] = $this->accountControl($controlOptions);
        }

        // Do the update
        $result = @ldap_modify($this->adldap->getLdapConnection(), $userDn, $mod);
        if ($result == false) { 
            return false; 
        }
        
        return true;
    }
    
    /**
    * Disable a user account
    * 
    * @param string $username The username to disable
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return bool
    */
    public function disable($username, $isGUID = false)
    {
        if ($username === NULL) { return "Missing compulsory field [username]"; }
        $attributes = array("enabled" => 0);
        $result = $this->modify($username, $attributes, $isGUID);
        if ($result == false) { return false; }
        
        return true;
    }
    
    /**
    * Enable a user account
    * 
    * @param string $username The username to enable
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return bool
    */
    public function enable($username, $isGUID = false)
    {
        if ($username === NULL) { return "Missing compulsory field [username]"; }
        $attributes = array("enabled" => 1);
        $result = $this->modify($username, $attributes, $isGUID);
        if ($result == false) { return false; }
        
        return true;
    }
    
    /**
    * Set the password of a user - This must be performed over SSL
    * 
    * @param string $username The username to modify
    * @param string $password The new password
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return bool
    */
    public function password($username, $password, $isGUID = false)
    {
        if ($username === NULL) { return false; }
        if ($password === NULL) { return false; }
        if (!$this->adldap->getLdapBind()) { return false; }
        if (!$this->adldap->getUseSSL() && !$this->adldap->getUseTLS()) { 
            throw new adLDAPException('SSL must be configured on your webserver and enabled in the class to set passwords.');
        }
        
        $userDn = $this->dn($username, $isGUID);
        if ($userDn === false) { 
            return false; 
        }
                
        $add=array();
        $add["unicodePwd"][0] = $this->encodePassword($password);
        
        $result = @ldap_mod_replace($this->adldap->getLdapConnection(), $userDn, $add);
        if ($result === false){
            $err = ldap_errno($this->adldap->getLdapConnection());
            if ($err) {
                $msg = 'Error ' . $err . ': ' . ldap_err2str($err) . '.';
                if($err == 53) {
                    $msg .= ' Your password might not match the password policy.';
                }
                throw new adLDAPException($msg);
            }
            else {
                return false;
            }
        }
        
        return true;
    }
    
    /**
    * Encode a password for transmission over LDAP
    *
    * @param string $password The password to encode
    * @return string
    */
    public function encodePassword($password)
    {
        $password="\"".$password."\"";
        $encoded="";
        for ($i=0; $i <strlen($password); $i++){ $encoded.="{$password{$i}}\000"; }
        return $encoded;
    }
     
    /**
    * Obtain the user's distinguished name based on their userid 
    * 
    * 
    * @param string $username The username
    * @param bool $isGUID Is the username passed a GUID or a samAccountName
    * @return string
    */
    public function dn($username, $isGUID=false)
    {
        $user = $this->info($username, array("cn"), $isGUID);
        if ($user[0]["dn"] === NULL) { 
            return false; 
        }
        $userDn = $user[0]["dn"];
        return $userDn;
    }
    
    /**
    * Return a list of all users in AD
    * 
    * @param bool $includeDescription Return a description of the user
    * @param string $search Search parameter
    * @param bool $sorted Sort the user accounts
    * @return array
    */
    public function all($includeDescription = false, $search = "*", $sorted = true)
    {
        if (!$this->adldap->getLdapBind()) { return false; }
        
        // Perform the search and grab all their details
        $filter = "(&(objectClass=user)(samaccounttype=" . adLDAP::ADLDAP_NORMAL_ACCOUNT .")(objectCategory=person)(cn=" . $search . "))";
        $fields = array("samaccountname","displayname");
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);

        $usersArray = array();
        for ($i=0; $i<$entries["count"]; $i++){
            if ($includeDescription && strlen($entries[$i]["displayname"][0])>0){
                $usersArray[$entries[$i]["samaccountname"][0]] = $entries[$i]["displayname"][0];
            } elseif ($includeDescription){
                $usersArray[$entries[$i]["samaccountname"][0]] = $entries[$i]["samaccountname"][0];
            } else {
                array_push($usersArray, $entries[$i]["samaccountname"][0]);
            }
        }
        if ($sorted) { 
            asort($usersArray); 
        }
        return $usersArray;
    }
    
    /**
    * Converts a username (samAccountName) to a GUID
    * 
    * @param string $username The username to query
    * @return string
    */
    public function usernameToGuid($username) 
    {
        if (!$this->adldap->getLdapBind()){ return false; }
        if ($username === null){ return "Missing compulsory field [username]"; }
        
        $filter = "samaccountname=" . $username; 
        $fields = array("objectGUID"); 
        $sr = @ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields); 
        if (ldap_count_entries($this->adldap->getLdapConnection(), $sr) > 0) { 
            $entry = @ldap_first_entry($this->adldap->getLdapConnection(), $sr); 
            $guid = @ldap_get_values_len($this->adldap->getLdapConnection(), $entry, 'objectGUID'); 
            $strGUID = $this->adldap->utilities()->binaryToText($guid[0]);          
            return $strGUID; 
        }
        return false; 
    }
    
    /**
    * Return a list of all users in AD that have a specific value in a field
    *
    * @param bool $includeDescription Return a description of the user
    * @param string $searchField Field to search search for
    * @param string $searchFilter Value to search for in the specified field
    * @param bool $sorted Sort the user accounts
    * @return array
    */
    public function find($includeDescription = false, $searchField = false, $searchFilter = false, $sorted = true){
        if (!$this->adldap->getLdapBind()){ return false; }
          
        // Perform the search and grab all their details
        $searchParams = "";
        if ($searchField) {
            $searchParams = "(" . $searchField . "=" . $searchFilter . ")";
        }                           
        $filter = "(&(objectClass=user)(samaccounttype=" . adLDAP::ADLDAP_NORMAL_ACCOUNT .")(objectCategory=person)" . $searchParams . ")";
        $fields = array("samaccountname","displayname");
        $sr = ldap_search($this->adldap->getLdapConnection(), $this->adldap->getBaseDn(), $filter, $fields);
        $entries = ldap_get_entries($this->adldap->getLdapConnection(), $sr);

        $usersArray = array();
        for ($i=0; $i < $entries["count"]; $i++) {
            if ($includeDescription && strlen($entries[$i]["displayname"][0]) > 0) {
                $usersArray[$entries[$i]["samaccountname"][0]] = $entries[$i]["displayname"][0];
            }
            else if ($includeDescription) {
                $usersArray[$entries[$i]["samaccountname"][0]] = $entries[$i]["samaccountname"][0];
            }
            else {
                array_push($usersArray, $entries[$i]["samaccountname"][0]);
            }
        }
        if ($sorted){ 
          asort($usersArray); 
        }
        return ($usersArray);
    }
    
    /**
    * Move a user account to a different OU
    *
    * @param string $username The username to move (please be careful here!)
    * @param array $container The container or containers to move the user to (please be careful here!).
    * accepts containers in 1. parent 2. child order
    * @return array
    */
    public function move($username, $container) 
    {
        if (!$this->adldap->getLdapBind()) { return false; }
        if ($username === null) { return "Missing compulsory field [username]"; }
        if ($container === null) { return "Missing compulsory field [container]"; }
        if (!is_array($container)) { return "Container must be an array"; }
        
        $userInfo = $this->info($username, array("*"));
        $dn = $userInfo[0]['distinguishedname'][0];
        $newRDn = "cn=" . $username;
        $container = array_reverse($container);
        $newContainer = "ou=" . implode(",ou=",$container);
        $newBaseDn = strtolower($newContainer) . "," . $this->adldap->getBaseDn();
        $result = @ldap_rename($this->adldap->getLdapConnection(), $dn, $newRDn, $newBaseDn, true);
        if ($result !== true) {
            return false;
        }
        return true;
    }
    
    /**
    * Get the last logon time of any user as a Unix timestamp
    * 
    * @param string $username
    * @return long $unixTimestamp
    */
    public function getLastLogon($username) {
        if (!$this->adldap->getLdapBind()) { return false; }
        if ($username === null) { return "Missing compulsory field [username]"; }
        $userInfo = $this->info($username, array("lastLogonTimestamp"));
        $lastLogon = adLDAPUtils::convertWindowsTimeToUnixTime($userInfo[0]['lastLogonTimestamp'][0]);
        return $lastLogon;
    }
    
}

class adLDAPUtils {
    const ADLDAP_VERSION = '4.0.4';
    
    /**
    * The current adLDAP connection via dependency injection
    * 
    * @var adLDAP
    */
    protected $adldap;
    
    public function __construct(adLDAP $adldap) {
        $this->adldap = $adldap;
    }
    
    
    /**
    * Take an LDAP query and return the nice names, without all the LDAP prefixes (eg. CN, DN)
    *
    * @param array $groups
    * @return array
    */
    public function niceNames($groups)
    {

        $groupArray = array();
        for ($i=0; $i<$groups["count"]; $i++){ // For each group
            $line = $groups[$i];
            
            if (strlen($line)>0) { 
                // More presumptions, they're all prefixed with CN=
                // so we ditch the first three characters and the group
                // name goes up to the first comma
                $bits=explode(",", $line);
                $groupArray[] = substr($bits[0], 3, (strlen($bits[0])-3));
            }
        }
        return $groupArray;    
    }
    
    /**
    * Escape characters for use in an ldap_create function
    * 
    * @param string $str
    * @return string
    */
    public function escapeCharacters($str) {
        $str = str_replace(",", "\,", $str);
        return $str;
    }
    
    /**
    * Escape strings for the use in LDAP filters
    * 
    * DEVELOPERS SHOULD BE DOING PROPER FILTERING IF THEY'RE ACCEPTING USER INPUT
    * Ported from Perl's Net::LDAP::Util escape_filter_value
    *
    * @param string $str The string the parse
    * @author Port by Andreas Gohr <andi@splitbrain.org>
    * @return string
    */
    public function ldapSlashes($str){
        return preg_replace('/([\x00-\x1F\*\(\)\\\\])/e',
                            '"\\\\\".join("",unpack("H2","$1"))',
                            $str);
    }
    
    /**
    * Converts a string GUID to a hexdecimal value so it can be queried
    * 
    * @param string $strGUID A string representation of a GUID
    * @return string
    */
    public function strGuidToHex($strGUID) 
    {
        $strGUID = str_replace('-', '', $strGUID);

        $octet_str = '\\' . substr($strGUID, 6, 2);
        $octet_str .= '\\' . substr($strGUID, 4, 2);
        $octet_str .= '\\' . substr($strGUID, 2, 2);
        $octet_str .= '\\' . substr($strGUID, 0, 2);
        $octet_str .= '\\' . substr($strGUID, 10, 2);
        $octet_str .= '\\' . substr($strGUID, 8, 2);
        $octet_str .= '\\' . substr($strGUID, 14, 2);
        $octet_str .= '\\' . substr($strGUID, 12, 2);
        //$octet_str .= '\\' . substr($strGUID, 16, strlen($strGUID));
        for ($i=16; $i<=(strlen($strGUID)-2); $i++) {
            if (($i % 2) == 0) {
                $octet_str .= '\\' . substr($strGUID, $i, 2);
            }
        }
        
        return $octet_str;
    }
    
    /**
    * Convert a binary SID to a text SID
    * 
    * @param string $binsid A Binary SID
    * @return string
    */
     public function getTextSID($binsid) {
        $hex_sid = bin2hex($binsid);
        $rev = hexdec(substr($hex_sid, 0, 2));
        $subcount = hexdec(substr($hex_sid, 2, 2));
        $auth = hexdec(substr($hex_sid, 4, 12));
        $result = "$rev-$auth";

        for ($x=0;$x < $subcount; $x++) {
            $subauth[$x] =
                hexdec($this->littleEndian(substr($hex_sid, 16 + ($x * 8), 8)));
                $result .= "-" . $subauth[$x];
        }

        // Cheat by tacking on the S-
        return 'S-' . $result;
     }
     
    /**
    * Converts a little-endian hex number to one that hexdec() can convert
    * 
    * @param string $hex A hex code
    * @return string
    */
     public function littleEndian($hex) 
     {
        $result = '';
        for ($x = strlen($hex) - 2; $x >= 0; $x = $x - 2) {
            $result .= substr($hex, $x, 2);
        }
        return $result;
     }
     
     /**
    * Converts a binary attribute to a string
    * 
    * @param string $bin A binary LDAP attribute
    * @return string
    */
    public function binaryToText($bin) 
    {
        $hex_guid = bin2hex($bin); 
        $hex_guid_to_guid_str = ''; 
        for($k = 1; $k <= 4; ++$k) { 
            $hex_guid_to_guid_str .= substr($hex_guid, 8 - 2 * $k, 2); 
        } 
        $hex_guid_to_guid_str .= '-'; 
        for($k = 1; $k <= 2; ++$k) { 
            $hex_guid_to_guid_str .= substr($hex_guid, 12 - 2 * $k, 2); 
        } 
        $hex_guid_to_guid_str .= '-'; 
        for($k = 1; $k <= 2; ++$k) { 
            $hex_guid_to_guid_str .= substr($hex_guid, 16 - 2 * $k, 2); 
        } 
        $hex_guid_to_guid_str .= '-' . substr($hex_guid, 16, 4); 
        $hex_guid_to_guid_str .= '-' . substr($hex_guid, 20); 
        return strtoupper($hex_guid_to_guid_str);   
    }
    
    /**
    * Converts a binary GUID to a string GUID
    * 
    * @param string $binaryGuid The binary GUID attribute to convert
    * @return string
    */
    public function decodeGuid($binaryGuid) 
    {
        if ($binaryGuid === null){ return "Missing compulsory field [binaryGuid]"; }
        
        $strGUID = $this->binaryToText($binaryGuid);          
        return $strGUID; 
    }
    
    /**
    * Convert a boolean value to a string
    * You should never need to call this yourself
    *
    * @param bool $bool Boolean value
    * @return string
    */
    public function boolToStr($bool) 
    {
        return ($bool) ? 'TRUE' : 'FALSE';
    }
    
    /**
    * Convert 8bit characters e.g. accented characters to UTF8 encoded characters
    */
    public function encode8Bit(&$item, $key) {
        $encode = false;
        if (is_string($item)) {
            for ($i=0; $i<strlen($item); $i++) {
                if (ord($item[$i]) >> 7) {
                    $encode = true;
                }
            }
        }
        if ($encode === true && $key != 'password') {
            $item = utf8_encode($item);   
        }
    }  
    
    /**
    * Get the current class version number
    * 
    * @return string
    */
    public function getVersion() {
        return self::ADLDAP_VERSION;
    }
    
    /**
    * Round a Windows timestamp down to seconds and remove the seconds between 1601-01-01 and 1970-01-01
    * 
    * @param long $windowsTime
    * @return long $unixTime
    */
    public static function convertWindowsTimeToUnixTime($windowsTime) {
      $unixTime = round($windowsTime / 10000000) - 11644477200; 
      return $unixTime; 
    }
}



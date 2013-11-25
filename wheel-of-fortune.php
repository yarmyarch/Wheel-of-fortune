<?php
/*
Plugin Name: Wheel of fortune
Description: A brief description of the Plugin.
Version: 1.0.0
Author: yarmyarch
Author URI: t.yarmyarch.com
License: GPL2
*/

class WheelOfFortune {

    public static $SHOW_NAME_AS = array("user_login", "display_name");

    public $pluginUrl;
    
    // members with posts/commments
    public $memberList;
    // actived categories for members with posts/comments
    public $activedCategories;
    // all registed members
    public $fullMemberList;
    
    public $userList;
    public $winnerId;
    
    // combined user data, for all wheels. include $userList (selected users that was stored in DB) and winnerId.
    public $wheelNameList;
    public $currentWheelName;
    
    // configurations that would be used in the control panel
    private $maxMemberCount;
    private $memberPerLayer;
    private $startRadius;
    private $radiusRange;
    private $leafScale;
    private $animationDuiton;
    private $showNameAs;
    private $memberFrom;

    function __construct() {
        
        // private attributes here.
        $this->pluginUrl = plugin_dir_url( __FILE__ );
        
        load_plugin_textdomain('wheel-of-fortune', false, basename( dirname( __FILE__ ) ) . '/languages' );
        
        // add menu actions.
        add_action( 'admin_menu', array(&$this, 'adminMenu' ));
        
        // add short code.
        add_shortcode('wheel-of-fortune', array(&$this, 'short_code_handler' ));
        
        $this->activedCategories = array();
        $this->wheelNameList = array();
    }
    
    public function adminMenu() {
    
        add_options_page( __('wheel of fortune - custom settings'), __('wheel of fortune'), 'manage_options', 'wheel-of-fortune', array(&$this, 'wofSetting' ));
    }
    
    /**
     * @param attr["name"] wheel name, choose which wheel to display.
     */
    public function short_code_handler($attr) {
        
        $this->doInit($attr["name"]);
        
        $this->clearUserList();
        
        ob_start();
        include_once("template/frame.php");
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    
    public function wofSetting() {
            
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        
        // update and validate saved options.
        if (isset($_POST["isSubmit"]) && $_POST["isSubmit"] = 1) {
        
            $wheelName = $_POST["wheelName"];
            
            if ($_POST["choosedMembers"] != "") {
                update_option("yarUserList_".$wheelName, $_POST["choosedMembers"]);
            }
            if (isset($_POST["memberFrom"])) {
                update_option("yarMemberFrom", $_POST["memberFrom"]);
            }
            if (isset($_POST["maxMember"]) && $_POST["maxMember"] >= 2) {
                update_option("yarMaxMemberCount", $_POST["maxMember"]);
            }
            if (isset($_POST["mpLayer"]) && $_POST["mpLayer"] >= 2) {
                update_option("yarMemberPerLayer", $_POST["mpLayer"]);
            }
            if (isset($_POST["startRadius"]) && $_POST["startRadius"] >= 0) {
                update_option("yarStartRadius", $_POST["startRadius"]);
            }
            if (isset($_POST["radiusRange"]) && $_POST["radiusRange"] >= 0) {
                update_option("yarRadiusRange", $_POST["radiusRange"]);
            }
            if (isset($_POST["duration"]) && $_POST["duration"] > 0) {
                update_option("yarAnimationDuration", $_POST["duration"]);
            }
            if (isset($_POST["usernameAs"]) && $_POST["usernameAs"] > 0) {
                update_option("yarShowNameAs", $_POST["usernameAs"]);
            }
            if (isset($_POST["clearWinner"]) && $_POST["clearWinner"] == 1) {
                update_option("yarWheelWinnerId_".$wheelName, "");
            }
        } elseif (isset($_GET["name"]) && $_GET["name"] != "" && empty($_GET["delete"])) {
            // add new wheel
            $wheelName = $_GET["name"];
            $wheelName = preg_replace("/\W/", "", $wheelName);
            // max 16 chars
            $wheelName = substr($wheelName, 0, 16);
            
            // check if not exist, then add it.
            $wheelList = get_option("yarWheelWinnerId_".$wheelName);
            if (empty($wheelList)) {
                $wheelList = get_option("yarWheelList");
                $wheelList = split(",", $wheelList);
                $wheelList[] = $wheelName;
                $wheelList = array_unique($wheelList);
                $wheelList = join(",", $wheelList);
                $wheelList = preg_replace("/,+/", ",", $wheelList);
                update_option("yarWheelList", $wheelList);
            }
        } elseif (isset($_GET["name"]) && $_GET["name"] != "" && isset($_GET["delete"]) && $_GET["delete"] == 1) {
            // delete a existing wheel.
            $wheelName = $_GET["name"];
            $wheelName = preg_replace("/\W/", "", $wheelName);
            $wheelName = substr($wheelName, 0, 16);
            delete_option("yarWheelWinnerId_".$wheelName);
            delete_option("yarUserList_".$wheelName);
            
            $wheelList = get_option("yarWheelList");
            $wheelList = preg_replace($wheelName, "", $wheelList);
            $wheelList = preg_replace("/,+/", ",", $wheelList);
            update_option("yarWheelList", $wheelList);
            
            $wheelName = "Default";
        } else {
            $wheelName = "Default";
        }
        
        $this->doInit($wheelName);
        $this->getFullMembers();
        
        include_once("template/admin.php");
    }
    
    // init for user page
    public function init($wheelName = "Default") {
        
        // public data fields for both pages such as user list and winner only.
        $this->doInit($wheelName);
        
        $this->clearUserList();
        
        // output html code here.
        include_once("template/frame.php");
    }
    
    // clear user list if the max number of user count is smaller than exsiting users,
    // and add current actived user to the list.
    private function clearUserList() {
        
        $indexedUsers = array();
        foreach($this->userList as $userId=>$user) {
            $indexedUsers[] = $userId;
        }
        
        $currentId = -1;
        
        if (is_user_logged_in()) {
            $currentUser = wp_get_current_user();
            $currentId = $currentUser->ID;
        }
        
        // generate sevral random id
        $maxMemberCount = $this->maxMemberCount;
        
        shuffle($indexedUsers);
        array_splice($indexedUsers, 0, count($indexedUsers) - $maxMemberCount);
        
        $newUserList = array();
        foreach ($indexedUsers as $userId) {
            $newUserList[$userId] = $this->userList[$userId];
        }
        
        if (empty($newUserList[$this->winnerId])) {
            $newUserList[$this->winnerId] = $this->userList[$this->winnerId];
        }
        // insert current logged user if it's not in the user list.
        if ($currentId != -1 && empty($newUserList[$currentId])) {
            $newUserList[$currentId] = $currentUser->{WheelOfFortune::$SHOW_NAME_AS[$this->showNameAs]};
        }
        $this->userList = $newUserList;
    }
    
    private function getPCMembers() {
    
        global $wpdb;
        $memberList = $wpdb->get_results('SELECT DISTINCT u.ID as user_id, u.user_login, u.display_name, date(u.user_registered) as r_date, a.date as a_date FROM '.$wpdb->prefix.'users as u right join (
            SELECT d.user_id, max(d.date) as date from (
                SELECT user_id, max(date(comment_date)) as date from '.$wpdb->prefix.'comments group by user_id
                    union
                SELECT post_author, max(date(post_modified)) as date from '.$wpdb->prefix.'posts group by post_author
            ) as d group by d.user_id
        ) as a on u.ID=a.user_id where not isNull(u.ID) order by date desc;');
        
        $activeList = $wpdb->get_results('
            SELECT DISTINCT d.user_id, d.post_id from (
                SELECT DISTINCT user_id, comment_post_id as post_id from '.$wpdb->prefix.'comments
                    union
                SELECT DISTINCT post_author, ID as post_id from '.$wpdb->prefix.'posts
            ) as d where not isNull(d.user_id) order by d.user_id;');
        
        $catBuf = array();
        $category;
        foreach ($activeList as $active) {
            if (!isset($catBuf[$active->post_id])) {
                $category = get_the_category($active->post_id);
                $catBuf[$active->post_id] = $category = $category[0];
            }
            if (!isset($this->activedCategories[$category->cat_ID]["members"])) $this->activedCategories[$category->cat_ID]["members"] = array();
            if (isset($category->cat_ID) && $category->cat_ID != "") {
                $this->activedCategories[$category->cat_ID]["members"][] = $active->user_id;
                $this->activedCategories[$category->cat_ID]["catData"] = $category;
            }
        }
        
        return $this->memberList = $memberList;
    }
    
    private function getFullMembers() {
        
        global $wpdb;
        $memberList = $wpdb->get_results('SELECT DISTINCT u.ID as user_id, u.user_login, u.display_name, u.user_registered as r_date FROM '.$wpdb->prefix.'users as u;');
        return $this->fullMemberList = $memberList;
    }
    
    private function initUserList() {
        
        $userList = get_option("yarUserList_".$this->currentWheelName);
        $this->getPCMembers();
        
        // use posted/commented users for the default
        if (empty($userList)) {
            $choosedMemberList = $this->memberList;
            $optionIsEmpty = true;
        } else {
            global $wpdb;
            $choosedMemberList = $wpdb->get_results('SELECT DISTINCT u.ID as user_id, u.user_login, u.display_name, u.user_registered as r_date FROM '.$wpdb->prefix.'users as u where u.ID in ('.$userList.');');
        }
        
        // write option
        $userList = array();
        foreach($choosedMemberList as $member) {
            $this->userList[$member->user_id] = $member->{WheelOfFortune::$SHOW_NAME_AS[$this->showNameAs]};
            $userList[] = $member->user_id;
        }
        
        if ($optionIsEmpty) {
            update_option("yarUserList_".$this->currentWheelName, join(",", $userList));
        }
    }
    
    private function initWheelNameList() {
        
        $wheelList = get_option("yarWheelList");
        $wheelList = split(",", $wheelList);
        // always include the default one.
        $wheelList[] = "Default";
        $wheelList = array_unique($wheelList);
        
        $success = false;
        foreach($wheelList as $wheelName) {
            if ($wheelName != "") $this->wheelNameList[$wheelName] = array();
            if ($this->currentWheelName == $wheelName) $success = true;
        }
        
        // if current wheel name doesn't exist, return "Default" instead.
        return $success ? $this->currentWheelName : "Default";
    }
    
    private function doInit($wheelName = "Default") {
        
        $this->currentWheelName = $wheelName;
        
        $this->maxMemberCount = get_option("yarMaxMemberCount", 40);
        $this->memberPerLayer = get_option("yarMemberPerLayer", 10);
        $this->startRadius = get_option("yarStartRadius", 48);
        $this->radiusRange = get_option("yarRadiusRange", 64);
        $this->leafScale = get_option("yarLeafScale", 1.2);
        $this->animationDuration = get_option("yarAnimationDuration", 10000);
        $this->showNameAs = get_option("yarShowNameAs", 0);
        $this->memberFrom = get_option("yarMemberFrom", 0);
        
        // init wheelNameList.
        $this->currentWheelName = $wheelName = $this->initWheelNameList();
        
        $this->initUserList();
        $winner = get_option("yarWheelWinnerId_".$wheelName);
        // if the winner removed from the user list, regenerate another winner.
        if (isset($_GET["clear"]) || empty($this->userList[$winner])) {
            $winner = false;
        }
        
        $indexedUsers = array();
        foreach($this->userList as $userId=>$user) {
            $indexedUsers[] = $userId;
        }
        
        if (!$winner) {
            $winner = $indexedUsers[rand(0, count($this->userList) - 1)];
            update_option("yarWheelWinnerId_".$wheelName, $winner);
        }
        
        $this->winnerId = $winner;
    }
}

$yarWof = new WheelOfFortune();

?>
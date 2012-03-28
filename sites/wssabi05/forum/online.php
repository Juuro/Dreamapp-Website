<?php
@$userdata = session_pagestart($user_ip, PAGE_INDEX, $session_length); 
@init_userprefs($userdata); 

$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_ip 
           FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s 
           WHERE u.user_id = s.session_user_id 
                      AND s.session_time >= ".( time() - 300 ) . "
           ORDER BY u.username ASC, s.session_ip ASC"; 
$result = $db->sql_query($sql); 
if(!$result) 
{ 
   message_die(GENERAL_ERROR, "Couldn't obtain user/online information.", "", __LINE__, __FILE__, $sql); 
} 

$userlist_ary = array(); 
$userlist_visible = array(); 

$logged_visible_online = 0; 
$logged_hidden_online = 0; 
$guests_online = 0; 
$online_userlist = ""; 

$prev_user_id = 0; 
$prev_session_ip = 0; 

while( $row = $db->sql_fetchrow($result) ) 
{ 
        if( $row['session_logged_in'] ) 
        { 
                if( $row['user_id'] != $prev_user_id ) 
                { 
                        $style_color = ""; 
                        if( $row['user_level'] == ADMIN ) 
                        { 
                                $row['username'] = '<b>' . $row['username'] . '</b>'; 
                                $style_color = 'style="color:#' . $theme['fontcolor3'] . '"'; 
                        } 
                        else if( $row['user_level'] == MOD ) 
                        { 
                                $row['username'] = '<b>' . $row['username'] . '</b>'; 
                                $style_color = 'style="color:#' . $theme['fontcolor2'] . '"'; 
                        } 

                        if( $row['user_allow_viewonline'] ) 
                        { 
                                $user_online_link = '<a href="' . append_sid($phpbb_root_path."profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'>' . $row['username'] . '</a>'; 
                                $logged_visible_online++; 
                        } 
                        else 
                        { 
                                $user_online_link = '<a href="' . append_sid($phpbb_root_path."profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'><i>' . $row['username'] . '</i></a>'; 
                                $logged_hidden_online++; 
                        } 
          
                        if( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN ) 
                        { 
                                $online_userlist .= ( $online_userlist != "" ) ? ", " . $user_online_link : $user_online_link; 
                        } 
                } 
        } 
        else 
        { 
                if( $row['session_ip'] != $prev_session_ip )
                {
                        $guests_online++; 
                }  
        } 

        $prev_user_id = $row['user_id']; 
        $prev_session_ip = $row['session_ip']; 
} 

if( empty($online_userlist) ) 
{ 
   $online_userlist = $lang['None']; 
} 
$online_userlist = ( ( isset($forum_id) ) ? $lang['Browsing_forum'] : $lang['Registered_users'] ) . " " . $online_userlist; 
$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online; 

if( $total_online_users == 0 ) 
{ 
        $l_t_user_s = $lang['Online_users_zero_total']; 
} 
else if( $total_online_users == 1 ) 
{ 
        $l_t_user_s = $lang['Online_user_total']; 
} 
else 
{ 
        $l_t_user_s = $lang['Online_users_total']; 
} 

if( $logged_visible_online == 0 ) 
{ 
        $l_r_user_s = $lang['Reg_users_zero_total']; 
} 
else if( $logged_visible_online == 1 ) 
{ 
        $l_r_user_s = $lang['Reg_user_total']; 
} 
else 
{ 
        $l_r_user_s = $lang['Reg_users_total']; 
} 

if( $logged_hidden_online == 0 ) 
{ 
        $l_h_user_s = $lang['Hidden_users_zero_total']; 
} 
else if( $logged_hidden_online == 1 ) 
{ 
        $l_h_user_s = $lang['Hidden_user_total']; 
} 
else 
{ 
        $l_h_user_s = $lang['Hidden_users_total']; 
} 

if( $guests_online == 0 ) 
{ 
        $l_g_user_s = $lang['Guest_users_zero_total']; 
} 
else if( $guests_online == 1 ) 
{ 
        $l_g_user_s = $lang['Guest_user_total']; 
} 
else 
{ 
        $l_g_user_s = $lang['Guest_users_total']; 
} 

$l_online_users = sprintf($l_t_user_s, $total_online_users); // all users
$l_online_users .= sprintf($l_r_user_s, $logged_visible_online); // visible users
$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online); // hidden users
$l_online_users .= sprintf($l_g_user_s, $guests_online);  // guests

$onlinet="$l_online_users<br>$online_userlist<br>"; 
echo $onlinet;
?>
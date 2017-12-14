<?php
/**
 * 简述
 *
 * 详细说明(可略)
 *
 * @copyright Copyright&copy; 2016, Meizu.com
 * @author   zouzehua <zouzehua@meizu.com>
 * @version $Id: LdapModel.class.php, v ${VERSION} 2016-9-23 14:17 Exp $
 */

namespace Yboard;

class LdapModel {
    public $connect;
    public $db;
    public $base;

    public function __construct(&$base) {
        $this->base    = $base;
        $this->db      = isset($base->db) ? $base->db : null;
        $this->connect = ldap_connect(LDAP_HOST);
    }

    /**
     * 绑定用户,查询是否有效
     * @param $username
     * @param $password
     * @return int
     */
    public function bind($username, $password) {
        if ($this->connect) {
            ldap_set_option($this->connect, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($this->connect, LDAP_OPT_REFERRALS, 0);
            $username .= LDAP_EMAIL;
            $bind = @ldap_bind($this->connect, $username, $password);

            return $bind ? 1 : -2;
        } else {
            return -1;
        }
    }

    /**
     * 关闭连接
     */
    public function closeConnect() {
        ldap_close($this->connect);
    }

    /**
     * 获取用户信息
     * @param $email
     * @return array|bool
     */
    public function getUserInfo($email) {
        if (!$this->connect) {
            return false;
        }

        $base_dn = 'DC=meizu,DC=com';
        $filter  = '(mail=' . $email . ')';
//        $attr    = ['employeeid', 'mail', 'displayname', 'name']; //指定返回属性
        $attr = []; //指定返回属性
        $read = ldap_search($this->connect, $base_dn, $filter, $attr, 0, 0, 0);
        if (!$read) {
            return false;
        }

        $user_info = ldap_get_entries($this->connect, $read);
        if (!$user_info || $user_info['count'] < 1) {
            return false;
        }
        $return = [];
        for ($i = 0; $i < $user_info["count"]; $i++) {
            $return['employeeid']  = $user_info[$i]["employeeid"][0];
            $return['mail']        = $user_info[$i]["mail"][0];
            $return['displayname'] = $user_info[$i]["displayname"][0];
            $return['name']        = $user_info[$i]["name"][0];
//            $return['department']  = $user_info[$i]["department"][0];
            $return['mobile']      = $user_info[$i]["mobile"][0];
            $return['title']       = $user_info[$i]["title"][0];
            $return['department']  = $user_info[$i]["distinguishedname"][0];

            if (!empty($return['department'])) {
                $tmp     = explode(',', $return['department']);
                $pattern = '/OU=(.*)/';

                $tmp1 = [];
                foreach ($tmp as $val) {
                    if (preg_match($pattern, $val, $match)) {
                        array_unshift($tmp1, $match[1]);
                    }
                }
                $return['department'] = implode('-', $tmp1);
            }
        }

        return $return;
    }
}
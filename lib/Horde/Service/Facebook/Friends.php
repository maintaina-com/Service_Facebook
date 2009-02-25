<?php
/**
 * Friends methods for Horde_Service_Facebook
 *
 * Copyright 2009 The Horde Project (http://www.horde.org)
 *
 * @author Michael J. Rubinsky <mrubinsk@horde.org>
 * @category Horde
 * @package Horde_Service_Facebook
 */
class Horde_Servce_Facebook_Friends extends Horde_Service_Facebook_Base
{
    /**
     * Returns whether or not pairs of users are friends.
     * Note that the Facebook friend relationship is symmetric.
     *
     * @param string $uids1  comma-separated list of ids (id_1, id_2,...)
     *                       of some length X
     * @param string $uids2  comma-separated list of ids (id_A, id_B,...)
     *                       of SAME length X
     *
     * @return array  An array with uid1, uid2, and bool if friends, e.g.:
     *   array(0 => array('uid1' => id_1, 'uid2' => id_A, 'are_friends' => 1),
     *         1 => array('uid1' => id_2, 'uid2' => id_B, 'are_friends' => 0)
     *         ...)
     * @error
     *    API_EC_PARAM_USER_ID_LIST
     */
    public function &areFriends($uids1, $uids2)
    {
        // Session key is *required*
        if (!$this->_facebook->auth->getSessionKey()) {
            throw new Horde_Service_Facebook_Exception('session_key is required',
                                               Horde_Service_Facebook_ErrorCodes::API_EC_SESSION_REQUIRED);
        }

        return $this->_facebook->call_method('facebook.friends.areFriends',
            array('uids1' => $uids1,
                  'uids2' => $uids2,
                  'session_key' => $this->_facebook->auth->getSessionKey()));
    }

    /**
     * Returns the friends of the current session user.
     *
     * @param int $flid  (Optional) Only return friends on this friend list.
     * @param int $uid   (Optional) Return friends for this user.
     *
     * @return array  An array of friends
     */
    public function &get($flid = null, $uid = null)
    {
        // Session key is *required*
        if (!$this->_facebook->auth->getSessionKey()) {
            throw new Horde_Service_Facebook_Exception('session_key is required',
                                               Horde_Service_Facebook_ErrorCodes::API_EC_SESSION_REQUIRED);
        }
        $params = array();
        if ($uid) {
          $params['uid'] = $uid;
        }
        if ($flid) {
          $params['flid'] = $flid;
        }

        return $this->_facebook->call_method('facebook.friends.get', $params);
    }

    /**
     * Returns the set of friend lists for the current session user.
     *
     * @return array  An array of friend list objects
     */
    public function &getLists()
    {
        // Session key is *required*
        if (!$this->_facebook->auth->getSessionKey()) {
            throw new Horde_Service_Facebook_Exception('session_key is required',
                                               Horde_Service_Facebook_ErrorCodes::API_EC_SESSION_REQUIRED);
        }
        return $this->_facebook->call_method('facebook.friends.getLists',
             array('session_key' => $this->_facebook->auth->getSessionKey()));
    }

}
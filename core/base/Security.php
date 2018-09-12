<?php

class Security
{
    /** Check if the user in Session has any rol
     * @param $roles
     * @return bool
     */
    static function hasSomeRol($roles)
    {
        $f3 = \Base::instance();
        if (is_array($roles) && is_array($f3->get('SESSION.roles'))) {
            foreach ($roles as $rol) {
                if (array_search($rol, $f3->get('SESSION.roles')) !== false) {
                    return true;
                }
            }
        } else if (is_array($roles) && !is_array($f3->get('SESSION.roles'))) {

            if (array_search($f3->get('SESSION.roles'), $roles) !== false) {
                return true;
            } else {
                return false;
            }
        } else if (!is_array($roles) && is_array($f3->get('SESSION.roles'))) {
            if (array_search($roles, $f3->get('SESSION.roles')) !== false) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($f3->get('SESSION.roles') == $roles) {
                return true;
            }
        }
        return false;
    }

    /** All roles must be equal to the sesssion
     * @param $roles
     * @return bool
     */
    static function hasRol($roles)
    {
        $f3 = \Base::instance();
        if (is_array($roles) && is_array($f3->get('SESSION.roles'))) {
            $differenceFirst = array_diff($roles,$f3->get('SESSION.roles'));
            $differenceLast = array_diff($f3->get('SESSION.roles'), $roles);
            if (count($differenceFirst) == 0 && count($differenceLast) == 0) {
                return true;
            }
        } else if (!is_array($roles) && !is_array($f3->get('SESSION.roles'))) {
            if ($f3->get('SESSION.roles') == $roles) {
                return true;
            }
        }
        return false;
    }
}
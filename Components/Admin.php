<?php

/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 11.05.2016
 * Time: 22:31
 */
class Admin {

    public function __construct() {
        if (UserModel::checkAuthenticatedSession()) {
            if (!UserModel::checkAdmin()) {
                exit('Access Denied!!!');
            }
        }
    }
}
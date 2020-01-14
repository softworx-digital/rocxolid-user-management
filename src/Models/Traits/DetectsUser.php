<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Auth;

trait DetectsUser
{
    private $_rx_user = null;

    public function detectRxUser()
    {
        if (is_null($this->_rx_user)) {
            $this->_rx_user = Auth::guard('rocXolid')->user() ?: false;
        }

        return $this->_rx_user;
    }
}

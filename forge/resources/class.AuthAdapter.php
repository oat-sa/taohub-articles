<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2013 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *
 *
 */

use oat\authLdap\model\LdapAdapter;

/**
 * Authentication adapter interface to be implemented by authentication methods
 *
 * @access public
 * @author Joel Bout, <joel@taotesting.com>
 * @package generis

 */
class core_kernel_users_AuthAdapter
    extends LdapAdapter
	implements common_user_auth_Adapter
{
    CONST LEGACY_ALGORITHM = 'md5';
    CONST LEGACY_SALT_LENGTH = 0;

    /**
     * Returns the hashing algorithm defined in generis configuration
     *
     * @return helpers_PasswordHash
     */
    public static function getPasswordHash() {
        return new helpers_PasswordHash(
            defined('PASSWORD_HASH_ALGORITHM') ? PASSWORD_HASH_ALGORITHM : self::LEGACY_ALGORITHM,
            defined('PASSWORD_HASH_SALT_LENGTH') ? PASSWORD_HASH_SALT_LENGTH : self::LEGACY_SALT_LENGTH
        );
    }

	/**
	 *
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username, $password) {
	    parent::__construct(array(
            'config' => array(
                array(
                    'host' => '127.0.0.1',
                    'accountDomainName' => 'test.com',
                    'username' => 'cn=admin,dc=test,dc=com',
                    'password' => 'admin',
                    'baseDn' => 'OU=organisation,dc=test,dc=com',
                    'bindRequiresDn' => 'true'
                )
            ),
	        'mapping' => array()
        ));
	    $this->setCredentials($username, $password);
	}

}
<?php

namespace Edu\Cnm\DataDesign;
require_once ("autoload.php");
/**
 *Cross section of an Etsy like Profile
 *
 *This is a cross section for a profile and the info stored in a similar way on Etsy.
 *
 * This entity is a high level entity with keys to other entities int the code
 *
 * @author Marcus Lester <mlester3@cnm.edu>
 * @version 7.1.0
 **/

class Profile implements  \JsonSerializable {
	/**
	 * id for this profile; this is the primary key
	 * @var int $profileId
	 *
	 **/

	private $profileId;

	/**
	 *this is the at handle for this profile; this key is unique
	 *@var string $profileAtHandle
	 **/

	private $profileAtHandle;

	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 * @var $profileActivationToken
	 **/

	private $ActivationToken;

	/**
	 * the email used to create this profile; this is a unique index
	 * @var string $profileEmail
	 **/

	private $profileEmail;

	/**
	 * this is the hash for this profiles password
	 * @var @profileHash
	 **/

	private $profileHash;

	/**
	 * phone number for this profile
	 * @var string$profilePhone
	 **/

	private $profilePhone;

	/**
	 * salt for profile password
	 * \@var $profileSalt
	 */

	private $profileSalt
}
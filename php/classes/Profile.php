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

class Profile implements \JsonSerializable {
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

	private $profileActivationToken;

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
	 * @var string $profilePhone
	 **/

	private $profilePhone;

	/**
	 * salt for profile password
	 * \@var $profileSalt
	 */

	private $profileSalt;
	/**
	 * this is our profiles constructor
	 *
	 * @param int|null $newProfileId id of this Profile or null of a new Profile
	 * @param string $newProfileActivationToken is the activation token to safe guard against malicious accounts
	 * @param string $newProfileAtHandle string contains the new at handle
	 * @param string $newProfileEmail string containing email
	 * @param string $newProfileHash string contains the password hash
	 * @param string $$newProfilePhone this string contains the phone number
	 * @param string $newProfileSalt this string contains password salt
	 * @throws \InvalidArgumentException if data values arenot valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data tpes violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileId, ?string $newProfileActivationToken, ?string $newProfieActivationToken, ?string $newProfileAtHandle, string $newProfileEmail, string $newProfileHash, ?string $newProfilePhone, string $newProfileSalt) {
			try {
					$this->setProfileId($newProfileId);
					$this->setProfileActivationToken($newProfileActivationToken);
					$this->setProfileAtHandle($newProfileAtHandle);
					$this->setProfileEmail($newProfileEmail);
					$this->setProfileHash($newProfileHash);
					$this->setProfilePhone($newProfilePhone);
					$this->setProfileSalt($newProfileSalt);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $excpetion) {
				//determine what exception is thrown
				$exceptionType = get_class(exception);
				throw(new $exceptionType($exception->getMessage("message that goes here"), 0, $exception));
		}
}

/** accessor method for profile id
 *
 * @return int value of profile id (or null if new Profile)
 **/
public function getProfileId(): int {
			return ($this->profileId);
}

/**
 * mutator method for profile id
 *
 * @param int|null $newprofileId value of new profile id
 * @throws \RangeException if $newProfileId is not positive
 * @throws |TypeError if $newProfileId is not an integer
 **/
public function setProfileId(?int $newprofileId): void {
			if($newprofileId === null) {
				$this->profileId = null:
				return;
			}

			// verify the profile id is Positive
			If($newprofileId <= 0) {
					throw(new \RangeException("profile id is not psoitive"));
			}

			// convert and store the profile id
			$this->profileId = $newprofileId;


}

/** accessor method for account activation token
 *
 @return string value of the activation token
 */
public function getProfileActivationToken(): string {
			return ($this->profileActivationToken);
}

/**
 * mutator method for account activation token
 *
 * @param string $newProfileActivationToken
 * @throws \InvalidArgumentException if the token is not a string or insecure
 * @throws \RangeException if the token is not exactly 32 characters long
 * @throws \TypeError if the activation token is not a string
 */
public function setProfileActivationToken(?string $newProfileActivtionToken): void {
			if($newProfileActivtionToken === null)
}
}
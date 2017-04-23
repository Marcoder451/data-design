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
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				//determine what exception is thrown
				$exceptionType = get_class($exception);
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
public function setProfileId(?int $newProfileId): void {
			if($newProfileId === null) {
				$this->profileId = null;
				return;
			}

			// verify the profile id is Positive
			If($newProfileId <= 0) {
					throw(new \RangeException("profile id is not positive"));
			}

			// convert and store the profile id
			$this->profileId = $newProfileId;


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
public function setProfileActivationToken(?string $newProfileActivationToken): void {
			if($newProfileActivationToken === null) {
						$this->$newProfileActivationToken = null;
				return;
			}

			$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
			if(ctype_xdigit($newProfileActivationToken) === false) {
						throw(new \RangeException("user activation is not valid"));
			}

			// make sure user activation token is only 32 characters
			if(strlen($newProfileActivationToken) !== 32) {
				throw(new\RangeException("user activation token has to be 32"));
			}
			$this->profileActivationToken = $newProfileActivationToken;
		}


		/**
		 * accessor method for at handle
		 *
		 * @return string value of at handle
		 **/
		public function  getProfileAtHandle(): string {
					return ($this->profileAtHandle);
		}

		/**
		 * mutator method for at handle
		 *
		 * @param string $newProfileAtHandle new value of at handle
		 * @throws \InvalidArgumentException if $newAtHandle is not a sting or is insecure
		 * @throws \RangeException if $newAtHandle is > 32 characters
		 * @throws \TypeError if $newAtHandle is not a string
		 **/
		public function setProfileAtHandle(string $newProfileAtHandle) : void {
					// verify the at handle will fit in the database
					$newProfileAtHandle = trim($newProfileAtHandle);
					$newProfileAtHandle = filter_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
					if(empty($newProfileAtHandle) === true) {
								throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
					}

					// verify the at handle willl fit in the database
					if(strlen($newProfileAtHandle) > 32) {
							throw(new \RangeException("profile at handle is too large"));
					}
					//store the at handle
					@$this->profileAtHandle = $newProfileAtHandle;
		}

		/**accessor for email
		 *
		 * @return String value of email
		 **/
		public function getProfileEmail(): string {
					return $this->profileEmail;
		}

		/**
		 * mutator method for email

		 * @param string $newProfileEmail
		 * @throws \InvalidArgumentException if $newEmail is not a valid email of insecure
		 * @throws \RangeException if $newEmail is > 128 characters
		 * @throws \TypeError if $newEmail is not a string
		 **/
		public function setProfileEmail(string $newProfileEmail): void {
					// verify the email is secure
					$newProfileEmail = trim($newProfileEmail);
					$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
					if(empty($newProfileEmail) === true) {
						throw(new \InvalidArgumentException("profileEmil is empty or insecure"));
					}

					//werify the email will fit in the database
					if(strlen($newProfileEmail) > 128) {
							throw(new \RangeException("profile email is too large"));
					}

					//store the email
			$this->profileEmail = $newProfileEmail;
		}

		/**
		 * accessor method for profileHash
		 *
		 * @return string value of hash
		 */

	/**
	 * @return mixed
	 */
	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash passsword
	 *
	 * @param string $newProfileHash
	 * @throws \InvaildArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		// enforce that the hash is not a string
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		// enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		// enforce that the has is exactly 128 characters.
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}

		// store the hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for phone
	 *
	 * @return string value of phone or null
	 **/
	public function getProfilePhone(): ?string {
				return ($this->profilePhone);
	}

	/**
	 * mutator method for phone
	 *
	 * @param string $newProfilePhone new value of phone
	 * @throws \InvalidArgumentException if $newPhone is not a string or is insecure
	 * @throws \RangeException if $newPhone id > 32 characters
	 * @throws \TypeError if $newPhone is not a string
	 **/
	public function setProfilePhone(?string $newProfilePhone): void {
				//If $profilePhone is null return it right away
				if($newProfilePhone === null) {
							$this->profilePhone = null;
							return;
				}


				// verify the phone is secure
		$newProfilePhone = trim($newProfilePhone);
		$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NOENCODE_QUOTES);
		if(empty($newProfilePhone) === true) {
					throw(new \RangeException("profile phone is empty or insecure"));
		}
		// verify the phone will fit in the database
		if(strlen($newProfilePhone) > 32) {
					throw(new \RangeException("profile phone is too large"));
		}

		// store the phone
		$this->profilePhone = $newProfilePhone;
	}

	/**accessor method for profile sslt
	 *
	 * @return string representation of the salt hexadecimal
	 */
	public function getProfileSalt(): string {
				return$this->profileSalt;
	}
	/**
	 *  mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 *
	 * @throw \InvalidArgumentException if the salt is not secure
	 *
	 * @throws\RangeException if the salt is not 64 characters
	 *
	 * @throws \TypeError if salt is not a string
	 */
	public function setProfileSalt(string  $newProfileSalt): void {
				// enforce that the salt is properly formatted
				$newProfileSalt = trim($newProfileSalt);
				$newProfileSalt = strtolower($newProfileSalt);

				//enforce that the salt is a string representation of a hexadecimal
				if(!ctype_xdigit($newProfileSalt)) {
							throw(new \InvalidArgumentException("profile password has is empty or insecure"));

				}

				// enforce that the salt is exactly 64 characters.
				if(strlen($newProfileSalt) !== 64) {
							throw(new \RangeException("profile password salt must be 128 characters"));
				}
				//store the hash
				$this->profileSalt = $newProfileSalt;
	}

}
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
	  * @var string $profileAtHandle
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
	  * @return string value of the activation token
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
	 public function getProfileAtHandle(): string {
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
	 public function setProfileAtHandle(string $newProfileAtHandle): void {
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
		 return $this->profileSalt;
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
	 public function setProfileSalt(string $newProfileSalt): void {
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

	 /**
	  * inserts this profile into mySQl
	  * @param \PDO $pdo connection object
	  * @throws \PDOException when mySQL related errors occur
	  * @throws /\TypeErrorif $pdo is not a PDO connection object
	  **/
	 public function insert(\PDO $pdo): void {
		 //enforce the profileId is null (i.e., don't insert a profile that already exists)
		 if($this->profileId !== null) {
			 throw(new \PDOException("not a new profile"));
		 }

		 // create query template
		 $query = "INSERT INTO profile(profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt) VALUES 						(:profileActivationToken, :profileAtHandle, :profileEmail, :profileHash, :profilePhone, :profieSalt)";
		 $statement = $pdo->prepare($query);

		 // bind the member variables to the placeholders in the template
		 $parameters = ["profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profilePhone" => $this->profilePhone, "profileSalt" => profileSalt];
		 $statement->execute($parameters);

		 //update the null profileId with mySQL just gave us
		 $this->profileId = intval($pdo->lastInsertId());
	 }

	 /**
	  * deletes this profile from mySQL
	  *
	  * @param \PDO $pdo PDO connection object
	  * @throws \PDOException when mySQL related errors that occur
	  * @throws \TypeError if $pdo is not a PDO connection object
	  **/
	 public function delete(\PDO $pdo): void {
		 //enforce the profileId is not null (i.e., don't delete a profile that does not exist)
		 if($this->profileId === null) {
			 throw(new \PDOException("unable to delete a profile that does not exist"));
		 }

		 // create query template
		 $query = "DELETE FROM profile WHERE profileId = :profileId";
		 $statement = $pdo->prepare($query);

		 // bind the member variables to the place holders in the template
		 $parameters = ["profileId" => $this->profileId];
		 $statement->execute($parameters);
	 }

	 /**
	  * updates this profile from mySQL
	  *
	  * @param \PDO $pdo PDO connection object
	  * @throws \PDOException when mySQL related errors occur
	  * @throws \TypeError if $pdo is not a PDO connection object
	  **/
	 public function update(\PDO $pdo): void {
		 //enforce the profileId is not null (i.e., don't update a profile that does not exist)
		 if($this->profileId === null) {
			 throw(new \PDOException("unable to delete a profile that does not exist"));
		 }

		 // create query template
		 $query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAtHandle = :profileAtHandle, profileEmail = 						:profileEmail, profileHash = :profileHash, profilePhone = :profilePhone, profileSalt = :profileSalt WHERE profileId = :profileId";
		 $statement = $pdo->prepare($query);

		 // bind the member variable to the place holders in the template
		 $parameters = ["profileId" => $this->profileId, "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profilePhone," => $this->profilePhone, "profileSalt" => $this->profileSalt];
		 $statement->execute($parameters);
	 }

	 /**
	  * gets the profile by profile id
	  *
	  * @param \PDO $pdo $pdo PDO connection object
	  * @param int $profileId Profile id to search for
	  * @return Profile|null Profile or null if not found
	  * @throws \PDOException when mySQL related errors occur
	  * @throws \TypeError when variables are not the correct data type
	  **/
	 public static function getProfileByProfileId(\PDO $pdo, int $profileId):?Profile {
		 // sanitize the profile id before searching
		 if($profileId <= 0) {
			 throw(new \PDOException("profile id is not positve"));
		 }

		 // create query template
		 $query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileId = :profileId";
		 $statement = $pdo->prepare($query);

		 //bind the profile id to the place holder in the template
		 $parameters = ["profileId" => $profileId];
		 $statement->execute($parameters);

		 // grab the profile from mySQL
		 try {
				 	$profile = null;
				 	$statement->setFetchMode(\PDO::FETCH_ASSOC);
			 		$row = $statement->fetch();
			 		if($row !== false) {
						 		$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			 }
		 } catch(\Exception $exception) {
					 // if the row couldn't be converted, rethrow it
			 		throw(new \PDOException($exception->getMessage(), 0, $exception));
		 }
		 	return ($profile);
	 }

	 /**
	  * gets the profile by email
	  *
	  * @param \PDO $pdo PDO connection object
	  * @param string $profileEmail email to search for
	  * @return Profile|null Profile or null if not found
	  * @throws \PDOException when mySQL related errors occur
	  * @throws \ TypeError when variables are not the correct data type
	  **/
	 public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {
	 			// sanitize the email before searching
		 		$profileEmail = trim ($profileEmail);
	 			$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);
	 			if(empty($profileEmail) === true) {
	 						throw(new \PDOException("not a valid email"));
				}

				// create query template
		 		$query = "SELECT profileEmail, profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileEmail = :profileEmail";
	 			$statement = $pdo->prepare($query);

	 			// bind the profile id to the place holder in the template
		 		$parameters = ["profileEmail => $profileEmail"];
		 		$statement->execute($parameters);

		 		// grab the profile from mySQL
		 		try {
		 					$profile = null;
		 					$statement->setFetchMode(\PDO::FETCH_ASSOC);
		 					$row = $statement->fetch();
		 					if($row !== false) {
		 								$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], ["profilePhone"], 												$row["profileSalt"]);
							}
				} catch(\Exception $exception) {
		 					// if the row couldn't be converted, rethrow it
							throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
				return ($profile);
	 }

	 /**
	  * gets the Profile by at handle
	  *
	  * @param \PDO $pdo PDO connection object
	  * @param string $profileAtHandle at handle to search for
	  * @return \SplFixedArray of allprofiles found
	  * @throws \PDOException when mySQL related errors occur
	  * @throws \TypeError when variables are not the correct data type
	  **/
	 public static function getProfileByProfileAtHandle(\PDO $pdo, string $profileAtHandle) : \SplFixedArray {
	 			// sanitize the at handle before searching
		 		$profileAtHandle = trim($profileAtHandle);
		 		$profileAtHandle = filter_var($profileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		 		if(empty($profileAtHandle) === true) {
		 					throw(new \PDOException("not a valid at handle"));
				}

				// create query template
		 		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileAtHandle = :profileAtHandle";
		 		$statement = $pdo->prepare($query);

		 		// bind the profile at handle to the place hoder in the template
		 		$parameters = ["profileAtHandle" => $profileAtHandle];
		 		$statement->execute($parameters);



		 		$profiles = new \SplFixedArray($statement->rowCount());
		 		$statement->setFetchMode(\PDO::FETCH_ASSOC);


		 		while(($row = $statement->fetch()) !== false) {
		 					try {
		 								$profile = new Profile($row["proflieId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profilePhone"], 												$row["profileSalt"]);
		 										$profiles[$profiles->key()] = $profile;
		 										$profiles->next();
							} catch(\Exception $exception) {
		 								// if the row couldn't be converted, rethrow it
										throw(new \PDOException($exception->getMessage(), 0, $exception));
							}
				}
				return ($profiles);
	 }

	 			/**
				 * get the profile by profile activation token
				 *
				 * @param string by profile activation token
				 * @param \PDO object $pdo
				 * @return Profile|null Profile or null if not found
				 * @throws \PDOException when mySQL related errors occur
				 * @throws \TypeError when variables are not the correct data type
				 **/
	 			public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {
	 						// make sure activation token is in the ight format and that it is a string representation of a hexadecimal
							$profileActivationToken = trim($profileActivationToken);
							if(ctype_xdigit($profileActivationToken) === false) {
										throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
							}

							// create the query template
							$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileActivationToken";
							$statement = $pdo->prepare($query);

							// bind the profile activation token to the place holder in the template
							$parameters = ["profileActivationToken" => $profileActivationToken];
							$statement->execute($parameters);

							// grab the profile from mySQL
							try {
								$profile = null;
								$statement->setFetchMode(\PDO::FETCH_ASSOC);
								$row = $statement->fetch();
								if($row !== false) {
											$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], 													$row["profilePhone"], $row["profileSalt"]);
								}
							} catch(\Exception $exception) {
										// if the row couldn't be converted, rethrow it
										throw(new \PDOException($exception->getMessage(), 0, $exception));
							}
										return ($profile);
							}

							/**
							 * Formats the state variables for JSON serialization
							 *
							 * @return array resulting state variables for JON serialization
							 **/
							public function jsonSerialize() {
										return (get_object_vars($this));
						}
				}

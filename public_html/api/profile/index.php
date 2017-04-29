<?php


require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__,3) . "/php/classes/autoload.php";
require_once dirname(__DIR__,3) . "/php/lib/xsrf/php";
require_once ("/etc/apache2/capstone-msql/encrypted-config.php");

use Edu\Cnm\DataDesign\ {
			Profile
};

/**
 * API for Product
 *
 * @author Marcus lester
 * @version 7.0.0
 */

// verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
}
//prepare an empty reply
$reply = new stdClas();
$reply->status = 200;
$reply->data = null;

try {
	// grqb th mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/ddctwitter.ini");

	// determine which method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileAtHandle = filter_input(INPUT_GET, "profileAtHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	// make sure th id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// gets a post by content
		if(empty($id) === false) {
			$reply->data = $profile::getProfileByProfileID($pdo, $id);

			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileAtHandle) === false) {
			$profile = Profile::getProfileByProfileAtHandle($pdo, $profileAtHandle);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileEmail) === false) {

			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}
	} else if($method === "PUT") {

		// enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to acces this profile", 403));
		}

		// decode the response fro the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		if(empty($requestObject->newPassword) === true) {

			// enforce that the XSRF token is present in the header
			verifyXsrf();

			// profile at handle
			if(empty($requestObject->profileAtHandle) === true) {
				throw(new \InvalidArgumentException("No profile at handle", 405));
			}

			// profile email is a required field
			if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException("Now profile email present", 405));
			}

			// profile phone # | if null use the profile phone that is in the database
			if(empty($requestObject->profilePhone) === true) {
				$requestObject->profilePhone = $profile->getProfilePhone();
			}

			$profile->setProfileAtHandle($requestObject->profileAtHandle);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfilePhone($requestObject->profilePhone);
			$profile0 > update($pdo);

			// update reply
			$reply->message = "Profile information updated";

		}

		/**
		 * update the password if requested
		 * thanks sprout-swap @author:<solomon.leyba@gmail.com>
		 **/
		// enforce that current password and new password and confirm password is present
		if(empty($requestObject->profilePassword) == false && empty($requestObject->profileConfirmPassword) === false && empty($requestContent->confirmPassword) === false) {

			// make sure the new password and confirm password exists
			if($requestObject->newProfilePassword !== $requestObject->profileConfirmPassword) {
				throw(new RuntimeException("New passwords do not match", 401));
			}

			// hash the previous password
			$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword, $profile->getProfileSalt(), 262144);

			// make sure the hash given by end user matches what is in the database
			if($currentPasswordHash !== $profile->getProfileHash()) {
				throw(new \RuntimeException("Old password is incorrect", 401));
			}

			// salt and hash the new password and update the profile object
			$newPasswordSalt = bin2hex(random_bytes(16));
			$newPasswordHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newPasswordSalt, 262144);
			$profile->setProfileHash($newPasswordHash);
			$profile->setProfileSalt($newPasswordSalt);
		}

			// perform the actual update to the database and update the message
			$profile->update($pdo);
			$reply->message = "profile password succesfully updated";

		} elseif($method === "DELETE") {

			// verify the XSRF Token
			verifyXsrf();

			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile === null) {
				throw (new \InvalidArgumentException("Profile does not exist"));
			}

			//enforce the user is signed in and only trying to edit their own profile
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
				throw(new \InvalidArgumentException("you are not allowed to aces this profile", 403));
			}

			// delete the post fro the database
			$profile->delete($pdo);
			$reply->message = "ProfileDeleted";

		} else {
			throw (new InvalidArgumentException("InvalidHTTP request", 400));
		}
		// catch any exceptions that were thrown and update the status and message state variable fields
	} catch( \Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}

	header("Content-type: application/json");
	if($reply->data === null) {
				unset($reply->data);
	}

//encode and return reply to front end caller
echo json_encode($reply);
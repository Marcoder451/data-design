<?php

namespace Edu\Cnm\DataDesign;
require_once("autoload.php");

/**
 * Cross sections of favoriting a product on Etsy
 *
 * This is cross section of what probably occurs when a user favorites a product. It is an intersection table (weak entity) from a m-to-n relationship between profile and product.
 *
 * @author Marcus Lester <mlester3@cnm.edu>
 * @version 7.1.0
 **/
class Favorite implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id of the product being favorited; this is a component of a composite primary key (and a foreign key)
	 * @var int $favoriteProductId
	 **/
	private $favoriteProductId;
	/**
	 * id of the profile that favorited the product; this is a component composite primary key (and a foreign key)
	 * @var int $favoriteProfileId
	 **/
	private $favoriteProfileId;
	/**
	 * date and time the product was favorited
	 * @var \DateTime $favoriteDate
	 **/
	private $favoriteDate;

	/**
	 * constructor for this Favorite
	 *
	 * @param int $newFavoriteProfileId id of the parent profile
	 * @param int $newFavoriteProductId id of the parent product
	 * @param \DateTime|null $newFavoriteDate date the product was favorited (or null for current time)
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct(int $newFavoriteProfileId, int $newFavoriteProductId, $newFavoriteDate = null) {
		// use the mutator methods to do the work for us!
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteProductId($newFavoriteProductId);
			$this->setFavoriteDate($newFavoriteDate);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			// determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int value of profile id
	 **/
	public function getFavoriteProfileId(): int {
		return ($this->favoriteProfileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setFavoriteProfileId(int $newProfileId): void {
		// verify the profile is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}

		// convert and store the profile id
		$this->favoriteProfileId = $newProfileId;
	}

	/**
	 * accessor method for product id
	 *
	 * @return int value of product id
	 **/
	public function getFavoriteProductId(): int {
		return ($this->favoriteProductId);
	}

	/**
	 * mutator method for product id
	 *
	 * @param int $newFavoriteProductId new value of product id
	 * @throws \RangeException if $newProductId is not positive
	 * @throws \TypeError if $newProductId is not an integer
	 **/
	public function setFavoriteProductId(int $newFavoriteProductId): void {
		// verify the product id is positive
		if($newFavoriteProductId <= 0) {
			throw(new \RangeException("product id is not positive"));
		}

		//convert and store the profile id
		$this->favoriteProductId = $newFavoriteProductId;
	}

	/**
	 * accessor method for favorite Date
	 *
	 * @return \DateTime value of favorite date
	 **/
	public function getFavoriteDate(): \Datetime {
		return ($this->favoriteDate);
	}

	/**
	 * mutator method for favorite date
	 *
	 * @param \DateTime|string|null $newFavoriteDate
	 * @throws \InvalidArgumentException if $newFavoriteDate is not a valid object or string
	 * @throws \RangeException if $newFavoriteDate is a date that doesn't exist
	 **/
	public function setFavoriteDate($newFavoriteDate): void {
		// base case: if the date is null, use the current date and time
		if($newFavoriteDate === null) {
			$this->favoriteDate = new \Datetime();
			return;
		}

		// store the favorite date using the ValidateDate trait
		try {
			$newFavoriteDate = self::validateDateTime($newFavoriteDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteDate = $newFavoriteDate;

	}

	/**
	 * inserts this favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// ensure the object exists before inserting
		if($this->favoriteProfileId === null || $this->favoriteProfileId === null) {
			throw(new \PDOException("not a valid like"));
		}

		// create query template
		$query = "DELETE FROM favorite WHERE FavoriteProfileId = :favoriteProfileId AND favoriteProductId = :favoriteProductId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteProductId" => $this->favoriteProductId];
		$statement - execute($parameters);
	}

	/**
	 * deletes this favorite from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related erros occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
				//ensure the object exists before deleting
				if($this->favoriteProfileId === null || $this->favoriteProductId === null) {
							throw(new \PDOException("not a valid favorite"));
				}

				// create query template
				$query = "DELETE FROM favorite WHERE favoriteProfileId = :favoriteProfileId AND favoiteProductId = :favoriteProductId";
				$statement = $pdo->prepare($query);

				// bind the member variables to the place holders in the template
				$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteProductId" => $this->favoriteProductId];
				$statement->execute($parameters);
	}

}
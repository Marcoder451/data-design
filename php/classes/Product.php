<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
/**
 * Small Cross Section of a Etsy like post
 *
 * This product can be considered a small example of what services like Etsy Store when items are
 * 
 * posted on Etsy. This can easily extend to othe features of Etsy
 *
 *@author Marcus Lester <mlester3@cnm.edu>
 *@version 7.1.0
 **/
class Product {
	use ValidateDate;
	/**
	 * id for this Product; this is the primary key
	 *
	 * @var int $productId
	 **/
	private $productId;
	/**
	 *id for this profile that posted this product; this is a foriegn key
	 *
	 * @var int $productProfileId
	 **/
	private $productProfileId;
	/**
	 * actual textual content of this product
	 *
	 * @var string $productContent
	 **/
	private $productContent;
	/**
	 * date and time this product was posted, in a php DateTime object
	 *
	 * @var \DateTime $productDate
	 **/
	private $productDate;

	/**
	 * seller of this product
	 *
	 *
	 * @param int|null $newProductID id of this Product or null if a new Product
	 *
	 * @param int $newProtectedId id of the profile that posted this product
	 *
	 * @param string $newProductContent string containing actual product data
	 *
	 * @param \DateTime|string|null $newProductDate date and time Product was posted or null if set to current date and time
	 *
	 * @throws \InvalidArgumentException if data types are not valid
	 *
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 *
	 * @throws \TypeError if data types violate type hints
	 *
	 * @throws \Exception if some other exception occurs
	 *
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProductId, int $newProductProfileId, string $newProductContent, $newProductDate = null) {
		try {
			$this->setProductId($newProductId);
			$this->setProductProfileId($newProductProfileId);
			$this->setProductContent($newProductContent);
			$this->setProductDate($newProductDate);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for product id
	 *
	 * @return int|null value of product id
	 **/
	public function getProductId(): ?int {
		return ($this->productId);
	}

	/**
	 * mutator method for product id
	 *
	 * @param int|null $newProductId new value of product id
	 * @throws \RangeException if $newProductId is not positive
	 * @throws \TypeError if $newproduct is not an integer
	 **/
	public function setProductId(?int $newProductID): void {
		//if product id is null immediately return it
		if($newProductID === null) {
			$this->productId = null;
			return;
		}
		// verify the product id is positive
		if($newProductID <= 0) {
			throw(new \RangeException("product id is not positive"));
		}
		// convert and store the product id
		$this->productId = $newProductID;
	}

	/**
	 * accessor method for product profile id
	 *
	 * @return int value of product id
	 * */
	public function getProductProfileId(): int {
		return ($this->productProfileId);
	}

	/**
	 * mutator method for the Product profile id
	 *
	 * @param int $newProductProfileId new value of product profile id
	 * @throws \RangeException if $newProfileId is not an integer
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProductProfileId(int $newProductProfileId): void {
		// verify the profile id is positive
		if($newProductProfileId <= 0) {
			throw(new \RangeException("product profile id is not positive"));
		}
		//convert and store the profile id
		$this->productProfileId = $newProductProfileId;
	}

	/**
	 * accessor method for product content
	 *
	 * @return string value of product content
	 **/
	public function getProductContent(): string {
		return ($this->productContent);
	}

	/**
	 * mutator method for product content
	 *
	 * @param string $newProductContent new value of product content
	 * @throws \InvalidArgumentException if $newProductContent is not a string or insecure
	 * @throws \RangeException if $newProductContent is > 140 characters
	 * @throws \ TypeError if $newProductContent is not a string
	 **/
	public function setProductContent(string $newProductContent): void {
		// verify the product content is secure
		$newProductContent = trim($newProductContent);
		$newProductContent = filter_var($newProductContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductContent) === true) {
			throw(new \InvalidArgumentException("product content is empty or insecure"));
		}
		//verify the product content will fit in the database
		if(strlen($newProductContent) > 140) {
			throw(new \RangeException("product content too large"));
		}
		//store the tweet content
		$this->productContent = $newProductContent;
	}

	/**
	 * acessor method fo product date
	 *
	 * @return \Datetime value of product date
	 **/
	public function getProductDate(): \DateTime {
		return ($this->productDate);
	}

	/**
	 * mutator method for product date
	 *
	 * @param \Datetime|string|null $newProductDate Product date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newProductDate is not a valid object or string
	 * @throws \RangeException if $newProductDate is a date that does not exist
	 **/
	public function setProductDate($newProductDate = null): void {
		// base case: if the date is null, use the current date time
		if($newProductDate === null) {
			$this->productDate = new \DateTime();
			return;
		}
// store the like date using the ValidateDate trait
		try {
			$newProductDate = self::validateDateTime($newProductDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->productDate = $newProductDate;
	}

}
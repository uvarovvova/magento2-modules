<?php
namespace Sam\Price\Api\Data;

interface PriceInterface
{
	/**
	 * Constants for keys of data array. Identical to the name of the getter in snake case
	 */
	const ENTITY_ID             = 'entity_id';
	const NAME                  = 'name';
	const EMAIL                 = 'email';
	const COMMENT               = 'comment';
	const STATUS                = 'status';
	const SKU                   = 'sku';
	const CREATED_AT            = 'created_at';


	/**
	 * Get ID
	 *
	 * @return int|null
	 */
	public function getId();


	/**
	 * Set ID
	 *
	 * @param $id
	 * @return PriceInterface
	 */
	public function setId($id);

	/**
	 * Get Name
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Set Name
	 *
	 * @param $name
	 * @return mixed
	 */
	public function setName($name);

	/**
	 * Get Email
	 *
	 * @return string
	 */
	public function getEmail();

	/**
	 * Set Email
	 *
	 * @param $email
	 * @return mixed
	 */
	public function setEmail($email);

	/**
	 * Get Sku
	 *
	 * @return string
	 */
	public function getSku();

	/**
	 * Set Sku
	 *
	 * @param $sku
	 * @return mixed
	 */
	public function setSku($sku);

	/**
	 * Get Comment
	 *
	 * @return string
	 */
	public function getComment();

	/**
	 * Set Sku
	 *
	 * @param $comment
	 * @return mixed
	 */
	public function setComment($comment);

	/**
	 * Get status
	 *
	 * @return bool|int
	 */
	public function getStatus();

	/**
	 * Get statuses
	 *
	 * @return array
	 */
	public function getStatuses();

	/**
	 * Set status
	 *
	 * @param $status
	 * @return $this
	 */
	public function setStatus($status);

	/**
	 * @return string|null
	 */
	public function getCreatedAt();
}
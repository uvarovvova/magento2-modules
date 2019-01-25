<?php

namespace Uvarov\Bar\Api\Data;

/**
 * Interface NotificationInterface
 * @package Uvarov\Bar\Api\Data
 */
interface NotificationInterface
{

	const ENTITY_ID             = 'entity_id';
	const TITLE                 = 'title';
	const CONTENT               = 'content';
	const BACKGROUND_COLOR      = 'background_color';
	const STATUS                = 'status';
	const PRIORITY              = 'priority';

	/**
	 * Get Title
	 *
	 * @return string
	 */
	public function getTitle();

	/**
	 * Set Title
	 *
	 * @param string $title
	 * @return mixed
	 */
	public function setTitle($title);

	/**
	 * Get Content
	 *
	 * @return string
	 */
	public function getContent();

	/**
	 * Set Content
	 *
	 * @param string $content
	 * @return mixed
	 */
	public function setContent($content);

	/**
	 * Get Background Color
	 *
	 * @return string
	 */
	public function getBackgroundColor();

	/**
	 * Set Background Color
	 *
	 * @param string $backgroundColor
	 * @return mixed
	 */
	public function setBackgroundColor($backgroundColor);

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
	 * @param int $status
	 * @return $this
	 */
	public function setStatus($status);

	/**
	 * @return mixed
	 */
	public function getPriority();

	/**
	 * Priority
	 *
	 * @param integer $priority
	 * @return mixed
	 */
	public function setPriority($priority);

	/**
	 * @return mixed
	 */
//	public function getStoreId();
}
<?php namespace Congredi\NotificationSystem\Drivers\SMS;

use Illuminate\View\Factory;

class SmsMessage
{
	/**
	 * @var \Illuminate\View\Factory
	 */
	protected $views;

	/**
	 * @var string
	 */
	protected $view;

	/**
	 * Array of data to be passed to view
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * From address
	 *
	 * @var string
	 */
	protected $from;

	/**
	 * To Address
	 *
	 * @var array
	 */
	protected $to = [];

	/**
	 * Is MMS or not
	 *
	 * @var bool
	 */
	protected $mms = false;

	/**
	 * Attached images.
	 *
	 * @var array
	 */
	protected $attachImages = [];

	/**
	 * @param \Illuminate\View\Factory $views
	 */
	public function __construct(Factory $views)
	{
		$this->views = $views;
	}

	/**
	 * Compose a message from views and data.
	 *
	 * @return string
	 */
	public function composeMessage()
	{
		/**
		 * We want to make a view, but if view cannot be created we just assume that is a simple message.
		 */
		try {
			return $this->views->make($this->view, $this->data)->render();
		}
		catch (\InvalidArgumentException $e) {
			return $this->view;
		}
	}

	/**
	 * @param $number
	 * @return $this
	 */
	public function from($number)
	{
		$this->from = $number;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * Sets the to addresses
	 *
	 * @param $number
	 * @param null $carrier
	 * @return $this
	 */
	public function to($number, $carrier = null)
	{
		$this->to[] = [
			'number' => $number,
			'carrier' => $carrier
		];

		return $this;
	}

	/**
	 * @return array
	 */
	public function getTo()
	{
		$numbers = array();

		foreach ($this->to as $to) {
			$numbers[] = $to['number'];
		}

		return $numbers;
	}

	/**
	 * @return array
	 */
	public function getToWithCarriers()
	{
		return $this->to;
	}

	/**
	 * @param $view
	 * @return $this
	 */
	public function view($view)
	{
		$this->view = $view;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param $data
	 * @return $this
	 */
	public function data($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * @param $image
	 * @return $this
	 */
	public function attachImage($image)
	{
		$this->mms = true;

		$this->attachImages[] = $image;

		if (is_array($image)) {
			$this->attachImages = array_merge($this->attachImages, $image);
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function getAttachImages()
	{
		return $this->attachImages;
	}

	/**
	 * @return bool
	 */
	public function isMMS()
	{
		return $this->mms;
	}
}
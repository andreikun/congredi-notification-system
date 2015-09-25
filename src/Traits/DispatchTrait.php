<?php namespace Congredi\NotificationSystem\Traits;


trait DispatchTrait
{
	/**
	 * Dispatch a job to its appropriate handler.
	 *
	 * @param  mixed  $job
	 * @return mixed
	 */
	protected function dispatch($job)
	{
		return $this->dispatcher->dispatch($job);
	}

	/**
	 * Marshal a job and dispatch it to its appropriate handler.
	 *
	 * @param  mixed  $job
	 * @param  array  $array
	 * @return mixed
	 */
	protected function dispatchFromArray($job, array $array)
	{
		return $this->dispatcher->dispatchFromArray($job, $array);
	}

	/**
	 * Marshal a job and dispatch it to its appropriate handler.
	 *
	 * @param  mixed  $job
	 * @param  \ArrayAccess  $source
	 * @param  array  $extras
	 * @return mixed
	 */
	protected function dispatchFrom($job, \ArrayAccess $source, $extras = [])
	{
		return $this->dispatcher->dispatchFrom($job, $source, $extras);
	}
}
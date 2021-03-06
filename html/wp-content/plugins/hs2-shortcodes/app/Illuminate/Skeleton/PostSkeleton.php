<?php


namespace HSSC\Illuminate\Skeleton;

class PostSkeleton extends Skeleton
{
	private static $_self = null;
	private        $post;

	public function validate()
	{
		// TODO: Implement validate() method.
	}

	public function setObject(): Skeleton
	{
		$this->oInstance = self::$_self;
		return $this;
	}


	public static function init(\WP_Post $post): PostSkeleton
	{
		if (!self::$_self) {
			self::$_self = new PostSkeleton();
		}

		self::$_self->post = $post;
		self::$_self->aResponse = [];

		return self::$_self;
	}

	/**
	 * @param $pluck
	 * @return PostSkeleton
	 * @throws \Exception
	 */
	public function setPluck($pluck): Skeleton
	{
		if (is_array($pluck)) {
			$this->aPluck = $pluck;
		} else {
			$this->aPluck = explode(',', $pluck);
		}

		return $this;
	}

	public function setAdditionalArgs(array $aAdditionalArgs): PostSkeleton
	{
		$this->aAdditionalArgs = wp_parse_args($aAdditionalArgs, $this->aAdditionalArgs);
		return $this;
	}
}

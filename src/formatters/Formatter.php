<?php
namespace csslib\formatters;

/**
 * An interface all formatters need to inherit
 * @author 10usb
 */
interface Formatter {
	/**
	 * Formats a segment
	 * @param \csslib\Segment $segment
	 */
	public function format($segment);
}
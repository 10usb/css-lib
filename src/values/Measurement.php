<?php
namespace csslib\values;

/**
 * Represents a numerical value scaled by a given unit
 * @author 10usb
 */
class Measurement extends Value {
	/**
	 * Regex pattern to validate a measurement value
	 * @var string PATTERN
	 */
	const PATTERN = '/^(\d+(\.\d+)?)(\%|in|cm|mm|em|pt|pc|px)?$/is';
	
	/**
	 * The number
	 * @var number
	 */
	private $number;
	
	/**
	 * The unit
	 * @var string
	 */
	private $unit;

	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::init()
	 */
	protected function init(){
		if(!preg_match(self::PATTERN, $this->value, $matches)) throw new \Exception("Invalid string '$this->value'");
		$this->number	= $matches[1];
		$this->unit		= $matches[3];
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \csslib\values\Value::getMeasurement()
	 */
	public function getMeasurement($unit, $value = null, $throw = true){
		if($this->unit=='%'){
			$value = $value instanceof Measurement ? $value : new Measurement($value);
			return self::convert($value->number, $value->unit, $unit) * $this->number / 100;
		}
		return self::convert($this->number, $this->unit, $unit);
	}
	
	/**
	 * Convert units from x to y
	 * @param number $number Value to convert
	 * @param string $from Unit the value it in
	 * @param string $to Unit the value need to be converted to
	 * @return number
	 */
	public static function convert($number, $from, $to, $ratio = 0.75){
		switch($from){
			case 'in': switch($to){
				case 'in': return $number;
				case 'cm': return $number * 2.54;
				case 'mm': return $number * 25.4;
				case 'pt': return $number * 72;
				case 'pc': return $number * 6;
				case 'px': return $number * 72 * $ratio;
			}
			case 'cm': switch($to){
				case 'in': return $number / 2.54;
				case 'cm': return $number;
				case 'mm': return $number / 10;
				case 'pt': return $number * 72 / 2.54;
				case 'pc': return $number * 6 / 2.54;
				case 'px': return $number * 72 * $ratio / 2.54;
			}
			case 'mm': switch($to){
				case 'in': return $number / 25.4;
				case 'cm': return $number * 10;
				case 'mm': return $number;
				case 'pt': return $number * 72 / 25.4;
				case 'pc': return $number * 6 / 25.4;
				case 'px': return $number * 72 * $ratio / 25.4;
			}
			case 'pt': switch($to){
				case 'in': return $number / 72;
				case 'cm': return $number * 2.54  / 72;
				case 'mm': return $number * 25.4 / 72;
				case 'pt': return $number;
				case 'pc': return $number * 12;
				case 'px': return $number * 72 * $ratio  / 72;
			}
			case 'pc': switch($to){
				case 'in': return $number / 6;
				case 'cm': return $number * 2.54  / 6;
				case 'mm': return $number * 25.4 / 6;
				case 'pt': return $number / 12;
				case 'pc': return $number;
				case 'px': return $number * 72 * $ratio  / 6;
			}
			case 'px': switch($to){
				case 'in': return $number / 72 * $ratio;
				case 'cm': return $number * 2.54 / 72 * $ratio;
				case 'mm': return $number * 25.4 / 72 * $ratio;
				case 'pt': return $number * $ratio;
				case 'pc': return $number * 6 / 72 * $ratio;
				case 'px': return $number;
			}
		}
		
		throw new \Exception("Invalid conversion from $from to $to with a value of $number");
	}
}
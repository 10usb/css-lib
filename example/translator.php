<?php

class ExampleTranslator implements \csslib\query\Translator {
	public function getValue($chain, $document, $key){
		$property = $chain->getProperty($key);
		$value = null;
		
		if($property) switch($key){
			case 'color':
				$value = $property->getValueList(0)->getValue(0);
				if($value=='inherit') $value = $this->getValue($chain->getParent(), $document, $key);
			break;
			default: throw new Exception("Unknow property '$key'");
		}else switch($key){
			case 'page-margin-top':
				$property = $chain->getProperty('page-margin');
				if($property){
					if($property->getValueList(0)->getCount()==4){
						$value = $property->getValueList(0)->getValue(0);
					}elseif($value->getValueList(0)->getCount()==2){
						$value = $property->getValueList(0)->getValue(0);
					}
					if($value=='inherit') $value = $this->getValue($chain->getParent(), $document, $key);
				}
			break;
			case 'page-margin-right':
				$property = $chain->getProperty('page-margin');
				if($property){
					if($property->getValueList(0)->getCount()==4){
						$value = $property->getValueList(0)->getValue(1);
					}elseif($value->getValueList(0)->getCount()==2){
						$value = $property->getValueList(0)->getValue(1);
					}
					if($value=='inherit') $value = $this->getValue($chain->getParent(), $document, $key);
				}
			break;
			case 'page-margin-bottom':
				$property = $chain->getProperty('page-margin');
				if($property){
					if($property->getValueList(0)->getCount()==4){
						$value = $property->getValueList(0)->getValue(2);
					}elseif($value->getValueList(0)->getCount()==2){
						$value = $property->getValueList(0)->getValue(0);
					}
					if($value=='inherit') $value = $this->getValue($chain->getParent(), $document, $key);
				}
			break;
			case 'page-margin-left':
				$property = $chain->getProperty('page-margin');
				if($property){
					if($property->getValueList(0)->getCount()==4){
						$value = $property->getValueList(0)->getValue(3);
					}elseif($value->getValueList(0)->getCount()==2){
						$value = $property->getValueList(0)->getValue(1);
					}
					if($value=='inherit') $value = $this->getValue($chain->getParent(), $document, $key);
				}
			break;
			default: throw new Exception("Unknow property '$key'");
		}
		
		return $value;
	}
}
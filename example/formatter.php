<?php

class MinifyFormatter implements CSSFormatter {
	public function document(CSSDocument $document){
		$css = '';
		foreach($document->getRuleSets() as $ruleset){
			$selectors = array();
			foreach($ruleset->getSelectors() as $selector){
				$selector = str_replace(' > ', '>', $selector);
				$selector = str_replace(' + ', '+', $selector);
				$selector = str_replace(' ~ ', '~', $selector);
				$selectors[] = $selector;
			}
			$css.= implode(', ', $selectors)."{";
			$properties = array();
			foreach($ruleset->getProperties() as $key=>$value){
				$properties[] = "$key:$value";
			}
			$css.= implode(';', $properties);
			$css.= "}\n";
		}
		return $css;
	}
}
<?php
class CSSPath {
	/**
	 * 
	 * @var CSSDocument
	 */
	private $documment;
	/**
	 * 
	 * @var CSSTranslator
	 */
	private $translator;
	
	/**
	 * 
	 * @var array<CSSSelector>
	 */
	private $items;
	
	/**
	 * 
	 * @var array<CSSRuleSet>
	 */
	private $rulesets;
	
	/**
	 * 
	 * @param CSSDocument $document
	 */
	public function __construct($document, $translator){
		$this->document		= $document;
		$this->translator	= $translator;
		$this->items		= array();
		$this->rulesets		= null;
	}
	
	/**
	 * 
	 * @param string $key
	 * @return mixed
	 */
	public function getValue($key){
		foreach(array_reverse($this->rulesets) as $ruleset){
			$value = $this->translator->getValue($ruleset, $key);
			if($this->translator->inherits($value, $key)) continue;
			return $value;
		}
		return null;
	}
	
	/**
	 * 
	 * @param string $tagName
	 * @param array<string> $classes
	 * @param array<string> $pseudos
	 */
	public function push($tagName, $classes, $pseudos){
		$selector = new CSSSelector('>', $tagName, $classes, $pseudos);
		if($this->items){
			$last = end($this->items);
			$last->setSelector($selector);
		}
		$this->items[] = $selector;
		
		$matches = array();
		foreach($this->document->getRuleSets() as $ruleset){
			$matches = array_merge($matches, $ruleset->match($this->items[0]));
		}
		usort($matches, array('CSSMatch', 'compare'));
		
		$ruleset = new CSSRuleSet();
		foreach($matches as $match){
			// This should be done by the translator
			foreach($match->getRuleSet()->getProperties() as $key=>$value){
				$this->translator->translate($key, $value, $ruleset);
			}
		}
		$this->rulesets[] = $ruleset;
	}
	
	/**
	 * 
	 */
	public function pop(){
		array_pop($this->items);
		$last = end($this->items);
		$last->setSelector(null);

		array_pop($this->rulesets);
	}
	

	/**
	 * Returns the CSS
	 * @return string
	 */
	public function __toString(){
		return $this->items[0]->__toString();
	}
}
<?php


namespace Limelight\Converter;

/** The converter class used as the central converter.
 * Class Converter
 * @package Limelight\Converter
 */
class Converter {
	private $text = '';

	/**
	 * Converter constructor.
	 * @param string|null $text Optional text to set during the construction.
	 */
	public function __construct(string $text = null){
		if (!is_null($text)){$this->text = $text;}
	}

	/** List of "simple" bbTags and their replacements.
	 * @var array
	 */
	public static $bbTags = [
		'b' => '**',
		'i' => '*',
		'u' => '__',
		's' => '~~',
	];

	/** List of "simple" bbTags and their replacements (which act as prefixes.
	 * @var array
	 */
	public static $bbPrefixes = [
		'h1' => '#',
		'h2' => '##',
		'h3' => '###',
		'h4' => '####',
	];

	/** List of bbTags with attributes and their replacements.
	 * @var array
	 */
	public static $bbAttributeTags = [
		'url' => [
			'regex' => '/\[url(?:=([^\]]+?))?\]([^\[]*?)\[\/url\]/',
			'template' => '[{mask}]({url})',
			'attributes' => [
				'url' => [
					'value' => 1,
					'default' => 2
				],
				'mask' => [
					'value' => 2
				]
			]
		],
	];

	/** Sets the internal text store.
	 * @param string $text
	 */
	public function setText(string $text): void{
		$this->text = $text;
	}

	/** Gets the internal string representation.
	 * @return string
	 */
	public function getText(): string {
		return $this->text;
	}

	/**
	 * Converts the internal store from BBCode to Markdown.
	 */
	function BBToMarkdown(){
		// Start off by escaping codes which happen to be in the text already.
		foreach (static::$bbTags as $md){
			$esc = join('', array_map(function($char){return "\\{$char}";}, str_split($md)));
			$this->text = str_replace($md, $esc, $this->text);
		}
		foreach (static::$bbPrefixes as $md){
			$esc = join('', array_map(function($char){return "\\{$char}";}, str_split($md)));
			$md = preg_quote($md);
			$this->text = preg_replace("/^(\s*){$md}/", "$1{$esc}", $this->text);
		}

		// Then replace ones which are there now.
		foreach (static::$bbTags as $bb => $md){
			$open = preg_quote("[$bb]");
			$close = preg_quote("[/$bb]");
			$close = str_replace('/', '\\/', $close);

			$this->text = preg_replace("/{$open}(.*?){$close}/", "{$md}$1{$md}", $this->text);
		}
		foreach (static::$bbPrefixes as $bb => $md){
			$open = preg_quote("[$bb]");
			$close = preg_quote("[/$bb]");
			$close = str_replace('/', '\\/', $close);

			$this->text = preg_replace("/^{$open}(.*?){$close}/m", "{$md} $1", $this->text);
			$this->text = preg_replace("/{$open}(.*?){$close}/", "\n{$md} $1", $this->text);
		}
		foreach (static::$bbAttributeTags as $key => $data){
			$this->text = preg_replace_callback($data['regex'], function($match) use ($data){
				$attribs = [];
				foreach ($data['attributes'] as $key => $attribute){
						$attribs["{{$key}}"] = empty($match[$attribute['value']]) ?
						(isset($attribute['default']) ?
							(is_numeric($attribute['default']) ? $match[$attribute['default']] : $attribute['default']) :
							''
						) : $match[$attribute['value']];
				}
				return strtr($data['template'], $attribs);
			}, $this->text);
		}
	}
}
<?php
class PulponairCustomMetaDescription extends KokenPlugin {

	/**
	 * Constructor registers filter
	 *
	 */
	public function __construct() {
		$this->require_setup = true;
		$this->register_filter('site.output', 'render');
	}

	/**
	 * The actual render method. Search for the meta description tag and replace it as configured.
	 *
	 * @param string $content
	 * @return string mixed
	 */
	public function render($content) {
		if ($configuration = $this->data->{Koken::$source['type']}) {
			$description = preg_replace_callback('/\{\{\s*([^\}]+)\s*\}\}/', array($this, 'kokenOutCallback'),
				$configuration);

			$content = preg_replace('/<meta.*name="description".+?>/',
				'<meta name="description" content="' . $description . '" />',
				$content);
		}

		return $content;
	}

	/**
	 * Koken::out callback
	 *
	 * @param array $matches
	 * @return array|bool|int|mixed|string|void
	 */
	public function kokenOutCallback($matches) {
		return koken::out($matches[1]);
	}

}
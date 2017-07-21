<?php
	class SVGee {
		/**
		 *	SVG Helper class.
		 *	Jovially written by Jordan (jordan.kueh@chromatix.com.au).
		 *	Version 1.1
		 */
		public static function get($svg) {
			if(is_array($svg)) { $svg = get_attached_file($svg['ID']); }
			if(is_int($svg)) { $svg = get_attached_file($svg); }
			if(SVGee::exists($svg)) { return file_get_contents($svg); }
			return false;
		}
		public static function render($svg, $output_format = "%s") {
			$contents = SVGee::get($svg);
			$contents = str_replace(array(" id='", ' id="'), array(" data-old-id='", ' data-old-id="'), $contents);
			($contents != false) && printf($output_format, $contents);
		}
		public static function exists($path) {
			if(strtolower(preg_replace('/.*\./', '', $path)) != "svg") { return false; }
			return file_exists($path);
		}
	}
?>
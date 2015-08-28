<?php

class Post {
	public static function value ($key, $default = "") {
		return (array_key_exists($key, $_POST)) ? $_POST[$key] : $default;
	}
}


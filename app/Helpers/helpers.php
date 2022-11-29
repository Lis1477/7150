<?php
if (!function_exists('end_сomment_string')) {
	function end_сomment_string($comment_count=0) {

		$num_end = $comment_count % 10;
		// определяем окончание
		if(
			($comment_count >= 11 && $comment_count <= 14)
			|| ($comment_count >= 111 && $comment_count <= 114)
			|| ($comment_count >= 211 && $comment_count <= 214)
			|| ($comment_count >= 311 && $comment_count <= 314)
			|| ($comment_count >= 411 && $comment_count <= 414)
		) {
			$str_end = 'ов';
		} else {
			if($num_end == 1)
					$str_end = '';
				elseif ($num_end >= 2 && $num_end <= 4)
					$str_end = 'a';
				else
					$str_end = 'ов';
		}

		return $str_end;
	}
}
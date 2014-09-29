<?php namespace NukaCode\Core\Html;

use HTML;

class BBCode {

	public function get()
	{
		return $this;
	}

	/**
	 * Parse a text and replace the BBCodes
	 *
	 * @access	public
	 * @param	string	$data
	 * @return	string
	 */
	public static function parse($data) {
		// Replace [table]...[/table] with <table>...</table>
		$matches["/\[table\](.*?)\[\/table\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<table class="table table-hover table-condensed table-striped">'. $data .'</table>';
		};
		// Replace [thead]...[/thead] with <thead>...</thead>
		$matches["/\[thead\](.*?)\[\/thead\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<thead>'. $data .'</thead>';
		};
		// Replace [tbody]...[/tbody] with <tbody>...</tbody>
		$matches["/\[tbody\](.*?)\[\/tbody\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<tbody>'. $data .'</tbody>';
		};
		// Replace [tr]...[/tr] with <tr>...</tr>
		$matches["/\[tr\](.*?)\[\/tr\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<tr>'. $data .'</tr>';
		};
		// Replace [th]...[/th] with <th>...</th>
		$matches["/\[th\](.*?)\[\/th\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<th>'. $data .'</th>';
		};
		// Replace [th=CLASS]...[/th] with <th class="CLASS">...</th>
		$matches["/\[th=(.*?)\](.*?)\[\/th\]/is"] = function($match) {
			return '<th class="'. $match[1] .'">'. $match[2] .'</th>';
		};
		// Replace [td]...[/td] with <td>...</td>
		$matches["/\[td\](.*?)\[\/td\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<td>'. $data .'</td>';
		};
		// Replace [td=CLASS]...[/td] with <td class="CLASS">...</td>
		$matches["/\[td=(.*?)\](.*?)\[\/td\]/is"] = function($match) {
			return '<td class="'. $match[1] .'">'. $match[2] .'</td>';
		};
		// Replace [spoiler=TITLE]...[/spoiler] with Bootstrap toggles
		$matches["/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is"] = function($match) {
			return '<div class="well well-sm"><div data-toggle="collapse" data-target="#spoiler_'. time() .'" class="text-info" onClick="$(this).children().children().toggleClass(\'fa fa-chevron-down\').toggleClass(\'fa fa-chevron-up\');"><strong>'. $match[1] .' <i class="fa fa-chevron-down pull-right"></i></strong></div><div id="spoiler_'. time() .'" class="collapse">'. $match[2] .'</div></div>';
		};
		// Replace [icon=ICON] with <i class="fa fa-ICON"></i>
		$matches["/\[icon=(.*?)\]/is"] = function($match) {
			return '<i class="fa fa-'. $match[1] .'" style="padding: 0px 5px;font-size: 14px;"></i>';
		};
		// Replace [paragraph] with <dd>
		$matches["/\[paragraph\](.*?)\[\/paragraph\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<p style="text-indent: 20px;">'. $data .'</p>';
		};
		// Replace [super]...[super] with <span style="vertical-align: super;">...</span>
		$matches["/\[super\](.*?)\[\/super\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<span style="vertical-align: super;"><small>'. $data .'</small></span>';
		};
		// Replace [sub]...[sub] with <span style="vertical-align: sub;">...</span>
		$matches["/\[sub\](.*?)\[\/sub\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return ''; }, $match[1]);
			return '<span style="vertical-align: sub;"><small>'. $data .'</small></span>';
		};
		// Replace [small]...[small] with <small>...</small>
		$matches["/\[small\](.*?)\[\/small\]/is"] = function($match) {
			$data = preg_replace_callback("/\n\r?/", function($match) { return '<br />'; }, $match[1]);
			return '<small>'. $data .'</small>';
		};

		// Replace [fullWidth]...[/fullWidth] with <div style="width: 100%;">...</div>
		$matches["/\[fullWidth\](.*?)\[\/fullWidth\]/is"] = function($match) {
			return '<div style="width: 100%;">'. $match[1] .'</div>';
		};

		// Replace [floatRight]...[/floatRight] with <div style="float: right;">...</div>
		$matches["/\[floatRight\](.*?)\[\/floatRight\]/is"] = function($match) {
			return '<div style="float: right;">'. $match[1] .'</div>';
		};

		// Replace [dice] with dice image
		$matches["/\[dice]/is"] = function($match) {
			return HTML::image('img/dice_white.png', null, array('style' => 'width: 14px;'));
		};

		// Make the :D smiley
		$matches["/\:D/is"] = function($match) {
			return HTML::image('img/smileys/Big-Grin.png', null, array('style' => 'width: 18px;'));
		};

		// Make the :P smiley
		$matches["/\:P/is"] = function($match) {
			return HTML::image('img/smileys/Tongue.png', null, array('style' => 'width: 18px;'));
		};
		$matches["/\:p/is"] = function($match) {
			return HTML::image('img/smileys/Tongue.png', null, array('style' => 'width: 18px;'));
		};

		// Make the :) smiley
		$matches["/\:\)/is"] = function($match) {
			return HTML::image('img/smileys/smile.png', null, array('style' => 'width: 18px;'));
		};

		// Make the :( smiley
		$matches["/\:\(/is"] = function($match) {
			return HTML::image('img/smileys/Sad.png', null, array('style' => 'width: 18px;'));
		};

		// Make the :'( smiley
		$matches["/:'\(/is"] = function($match) {
			return HTML::image('img/smileys/Crying2.png', null, array('style' => 'width: 18px;'));
		};

		// Make the ;) smiley
		$matches["/\;\)/is"] = function($match) {
			return HTML::image('img/smileys/Winking.png', null, array('style' => 'width: 18px;'));
		};

		// Make the <3 smiley
		$matches["/<3/is"] = function($match) {
			return HTML::image('img/smileys/Heart.png', null, array('style' => 'width: 18px;'));
		};

		// Replace [b]...[/b] with <strong>...</strong>
		$matches["/\[b\](.*?)\[\/b\]/is"] = function($match) {
			return HTML::strong($match[1]);
		};

		// Replace [i]...[/i] with <em>...</em>
		$matches["/\[i\](.*?)\[\/i\]/is"] = function($match) {
			return HTML::em($match[1]);
		};

		// Replace [code]...[/code] with <pre><code>...</code></pre>
		$matches["/\[code\](.*?)\[\/code\]/is"] = function($match) {
			return HTML::code($match[1]);
		};

		// Replace [quote]...[/quote] with <blockquote><p>...</p></blockquote>
		$matches["/\[quote\](.*?)\[\/quote\]/is"] = function($match) {
			return HTML::quote($match[1]);
		};

		// Replace [quote="person"]...[/quote] with <blockquote><p>...</p></blockquote>
		$matches["/\[quote=\"([^\"]+)\"\](.*?)\[\/quote\]/is"] = function($match) {
			return $match[1] . ' wrote: ' . HTML::quote($match[2]);
		};

		// Replace [size=30]...[/size] with <span style="font-size:30%">...</span>
		$matches["/\[size=(\d+)\](.*?)\[\/size\]/is"] = function($match) {
			return HTML::span($match[2], array('style' => 'font-size:' . $match[1] . '%'));
		};

		// Replace [s] with <del>
		$matches["/\[s\](.*?)\[\/s\]/is"] = function($match) {
			return HTML::del($match[1]);
		};

		// Replace [u]...[/u] with <span style="text-decoration:underline;">...</span>
		$matches["/\[u\](.*?)\[\/u\]/is"] = function($match) {
			return HTML::span($match[1], array('style' => 'text-decoration:underline'));
		};

		// Replace [center]...[/center] with <div style="text-align:center;">...</div>
		$matches["/\[center\](.*?)\[\/center\]/is"] = function($match) {
			return HTML::span($match[1], array('style' => 'display:block;text-align:center;'));
		};

		// Replace [color=somecolor]...[/color] with <span style="color:somecolor">...</span>
		$matches["/\[color=([#a-z0-9]+)\](.*?)\[\/color\]/is"] = function($match) {
			return HTML::span($match[2], array('style' => 'color:' . $match[1]));
		};

		// Replace [spanClass=someclass]...[/spanClass] with <span class="someclass">...</span>
		$matches["/\[spanClass=([#a-z0-9-]+)\](.*?)\[\/spanClass\]/is"] = function($match) {
			return HTML::span($match[2], array('class' => $match[1]));
		};

		// Replace [email]...[/email] with <a href="mailto:...">...</a>
		$matches["/\[email\](.*?)\[\/email\]/is"] = function($match) {
			return HTML::mailto($match[1], $match[1]);
		};

		// Replace [email=someone@somewhere.com]An e-mail link[/email] with <a href="mailto:someone@somewhere.com">An e-mail link</a>
		$matches["/\[email=(.*?)\](.*?)\[\/email\]/is"] = function($match) {
			return HTML::mailto($match[1], $match[2]);
		};

		// Replace [url]...[/url] with <a href="...">...</a>
		$matches["/\[url\](.*?)\[\/url\]/is"] = function($match) {
			return HTML::link($match[1], $match[1]);
		};

		// Replace [url=http://www.google.com/]A link to google[/url] with <a href="http://www.google.com/">A link to google</a>
		$matches["/\[url=(.*?)\](.*?)\[\/url\]/is"] = function($match) {
			return HTML::link($match[1], $match[2]);
		};

		// Replace [img]...[/img] with <img src="..."/>
		$matches["/\[img\](.*?)\[\/img\]/is"] = function($match) {
			return HTML::image($match[1]);
		};

		// Replace [img=SIZE]...[/img] with <img style="width: SIZE%;" src="..."/>
		$matches["/\[img=(.*?)\](.*?)\[\/img\]/is"] = function($match) {
			return HTML::image($match[2], null, array('style' => 'width: '. $match[1] .'%;'));
		};

		// Replace [list]...[/list] with <ul><li>...</li></ul>
		$matches["/\[list\](.*?)\[\/list\]/is"] = function($match) {
			preg_match_all("/\[\*\]([^\[\*\]]*)/is", $match[1], $items);

			return HTML::ul(preg_replace("/[\n\r?]$/", null, $items[1]));
		};

		// Replace [list=1|a]...[/list] with <ul|ol><li>...</li></ul|ol>
		$matches["/\[list=(1|a)\](.*?)\[\/list\]/is"] = function($match) {
			if($match[1] === 'a') {
				$attr = array('style' => 'list-style-type: lower-alpha');
			}

			preg_match_all("/\[\*\]([^\[\*\]]*)/is", $match[2], $items);

			return HTML::ol(preg_replace("/[\n\r?]$/", null, $items[1]), $attr);
		};

		// Replace [youtube]...[/youtube] with <iframe src="..."></iframe>
		$matches["/\[youtube\](?:http?:\/\/)?(?:www\.)?youtu(?:\.be\/|be\.com\/watch\?v=)([A-Z0-9\-_]+)(?:&(.*?))?\[\/youtube\]/i"] = function($match) {
			return HTML::iframe('http://www.youtube.com/embed/' . $match[1], array(
				'class'			=> 'youtube-player',
				'type'			=> 'text/html',
				'width'			=> 640,
				'height'		=> 385,
				'frameborder'	=> 0
			));
		};

		// Replace everything that has been found
		foreach($matches as $key => $val) {
			$data = preg_replace_callback($key, $val, $data);
		}

		// Replace line-breaks
		return preg_replace_callback("/\n\r?/", function($match) { return '<br />'; }, $data);
	}
}
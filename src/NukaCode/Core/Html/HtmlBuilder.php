<?php namespace NukaCode\Core\Html;

use Illuminate\Html\HtmlBuilder as BaseHtmlBuilder;

class HtmlBuilder extends BaseHtmlBuilder {

	/**
	 * Create a link including an image
	 *
	 * @static
	 *
	 * @param string The URL the link will point to
	 * @param string The image to use (HTML::image)
	 * @param array Any attributes the link itself should have
	 * @param boolen Determine if the link is https or http
	 *
	 * @return string
	*/
	public function linkImage($url, $imagesrc, $attributes = array(), $https = null)
	{
		$url = $this->url->to($url, $https);

		return '<a href="'.$url.'"'.static::attributes($attributes).'>'.$imagesrc.'</a>';
	}

	public function addButton($url, $iconClass = 'fa-plus')
	{
		return $this->linkIcon($url, 'fa '. $iconClass);
	}

	public function editButton ($url, $btnClass = 'primary')
	{
		return $this->link($url, 'Edit', array('class' => 'btn btn-xs btn-'. $btnClass));
	}

	public function deleteButton ($url, $btnClass = 'danger')
	{
		return $this->link($url, 'Delete', array('class' => 'confirm-remove btn btn-xs btn-'. $btnClass));
	}

	/**
	 * Create a link including twitter bootstrap icons
	 *
	 * @param string The URL the link will point to
	 * @param string Any classes the icon should have (fa fa-white, fa fa-check, etc)
	 * @param string Text to show after the icon
	 * @param array Any attributes the link itself should have
	 * @param boolen Determine if the link is https or http
	 *
	 * @return string
	*/
	public function linkIcon($url, $iconClasses, $iconText = null, $attributes = array(), $https = null)
	{
		$url = $this->url->to($url, $https);

		return '<a href="'.$url.'"'.static::attributes($attributes).'><i class="'.$iconClasses.'"></i> '. $iconText .'</a>';
	}

	/**
	 * Generate a HTML span.
	 *
	 * @param  string  $value
	 * @param  array   $attributes
	 * @return string
	 */
	public function span($value, $attributes = array())
	{
		return '<span'.static::attributes($attributes).'>'.$value.'</span>';
	}
	
	/**
	 * Generate a strong element.
	 *
	 * @access	public
	 * @param	string	$data
	 * @return	string
	 */
	public function strong($data) {
		return '<span style="font-weight: bold;">' . $data . '</span>';
	}

	/**
	 * Generate an em element.
	 *
	 * @access	public
	 * @param	string	$data
	 * @return	string
	 */
	public function em($data) {
		return '<span style="font-style: italic;">' . $data . '</span>';
	}

	/**
	 * Generate a code element.
	 *
	 * @access	public
	 * @param	string	$data
	 * @return	string
	 */
	public function code($data) {
		return '<code>' . e($data) . '</code>';
	}

	/**
	 * Generate a blockquote element.
	 *
	 * @access	public
	 * @param	string	$data
	 * @return	string
	 */
	public function quote($data) {
		return '<blockquote><p>' . $data . '</p></blockquote>';
	}

	/**
	 * Generate a del element.
	 *
	 * @access	public
	 * @param	string	$data
	 * @return	string
	 */
	public function del($data) {
		return '<del>' . $data . '</del>';
	}
	/**
	 * Generate an iframe element.
	 *
	 * @access	public
	 * @param	string	$url
	 * @param	array	$attributes
	 * @return	string
	 */
	public function iframe($url, $attributes = array()) {
		return '<iframe src="' . $url . '"' . static::attributes($attributes) . '></iframe>';
	}
}
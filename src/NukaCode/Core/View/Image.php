<?php namespace NukaCode\Core\View;

use File;
use Image as InterventionImage;

class Image {

	public $errors = array();

	public $allowedFiles = array('jpg', 'jpeg', 'png', 'gif');

	public $extension;

	public function addImage($imageDirectory, $image, $newImageName = null, $thumbnail = false)
	{
		// Make sure the image is valid
		if ($this->verifyImage($image) != true) {
			return $this;
		}

		// Set up the names
		$originalName = $image->getClientOriginalName();
		if ($newImageName == null) {
			$newImageName = str_replace('.'. $this->extension, '', $originalName);
		}

		// Make sure the directory exists
		if (!File::isDirectory($imageDirectory)) {
			File::makeDirectory($imageDirectory, 0755, true);
		}
		// Move the full image
		$image->move($imageDirectory, $originalName);

		// Delete the old image
		if (File::exists($imageDirectory .'/'. $newImageName .'.png')) {
			File::delete($imageDirectory .'/'. $newImageName .'.png');
		}

		// Make the image a png
		$newImage = InterventionImage::make($imageDirectory .'/'. $originalName)
						 ->save($imageDirectory .'/'. $newImageName .'.png');

		// Remove the original image
		File::delete($imageDirectory .'/'. $originalName);

		// make a thumbnail if needed
		if ($thumbnail == true) {
			$newImage->resize(100,100)
					 ->save($imageDirectory .'/'. $newImageName .'_thumbnail.png');
		}

		return $this;
	}

	public function verifyImage($image)
	{
		$mime      = $image->getMimeType();
		$mime      = explode('/', $mime);
		$extension = $mime[1];

		if (!in_array($extension, $this->allowedFiles)) {
			$this->addError('extension', 'The extension '. $extension .' is not allowed.');
			return false;
		}

		$this->extension = $extension;

		return true;
	}

	/**
	 * Add more than one error to the response
	 *
	 * @param  array  $errors
	 * @return CoreImage
	 */
	public function addErrors(array $errors)
	{
		$this->errors = array_merge($this->errors, $errors);

		return $this;
	}

	/**
	 * Add an error to the response
	 *
	 * @param  string  $errorKey
	 * @param  string  $errorMessage
	 * @return CoreImage
	 */
	public function addError($errorKey, $errorMessage)
	{
		$this->errors[$errorKey] = $errorMessage;

		return $this;
	}

	/**
	 * Get the currect errors
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}
}
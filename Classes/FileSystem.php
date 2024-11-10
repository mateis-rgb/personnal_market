<?php

class File 
{
	/**
	 * Summary of path
	 * @var string $path;
	 * @var string $content;
	 */
	private $path;
	private $content;
	public function __construct (string $path)
	{
		$this->path = $path;
		$this->content = "";
	}

	public function getPath (): string
	{
		return $this->path;
	}

	public function getContent (): string
	{
		return $this->content;
	}

	public function toJSON (): mixed
	{
		return json_decode($this->content);
	}

	public function readFile (): bool
	{
		$file = fopen($this->path, "r") or null;
	
		if ($file == null) return false;

		$this->content = (string) fread($file, filesize($this->path));

		fclose($file);

		return true;
	}

	public function writeFile (string $content): bool
	{
		$file = fopen($this->path, "w") or null;
		
		if ($file == null) return false;

		fwrite($file, $content . "\n");

		fclose($file);

		$this->$content = $content;

		return true;
	}
}
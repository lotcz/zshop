<?php

class Paging {
	
	static $default_size = 10;
	static $max_pages_links = 10;
	static $default_url_name = 'p';
	
	public $url_name = null;	
	public $offset = 0;
	public $limit = null;
	public $total_records = null;	
	public $filter = null;
	public $orderby = null;
	
	function __construct($offset = 0, $limit = null) {
		if (isset($limit)) {
			$this->limit = intval($limit);
		} else {
			$this->limit = Paging::$default_size;
		}		
		if (isset($offset)) {
			$this->offset = $offset;
		}
	}

	static function getFromUrl($url_name = null) {
		if (!isset($url_name)) {
			$url_name = Self::$default_url_name;
		}			
		if (isset($_GET[$url_name])) {
			$arr = explode(',', $_GET[$url_name]);
			$paging = new Paging(intval($arr[0]), intval($arr[1]));
		} else {
			$paging = new Paging();
		}
		$paging->url_name = $url_name;
		return $paging;
	}

	public function getLinks($base_url) {
		$links = [];
		$pages_count = ceil($this->total_records / $this->limit);
		if ($pages_count > 1) {
			
			if ($this->offset == 0) {
				$class = 'disabled';
				$href = $base_url . '?' . $this->url_name . '=0,' . $this->limit;
			} else {
				$class = '';
				$offset = $this->offset - $this->limit;
				if ($offset < 0) {
					$offset = 0;
				}
				$href = $base_url . '?' . $this->url_name . '=' . $offset . ',' . $this->limit;
			}	
		
			$links[] = [
				'class' => $class,
				'href' => $href,
				'title' => '&#10094;'
			];			
			
			$skip = 1; // print all links
			if ($pages_count > Self::$max_pages_links) {
				$skip = floor($pages_count / Self::$max_pages_links);
			}
			for ($i = 1, $max = $pages_count; $i <= $max; $i += $skip) {
				$link = [];
				$link['class'] = '';
				$offset = ($i - 1) * $this->limit;				
				$link['href'] = $base_url . '?' . $this->url_name . '=' . $offset . ',' . $this->limit;
				if (isset($this->filter)) {
					$link['href'] .= '&s=' . $this->filter;
				}
				if ($this->offset == $offset) {
					$link['class'] = 'disabled';
				}
				$link['title'] = $i;
				$links[] = $link;
			}
			
			$offset = $this->offset + $this->limit;
			if ($offset > $this->total_records) {
				$class = 'disabled';
				$href = $base_url . '?' . $this->url_name . '=' . $this->offset . ',' . $this->limit;
			} else {
				$class = '';
				$href = $base_url . '?' . $this->url_name . '=' . $offset . ',' . $this->limit;
			}	
		
			$links[] = [
				'class' => $class,
				'href' => $href,
				'title' => '&#10095'
			];				
		}
		return $links;
	}
	
	public function getInfo() {
		$upper = $this->offset + $this->limit;
		if ($upper > $this->total_records) {
			$upper = $this->total_records;
		}
		return t('%d - %d of %d', $this->offset+1, $upper, $this->total_records);
	}

	public function renderLinks() {

		$links = $this->getLinks('');
	
		if (count($links) > 0) {
			?>
				<div class="text-center">
					<div class="panel panel-primary">
						<?php
							foreach ($links as $link) {						
								?>
									<a class="btn btn-sm btn-default <?=$link['class'] ?>" href="<?=$link['href']?>"><?=$link['title']?></a>
								<?php						
							}
						?>
					</div>
				</div>
			<?php
		}
	}
		
}
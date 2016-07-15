<?php

class Paging {
	
	static $default_size = 12;
	static $max_pages_links = 10;
	static $default_url_name = 'p';
	static $sorting_url_name = 's';
	
	public $url_name = null;	
	public $offset = 0;
	public $limit = null;
	public $total_records = null;	
	public $filter = null;
	public $orderby = null;
	
	public $sorting_items = [];
	public $active_sorting = 0;
	
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

	static function getFromUrl($sorting_items = null) {		
		
		if (isset($_GET[Paging::$default_url_name])) {
			$arr = explode(',', $_GET[Paging::$default_url_name]);
			$paging = new Paging(intval($arr[0]), intval($arr[1]));
		} else {		
			$paging = new Paging();
		}
		
		if (isset($sorting_items) && count($sorting_items) > 0) {
			$paging->sorting_items = $sorting_items;
			if (isset($_GET[Self::$sorting_url_name])) {
				$paging->active_sorting = $_GET[Self::$sorting_url_name];
			}
			if (!isset($paging->sorting_items[$paging->active_sorting])) {
				reset($paging->sorting_items);
				$paging->active_sorting = key($paging->sorting_items);
			}
		}
		
		return $paging;
	}

	static function getLinkUrl($offset = 0, $limit = null, $sorting = null) {
		$url = '?';
		if (!isset($limit)) {
			$limit = Paging::$default_size;
		}
		$url .= sprintf('%s=%d,%d',Paging::$default_url_name, $offset, $limit);
		if (isset($sorting)) {
			$url .= sprintf('&%s=%s',Paging::$sorting_url_name, $sorting);
		}
		return $url;
	}
	
	public function getLinks($base_url) {
		$links = [];
		$pages_count = ceil($this->total_records / $this->limit);
		if ($pages_count > 1) {
			
			if ($this->offset == 0) {
				$class = 'active';
				$href = Paging::getLinkUrl(0, $this->limit, $this->active_sorting);
			} else {
				$class = '';
				$offset = $this->offset - $this->limit;
				if ($offset < 0) {
					$offset = 0;
				}
				$href = Paging::getLinkUrl($offset, $this->limit, $this->active_sorting);
			}	
		
			$links[] = [
				'class' => $class,
				'href' => $href,
				'title' => '&#10094;'
			];			
			
			$skip = 1; // print all links
			if ($pages_count > Self::$max_pages_links) {
				//$skip = floor($pages_count / Self::$max_pages_links);
			}
			for ($i = 1, $max = $pages_count; $i <= $max; $i += $skip) {
				$link = [];
				$link['class'] = '';
				$offset = ($i - 1) * $this->limit;				
				$link['href'] = Paging::getLinkUrl($offset, $this->limit, $this->active_sorting);
				if (isset($this->filter)) {
					$link['href'] .= '&s=' . $this->filter;
				}
				if ($this->offset == $offset) {
					$link['class'] = 'active';
				}
				$link['title'] = $i;
				$links[] = $link;
			}
			
			$offset = $this->offset + $this->limit;
			if ($offset > $this->total_records) {
				$class = 'active';
				$href = Paging::getLinkUrl($this->offset, $this->limit, $this->active_sorting);
			} else {
				$class = '';
				$href = Paging::getLinkUrl($offset, $this->limit, $this->active_sorting);
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

	public function getOrderBy() {
		if (isset($this->sorting_items) && count($this->sorting_items) > 0) {
			return $this->sorting_items[$this->active_sorting];
		}
	}
	
	public function renderLinks() {

		$links = $this->getLinks('');
	
		if (count($links) > 0) {
			?>
				<nav>
					<ul class="pagination">
						
						<?php
							foreach ($links as $link) {						
								?>
									<li class="<?=$link['class'] ?>"><a href="<?=$link['href']?>"><?=$link['title']?><span class="sr-only">(current)</span></a></li>						
								<?php						
							}
						?>
						
					</ul>
				</nav>				
			<?php
		}
	}
	
	public function renderSorting() {
		renderPartial('prod-sort', $this);		
	}

}
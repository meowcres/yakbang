<?
class paging{
	var $url ;						// 이동 주소
	var $queryString ;		// queryString	
	var $offset ;					// 페이지 단위 숫자
	var $page_block ;			// 페이지 블록 숫자
	var $total_record ;		// 전체 페이지 수
	var $total_block ;		// 전체 블록 수
	var $page ;						// 현재 페이징 숫자	
	var $block ;					// 블록
	var $first_block ;		// 시작블록
	var $last_block ;			// 끝블록
	var $preIcon ;				// 이전 이미지
	var $nextIcon ;				// 다음 이미지
	var $get_values ;			// get 변수로 이동될 값

	function paging($url,$queryString,$offset,$page_block,$total_record,$page,$get_values){
		$this->url          = $url ;
		$this->queryString  = $queryString ;
		$this->offset       = $offset ;
		$this->page_block   = $page_block ;
		$this->total_record = $total_record ;
		$this->page         = $page ;
		$this->get_values   = $get_values ;
	}

	

	

	function pagingArea($preIcon,$nextIcon){
		if(!isNull($preIcon)) $this->preIcon = $preIcon ;
		else                  $this->preIcon = "◁" ;

		if(!isNull($nextIcon)) $this->nextIcon = $nextIcon ;
		else                   $this->nextIcon = "▷" ;

		// 화면출력 
		$this->pagePrint() ;	
	}

	function pagePrint(){

    $this->total_block = ceil($this->total_record / $this->offset) ;
		$this->block       = ceil($this->page / $this->page_block) ;
		$this->first_block = (($this->block - 1) * $this->page_block)+1 ;
		$this->last_block  = $this->block * $this->page_block ;
		$this->last_block  = $this->last_block < $this->total_block ? $this->last_block : $this->total_block ;

		// 이전 아이콘
		if($this->first_block > $this->page_block){
			$prepage    = $this->first_block - 1 ;
			$pre_option = "page=".$prepage."&".$this->queryString ;
			$pre_option = $pre_option ;
			$pre_url    = $this->url."?".$pre_option ;

			if(!isNull($this->get_values)){
				$pre_url .= "&".$this->get_values ;
			}

			echo "<a href='".$pre_url."' style='color:#000;'>".$this->preIcon."</a>&nbsp;" ;
		}

		// 페이징 1 2 3 4 5 ..
		for($i=$this->first_block;$i<=$this->last_block;$i++){
			$link_option = "page=".$i."&".$this->queryString ;
			$link_option = $link_option ;
			$link_url = $this->url."?".$link_option ;

			if(!isNull($this->get_values)){
				$link_url .= "&".$this->get_values ;
			}

			if($i == $this->page){
				echo "&nbsp;<b style='border:1px solid #000;background-color:#000;color:#fff;padding:5px 10px;'>".$i."</b>&nbsp;";
			}
			else{
				echo "&nbsp;<a href='".$link_url."' style='border:1px solid #000;color:#000;padding:5px 10px;'>".$i."</a>&nbsp;";
			}
		}

		// 다음 아이콘
		if($this->last_block < $this->total_block){
			$nextpage    = $this->last_block + 1 ;
			$next_option = "page=".$nextpage."&".$this->queryString ;
			$next_option = $next_option ;
			$next_url    = $this->url."?".$next_option ;

			if(!isNull($this->get_values)){
				$next_url .= "&".$this->get_values ;
			}

			echo "&nbsp;<a href='".$next_url."' style='color:#000;'>".$this->nextIcon."</a>" ;
		}

	}

}
?>
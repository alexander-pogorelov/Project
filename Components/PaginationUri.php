<?php
class PaginationUri {
	private $pageNumber;
	private $pagesAmount;
	private $paginationList;
	private $fileName;
	private $index;
	
	public function __construct ($pageNumber, $pagesAmount, $index) {

		$this->pageNumber=$pageNumber;
		$this->pagesAmount=$pagesAmount;
		$this->paginationList="";	
		$this->index=$index;	
	}
	public function run () {// Функция формирования строки ссылок на страницы гостевой книги

		$currentURI = rtrim($_SERVER['REQUEST_URI'], '/');
		//echo "URI:$currentURI<br>";

		//$pattern = '~/' . $this->index . '[0-9]+~';
        $pattern = '~/' . $this->index.'.*~';
        //echo "Patern: $pattern<br>";
		$currentURI = preg_replace($pattern, '', $currentURI) . '/';
        //echo "New URI: $currentURI<br>";
        //echo "Index: $this->index<br>";

		$start = $this->pageNumber - PAGINATION_INDENT;
		if ($start<1) $start = 1;
		
		$finish = $this->pageNumber + PAGINATION_INDENT;
		if ($finish>$this->pagesAmount) $finish = $this->pagesAmount;

		$newStart=$this->pageNumber-2*PAGINATION_INDENT-1;// создание ссылки на предыдущие странички
		if ($newStart <= 1) {
			$newStartString="";
		}
		else {
			$newStartString='<a href="'.$currentURI . $this->index . $newStart.'">&lt;</a>&nbsp';
		}
        //echo "newStartString: $newStartString<br>";
		
		$newFinish=$this->pageNumber+2*PAGINATION_INDENT+1;// создание ссылки на последующие странички
		if ($newFinish > ($this->pagesAmount -1)) {
			$newFinish = $this->pagesAmount;
			$newFinishString="";
		}else {
			$newFinishString='<a href="'.$currentURI . $this->index . $newFinish.'">&gt;</a>&nbsp;';
			}
        //echo "newFinishString: $newFinishString<br>";
		if ($this->pageNumber <= (PAGINATION_INDENT+1)){
			$startString = "";
		}
		else {
			$startString = '<a href="' . $currentURI . $this->index . '1">&lt;&lt;</a>&nbsp;';
		}
        //echo "startString: $startString<br>";
		if ($this->pageNumber > ($this->pagesAmount - PAGINATION_INDENT-1)) {
			$finishString = "";
		}else {
			$finishString = '<a href="'. $currentURI . $this->index . $this->pagesAmount.'">&gt;&gt;</a>&nbsp;';
		}
        //echo "finishString: $finishString<br>";
		
		
		
		$this->paginationList = $startString . $newStartString;// вывод ссылок на первую страницу и на предыдущие странички
		for ($i = $start; $i<=$finish; $i++) {// цикл вывода ссылок
			if ($i==$this->pageNumber)
				$this->paginationList=$this->paginationList.$i.'&nbsp;';
			else				
				$this->paginationList=$this->paginationList.'<a href="'. $currentURI . $this->index . $i.'">'.$i.'</a>&nbsp;';
		}
		$this->paginationList=$this->paginationList . $newFinishString . $finishString;// вывод ссылок на последнюю страницу и на последующие странички
		
		//echo $this->paginationList;
		//echo 'URI: ' . $_SERVER['REQUEST_URI'] . '<br>';
	}
	public function getPaginationList() {// функция возврата строки ссылок
		//echo $this->paginationList;
		return $this->paginationList;
	}
}